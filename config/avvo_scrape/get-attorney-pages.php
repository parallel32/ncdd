<?php
include_once __DIR__.'/../../src/Saw/Provider/HtmlDOM/simple_html_dom.php';

if(true):
$files = scandir('./lists');
$file_count = count($files);
$i=0;
$list_processed = true;
foreach ($files as $file) {
    $i++;
    if($file !== '.' && $file !== '..'):
        
        // don't reprocess anything
        $apf = file_get_contents('./processed-lists.txt');
        $apfa = explode(',', $apf);
        if(!in_array($file, $apfa)){

            echo "processing - ".$file." ... ".$file_count." of ".$i."\r\n";
            $file_parts = explode('-', $file);
            $content = file_get_contents('./lists/'.$file);        
            $html = new \simple_html_dom();
            $html->load($content);

            $element = $html->find('div[id=results] ol li');
            foreach($html->find('div[id=results] ol li') as $item):
                $name = $item->find('span[class=name result_title] h3 a');
                $file_attorney = './pages/'.$file_parts[0].'-page-'.$name[0]->innertext.'.txt';
                $the_page_url = "http://www.avvo.com".$name[0]->href;
                $attorney_page_contents = file_get_contents($the_page_url);
                if(!empty($attorney_page_contents)){
                    file_put_contents($file_attorney, $attorney_page_contents);
                    
                    $h = fopen("./processed-pages.txt", "a");
                    fwrite($h, $file_attorney.",");
                    fclose($h);        

                    $sleep = rand(2,45);
                    echo $file_attorney." +".$sleep."\r\n";
                    sleep($sleep);
                }else{
                    $list_processed = false;
                    $h = fopen("./re-process-pages.txt", "a");
                    fwrite($h, $file_attorney.",");
                    fclose($h);        
                }

            endforeach;
        }// end skipping lists already processed

    if($list_processed){
        $h = fopen("./processed-lists.txt", "a");
        fwrite($h, $file.",");
        fclose($h);        
    }else{
        $h = fopen("./re-process-lists.txt", "a");
        fwrite($h, $file.",");
        fclose($h);        
    }
    endif;
}


endif;
?>