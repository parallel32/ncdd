<script src="js/Bebas_Neue_400.font.js" type="text/javascript"></script>
    <script src="js/Ubuntu_Condensed_400.font.js" type="text/javascript"></script>
    <script src="js/Bree_Serif_400.font.js" type="text/javascript"></script>
    <script type="text/javascript">
    Cufon.replace('.bc,#mainnav a,.pagetitle,h2,.blue1', { fontFamily: 'Bebas Neue' });
    Cufon.replace('.uc', { fontFamily: 'Ubuntu Condensed' });
    Cufon.replace('.bs', { fontFamily: 'Bree Serif' });
    </script>

<style>
@font-face {
  font-family: 'Bree Serif';
  font-style: normal;
  font-weight: 400;
  src: local('Bree Serif'), local('BreeSerif-Regular'), url(http://themes.googleusercontent.com/static/fonts/breeserif/v2/LQ7WLTaITDg4OSRuOZCps73hpw3pgy2gAi-Ip7WPMi0.woff) format('woff');
}
.mainMenu .tab-content .tab-pane{display:none}

.mainMenu .fullWidthDropDown.dropdown-menu .close{replace right:0px with left:220px}

.boardCertificationDescr .tab-content > .tab-pane{ display:none;}

.tab-pane.active.text-center{display:none;}

.mainMenu .fullWidthDropDown.dropdown-menu .close{left:26%;}
.mainMenu .fullWidthDropDown.dropdown-menu {width:100%;}
.mainMenu .fullWidthDropDown.dropdown-menu #learnTab {
  margin-top: 17px;
  margin-right: 0;
}
.dropdown-menu.discover.fullWidthDropDown.specialwidthsetting { padding:0 0 0 20px; width:30%;}
.dropdown-menu.learn.fullWidthDropDown.specialwidthsetting { padding:0 0 0 20px; width:30%;}
</style>
<style type="text/css">
ul.inline{ margin-top: -12px;}
ul.inline li{ display: inline;}
span.phone{font-weight: bold;
  font-size: 25px;
  color: #2f91e4;}
  .profilewrap{ border:thin solid #ccc; display: block; min-height: 250px; padding: 10px; margin-top: 40px;}
  .hrdotted{ margin-top: 0px; }
  ul.socialicons li {
display: inline;
}
.tr{ text-align: right;}
.blue1 {
color: #47769e;
}
.orange {
color: #ff6600;
font-weight: 500;
}
span.orange{ color: #ff6000}
iframe{width: 98%;}
.hrdotted {
border-bottom: thin dashed #ccc;}
.tc{ text-align: center;}
#memberprofile{ padding-bottom: 40px;}
.borderright {
border-right: thin dashed #ccc;
}
#placeholder {
width: 450px;
height: 250px;
}
#practice-cases{ visibility: hidden;}
.pagecontent .container-fluid{ padding: 15px; }
.duplicate .span12{ margin-left: 0px;}
.duplicate{ display: none; margin-top: 200px;}
img.thumbnail{ max-width: 100%;}
@media( max-width: 400px){
 #placeholder{ width: 250px; height: 200px}
}
@media( max-width: 786px){
    .tr,.tc { text-align: left;}
    .contact{ padding: 15px;}
    .contact .span5{ margin-bottom: 10px}
    .legend{ display: none;}
    .profilewrap {
    border: none;
    }
    .borderright{ border-right: none;}
}
@media( max-width: 1024px){
    .legend{ display: none;}

}
@media( min-width: 768px) and (max-width: 1024px){
    .phone, .span12.urls{ display: none;}
    .duplicate{ display: block;}

}
  </style>
                    <? $member = $this->vars['member']; ?>
                    <div class="container-fluid" id="memberprofile">
                      <div class="row-fluid">
                        <div class="pagecontent">
                          <div class="profilewrap">
                            <div class="span2">
                              <img width="160" src="<?=$member['image']?>" class="thumbnail" alt="profilepic"/>
                            </div>
                            <div class="span4 tc">
                                <? $middleName = (!empty($member['middleName'])) ? ' '.$member['middleName'].' ':' '; ?>
                                <h2 class="blue1"><?=$member['firstName']?><?=$middleName?><?=$member['lastName']?></h2>
                                <!--
                                <span class="orange"><?=$member['currentMembership']?></span><br>
                                <?if(!empty($member['currentFacultyPosition'])):?>
                                    <span class="orange"><?=$member['currentFacultyPosition']?></span><br>
                                <?endif;?>
                                -->
                                <div class="clear"></div>
                                <br>
                                <img width="100" src="http://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$member['_id']?>/member" alt="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" />
                                <? if($member['staff'] =='Yes'): ?>
                                <img width="100" src="http://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$member['_id']?>/staff" alt="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" />
                                <? endif; ?>
                                <? if($member['boardCertified'] =='Yes'): ?>
                                <img width="120" src="http://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$member['_id']?>/boardcertified" alt="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" />
                                <? endif; ?>
                            </div>
                            <div class="span6 contact">
                              <div class="span5">
                                <ul class="inline">
                                  <? if(!empty($member['currentFacultyPosition'])): ?>
                                      <li><img class="" src="http://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$member['_id']?>/exec" alt="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" /></li>
                                  <? endif; ?>
                                </ul>
                              </div>
                              <div class="span7 tr">
                                <a href="mailto:<?=$member['email']?>" ><img src="/assets/img/contactme.png" alt="contact"></a><br><br>
                                <ul class="socialicons">
                                  <? if(!empty($member['linkedInUrl'])): ?>
                                  <li><a href="//<?=$member['linkedInUrl']?>" target="_blank"><img src="/assets/img/ln.png" alt="linkedin"></a></li>
                                  <? endif; ?>
                                  <? if(!empty($member['googlePlusUrl'])): ?>
                                  <li><a href="//<?=$member['googlePlusUrl']?>" target="_blank"><img src="/assets/img/gplus.png" alt="googleplus"></a></li>
                                  <? endif; ?>
                                  <? if(!empty($member['twitterUrl'])): ?>
                                  <li><a href="//<?=$member['twitterUrl']?>" target="_blank"><img src="/assets/img/twitter.png" alt="tweets"></a></li>
                                  <? endif; ?>
                                  <? if(!empty($member['facebookUrl'])): ?>
                                  <li><a href="//<?=$member['facebookUrl']?>" target="_blank"><img src="/assets/img/fb.png" alt="fb"></a></li>
                                  <? endif; ?>
                                </ul>
                                  <br>
                                  <span class="phone bc">Call Now: <a href="tel:<?=$member['primaryPhone']?>"><?=$member['primaryPhone']?></a></span>
                              </div>
                              <div class="span12 urls">
                                <br>
                                <div class="span5">                 
                                  <? if(!empty($member['specializeIn'])): ?>
                                  <a href="#" class="orange"><i class="icon-map-marker"></i> Specialize in <?=$member['specializeIn']?></a>
                                  <? endif; ?>
                                </div>
                                <div class="span6">
                                  <? if(!empty($member['websites'])): ?>
                                      <a class="orange" href="//<?=$member['websites'][0]['website']?>"><i class="icon-share orange"></i> <?=$member['websites'][0]['website']?></a>
                                  <? endif; ?>
                                </div>
                              </div>
                            </div>
                            <div class="row-fluid duplicate">
                                <div class="span12">
                                    <span class="phone span12 bc">Call Now: <a href="tel:<?=$member['primaryPhone']?>"><?=$member['primaryPhone']?></a></span>
                                    <div class="span12">                 
                                      <? if(!empty($member['specializeIn'])): ?>
                                      <a href="#" class="orange"><i class="icon-map-marker"></i> Specialize in <?=$member['specializeIn']?></a>
                                      <? endif; ?>
                                    </div>
                                    <div class="span12">
                                      <? if(!empty($member['websites'])): ?>
                                      <a href="//<?=$member['websites'][0]['website']?>" class="orange"><i class="icon-share orange"></i> <?=$member['websites'][0]['website']?></a>
                                      <? endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
            <div class="clear"></div>
            <br>
            <div class="container-fluid">
              <div class="row-fluid">
                <? if(!empty($member['locations'])): ?>
                <div class="span6"><i class="icon-map-marker"></i>  <a href="/member/<?=$member['_id']?>/<?=$member['slug']?>"><?=$member['locations'][0]['raw']?></a></div>
                <? endif; ?>
                <div class="span3">
                <? $i=0; foreach($member['websites'] as $website): ?>
                <i class="icon-share orange"></i>  <a href="//<?=$website['website']?>" alt="<?=$website['websiteDesc']?>" title="<?=$website['websiteDesc']?>"><?=$website['website']?></a>
                <? $i++; if($i == count($member['websites']) - 1){ echo "<br>";} ?>
                <?
                endforeach; ?>
                </div>
              </div>
            </div>
        <hr class="hrdotted"> 
        <div class="clear"></div>
        <div class="container-fluid">
          <div class="row-fluid">
           <div class="span6 row1">
              <h3 class="blue1">Contact Information</h3>
              <? if(count($member['locations']) < 2): ?>
              <iframe  class="thumbnail" height="140" src="https://maps.google.com/maps?f=d&amp;source=s_d&amp;saddr=<?=$member['locations'][0]['raw']?>&amp;daddr=&amp;hl=en&amp;geocode=&amp;aq=0&amp;oq=<?=$member['locations'][0]['raw']?>&amp;mra=ls&amp;ie=UTF8&amp;t=m&amp;z=14&amp;output=embed"></iframe>
              <? endif; ?>
              <br>
              <?foreach($member['locations'] as $location): ?>
              <div class="span5">
                <address>
                  <strong class="muted"><?=$location['name']?></strong><br>
                  <?=$location['addressLine1']?><br>
                  <? if(!empty($location['addressLine2'])) { ?> <?=$location['addressLine2']?><br> <? } ?>
                  <?=$location['city']?>, <?=$location['state']?> <?=$location['zip']?> <br>
                  <? if (!empty($location['phone'])): ?><strong>Office: </strong> <?=$location['phone']?><br><? endif; ?>
                  <? if (!empty($location['tollFree'])): ?><strong>Toll Free: </strong> <?=$location['tollFree']?><br><? endif; ?>
                  <? if (!empty($location['fax'])): ?><strong>Fax: </strong> <?=$location['fax']?><br><? endif; ?>
                  <strong>Map: </strong><a target="_blank" href="https://www.google.com/maps/preview#!q=<?=$location['raw']?>">Click to Map</a>
                </address>
              </div>
              <? endforeach; ?>   
           </div>
    <div class="span6">
      <h3 class="blue1">About Me</h3>
      <?=$member['aboutMe']?>
    </div>
    </div>
    <div class="clear"></div>
                <hr class="hrdotted">
                <div class="container-fluid">
                <div class="row-fluid">
                <? if(!empty($member['financialFees']) || !empty($member['financialPayment'])): ?>
                <div class="span3 borderright">
                    <h5 class="blue1">Financial:</h5>
                    <? if(!empty($member['financialFees'])): ?>
                    <strong>Fees:</strong><br>
                    <?=$member['financialFees']?>
                    <br>
                    <? endif; ?>
                    <? if(!empty($member['financialPayment'])): ?>
                    <strong>Payment:</strong><br>
                    <?=$member['financialPayment']?>
                    <? endif; ?>
                </div>
                <? endif; ?>
                <? if(!empty($member['languages'])): ?>
                <div class="span2 borderright">
                  <h5 class="blue1">Languages:</h5>
                  <ul>
                    <? foreach($member['languages'] as $lang): ?>
                    <li><?=$lang['language']?></li>
                    <? endforeach; ?>
                   </ul>
                </div>
                <? endif; ?>
                <? if(!empty($member['practiceAreas'])): ?>
                <div class="span6">
                  <h4 class="blue1">Practice and Cases:</h4>
                  <div id="placeholder"  class="demo-placeholder"></div>
                  <button id="practice-cases">Label Radius</button>
                </div>
                <? endif; ?>
                <div class="clear"></div>
    </div>
    </div>

    </div>
    </div>
    </div>
    </div>


<? if(!empty($member['practiceAreas'])): ?>
    <!-- PIE CHART -->
<!-- http://www.flotcharts.org/flot/examples/series-pie/index.html -->
<script type="text/javascript" src="/assets/js/jquery.flot.js"></script>
<script type="text/javascript" src="/assets/js/jquery.flot.pie.js"></script>
<script type="text/javascript">

$(function() {

    //Data
    var data = [
    <? foreach($member['practiceAreas'] as $pa): 
      $paa = addslashes($pa['pa']);
    ?>
          { label: "<?=$paa?>",  data: <?=$pa['percent']?>},
    <? endforeach; ?>
    ];

    var placeholder = $("#placeholder");

    $("#practice-cases").click(function() {
      placeholder.unbind();
      $.plot(placeholder, data, {
        series: {
          pie: { 
            show: true,
            radius: 1,
            label: {
              show: true,
              radius: 3/4,
              formatter: labelFormatter,
              background: {
                opacity: 0.5
              }
            }
          }
        },
        legend: {
          show: true
        }
      });

      setCode([
        "$.plot('#placeholder', data, {",
          "    series: {",
          "        pie: {",
          "            show: true,",
          "            radius: 1,",
          "            label: {",
          "                show: true,",
          "                radius: 3/4,",
          "                formatter: labelFormatter,",
          "                background: {",
          "                    opacity: 0.5",
          "                }",
          "            }",
          "        }",
          "    },",
          "    legend: {",
          "        show: false",
          "    }",
          "});"
      ]);
    });
    // Show the initial default chart

    $("#practice-cases").click();

  });

  // A custom label formatter used by several of the plots
  function labelFormatter(label, series) {
    return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
  }
  function setCode(lines) {
    $("#code").text(lines.join("\n"));
  }
  </script>   
  <? endif; ?>