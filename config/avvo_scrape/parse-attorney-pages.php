<?php
// get name
// span[itemprop=name] innertext
// get all address details
// foreach:
//  div[id=contact_information_section] div[class=address_sort]
//  div[class=address_name]
//  div[class=address_line_1]
//  div[class=address_line_2]
//  div[class=address_city_state]
//  div[class=address_phone]
//  foreach phone...
//    .. get the phones
// to get the website
//  a[itemprop=url]
include_once __DIR__.'/../../src/Saw/Provider/HtmlDOM/simple_html_dom.php';

if(true):
$files = scandir('./pages');
foreach ($files as $file) {
    if($file !== '.' && $file !== '..' && $file !== '.DS_Store'):
        
        echo "processing - ".$file."\r\n";
        $content = file_get_contents('./pages/'.$file);        
        $html = new \simple_html_dom();
        $html->load($content);

        // get the name
        $element = $html->find("div[id=profile_header]");
        $ele2 = $element[0]->find("span[itemprop=name]");
        $attorney_name = trim((is_array($ele2) && count($ele2) > 0) ? $ele2[0]->plaintext: '');
        
        foreach($html->find('div[id=contact_information_section] div[class=address_sort]') as $item):
            $csv_string = '';
            $csv_string = '"'.$attorney_name.'"'.',';
            echo "\r\n".$attorney_name;        

            $addr_name = $item->find('div[class=address_name]');
            $addr_name = (is_array($addr_name) && count($addr_name) > 0) ? html_entity_decode($addr_name[0]->plaintext) :'';
            echo "\r\n".$addr_name;
            $csv_string = $csv_string.'"'.$addr_name.'"'.',';
            
            $addr_line1 = $item->find('div[class=address_line_1]');
            $addr_line1 = html_entity_decode($addr_line1[0]->plaintext);
            echo "\r\n".$addr_line1;
            $csv_string = $csv_string.'"'.$addr_line1.'"'.',';
            
            $addr_line2 = $item->find('div[class=address_line_2]');
            $addr_line2 = html_entity_decode($addr_line2[0]->plaintext);
            if(!empty($addr_line2)){
                echo "\r\n".$addr_line2;
            }
            $csv_string = $csv_string.'"'.$addr_line2.'"'.',';
            
            $address_city_state = $item->find('div[class=address_city_state]');
            $address_city_state = html_entity_decode($address_city_state[0]->plaintext);
            echo "\r\n".$address_city_state;
            $csv_string = $csv_string.'"'.$address_city_state.'"'.',';
            
            $phones = '';
            foreach($item->find('div[class=address_phone]') as $phone){
                $phones = $phones.' '.html_entity_decode($phone->plaintext);                
            }
            echo "\r\n".$phones;
            $csv_string = $csv_string.'"'.$phones.'"'."\r\n";

            echo "\r\n";
            echo "\r\n";
            
            $h = fopen("./avvo_attorneys.csv", "a");
            fwrite($h, $csv_string);
            fclose($h);        
        endforeach;
    endif;
}

endif;
?>