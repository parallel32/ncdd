<style>
@font-face {
  font-family: 'Bree Serif';
  font-style: normal;
  font-weight: 400;
  src: local('Bree Serif'), local('BreeSerif-Regular'), url(<?=SAW_PUBLIC_SSL_CDN?>/assets/fonts/LQ7WLTaITDg4OSRuOZCps73hpw3pgy2gAi-Ip7WPMi0.woff) format('woff');
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
.pagecontent{ background-color: #fff;}
#learn{ padding-bottom: 20px;}
.center{ text-align: center;}
.center h1{color:#47769e; text-transform: uppercase; padding: 10px 0px}
.country{ background-color: #ccc; padding: 5px; text-align: center; color: #fff;}
.selectstate{ background-color: rgb(83,168,235); color: #fff; padding: 5px;}
ul.sidebarlist{ border-right: thin solid #ccc; border-bottom: thin solid #ccc; border-left:thin solid #ccc;}
ul.sidebarlist li {
  margin-top: 0px;
  border-bottom: none;
  line-height: 30px;
  padding-left: 10px;}
  ul.sidebarlist li a{ font-size: 15px; text-transform: uppercase;}
  img.searchlayerimg{ float: left;}
  .searchresultswrap{ padding: 10px;}
  .laywername{ font-size: 24px;color:#47769e; }
  .orange.meta{ font-weight: 200; font-size: 12px;  text-transform: uppercase;}
  .searchresultswrap.tc{ margin-left: 0px; background: #f1f1f2 right top no-repeat;}
  .delegation{top: -114px;
    position: relative;
    right: -275px;}
  .delegationone {
    right: -225px;
    margin-top: -230px;
    position: relative;}
    .tl{ text-align: left;}
    .searchmetafooter a{ color: #666;}
    .searchmeta div span.phone {
        font-weight: bold;
        font-size: 25px;
        color: #2f91e4;
    }
    .searchmeta {
        text-align: left;
        margin-bottom: 5px;
        padding-bottom: 15px}
    .tc {
        text-align: center;
    }
    .orange.meta {
        font-weight: 200;
        font-size: 12px;
        text-transform: uppercase;
        color: #ff6600;
    }
    .searchmeta div:first-of-type {
        border-right: thin solid #ccc;
    }
    .searchmetafooter {     
       border-top: thin #ccc solid;
       padding-top: 8px;
    }
    .mapsPhone{ width: 99%}
    @media(max-width: 320px){
        .searchmeta img.shield:first-of-type{ margin-bottom: 10px; }
        .searchmeta{ padding: 0px}
    }
    @media(max-width: 786px){
        .searchmeta{ padding: 0px}
        .searchmeta .tc{ text-align: left;}
        .searchmeta .span5{ padding-top: 10px}
        .searchmeta div:first-of-type{ border: none;}
        img.searchlayerimg{ margin-right: 10px}
        .tc.searchresultswrap{ text-align: left;}


    }
    @media(width: 800px){
    .searchmetafooter div.span3,.searchmetafooter div.span8{width: 100%; margin-left: 0px;}
    .searchmetafooter div.span1{ float: left; margin-left: 0px;width: 100%;}
    }
    @media(min-width: 786px){               
     .searchmeta{ padding: 10px}
    }
    @media( max-width: 800px){

        .searchmeta div:first-of-type{ border: none;}
         .tc.searchresultswrap{ text-align: left;}
    }
    @media (max-width: 1024px) { 
        .delegationone,.delegation{ top: auto; margin-top: 0px; right: auto;}
    }

            </style>



<div class="container"><div class="title text-center">
<div class="bg">
<h3><?=$this->vars['state']?> State Delegates</h3>
</div>
</div></div>
<div class="container-fluid pagecontent" id="learn">
    <div class="row-fluid">
        <div class="center span12 bc">
            <div class="dropdown visible-phone mapsPhone">
                <a class="dropdown-toggle btn" href="javascript:void(0)">
                    Select A State
                    <b class="caret"></b>
                </a>
                <ul class="mapsPhoneDropdown">
                    <? foreach($this->vars['delegate_states'] as $country=>$state): ?>
                    <li class="titleMap"><?=strtoupper($country)?></li>
                    <? foreach($this->vars['delegate_states'][$country] as $state): ?>
                    <li><a href="/state-delegates/<?=$country?><?=$state['slug']?>"><?=$state['state']?></a></li>
                    <? endforeach; ?>
                    <? endforeach; ?>
                </ul>
            </div>
       </div> 
        <div class="pagecontent ">
            <div class="span2 hidden-phone">
              <div class="selectstate center bc">SELECT A STATE</div>
              <? foreach($this->vars['delegate_states'] as $country=>$state): ?>
              <div class="country bc"><?=strtoupper($country)?></div>
              <ul class="sidebarlist bc">
                <? foreach($this->vars['delegate_states'][$country] as $state): ?>
                <li><a href="/state-delegates/<?=$country?><?=$state['slug']?>"><?=$state['state']?></a></li>
                <? endforeach; ?>
             <? endforeach; ?>

            </ul>
        </div>
        <div class="cityNameBlock">
            <h5 class="cityName pull-left"></h5>
        </div>
        <div class="span10">
            <a name="state-delegate"><h2>State Delegate<?=(count($this->vars['members']) > 1) ?'s':'';?></h2></a>
            <? foreach($this->vars['members'] as $member): ?>
                <div class=" tc searchresultswrap">
                    <div style="overflow-y: hidden;width: 130px;height: 150px;float: left;">
                    <img width="130" src="<?=$member['image']?>" alt="" class="searchlayerimg"> 
                    </div>
                    <div class="row-fluid searchmeta">
                        <span class="meta muted"></span>
                        <div class="span6 ">
                            <? $middleName = (!empty($member['middleName'])) ? ' '.$member['middleName'].' ':' '; ?>
                            <strong class="bc laywername"><?=$member['firstName']?><?=$middleName?><?=$member['lastName']?></strong><br>
                            <!--
                            <span class="orange meta"><?=$member['currentMembership']?></span><br>
                            <?if(!empty($member['currentFacultyPosition'])):?>
                                <span class="orange meta"><?=$member['currentFacultyPosition']?></span><br>
                            <?endif;?>
                            -->
                            
                            <img class="sheild" width="100" src="<?=SAW_PUBLIC_SSL_CDN?>/badge/<?=$member['_id']?>/member" alt="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" />
                            <? if($member['staff'] =='Yes'): ?>
                            <img class="sheild" width="100" src="<?=SAW_PUBLIC_SSL_CDN?>/badge/<?=$member['_id']?>/staff" alt="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" />
                            <? endif; ?>
                            <? if($member['boardCertified'] =='Yes'): ?>
                            <img class="sheild" width="120" src="<?=SAW_PUBLIC_SSL_CDN?>/badge/<?=$member['_id']?>/boardcertified" alt="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" />
                            <? endif; ?>
                            <? if(array_key_exists('boardCertifiedSr', $member) && $member['boardCertifiedSr'] =='Yes'): ?>
                            <img class="sheild" width="120" src="<?=SAW_PUBLIC_SSL_CDN?>/badge/<?=$member['_id']?>/boardcertified" alt="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" />
                            <? endif; ?>
                            <? if( !empty($member['currentFacultyPosition']) && $member['currentFacultyPosition'] == \Saw\Model\Member::$facultyPositionReversed[\Saw\Model\Member::$facultyPosition['DELEGATE']]): ?>
                            <img width="100" src="<?=SAW_PUBLIC_SSL_CDN?>/badge/<?=$member['_id']?>/exec" alt="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" />
                            <? endif; ?>
                            <? if($member['sciencesCurriculum'] =='Yes'): ?>
                            <img class="sheild" width="100" src="<?=SAW_PUBLIC_SSL_CDN?>/badge/<?=$member['_id']?>/sciencesCurriculum" alt="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" />
                            <? endif; ?>
                            
                        </div>
                        <div class="span3 bc">
                            <a href="mailto:<?=$member['email']?>"><img src="<?=SAW_PUBLIC_SSL_CDN?>/assets/img/contactme.png"></a>
                            <br><br><br> <span class="phone"><a href="tel:<?=$member['primaryPhone']?>"><?=$member['primaryPhone']?></a></span>
                            <div class="clear"></div>
                            <? if(!empty($member['currentFacultyPosition']) && $member['currentFacultyPosition'] != \Saw\Model\Member::$facultyPositionReversed[\Saw\Model\Member::$facultyPosition['DELEGATE']]): ?>
                                <img class="delegation" src="<?=SAW_PUBLIC_SSL_CDN?>/badge/<?=$member['_id']?>/exec" alt="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" />
                            <? endif; ?>
                        </div>
                    </div>
                    <div class="row-fluid searchmetafooter">
                        <div class="span3 tl">
                            <? if(!empty($member['websites'])): ?>
                                <a href="http://<?=$member['websites'][0]['website']?>"> <?=$member['websites'][0]['website']?></a>
                            <? endif; ?>
                        </div>
                        
                        
                        <div class="span8 tl">
                            <? if(!empty($member['location']['raw'])): ?>
                            <a href="/member/<?=$member['_id']?>/<?=$member['slug']?>"><i class="icon-map-marker"></i> <?=$member['location']['raw']?></a>
                            <? endif; ?>
                        </div>
                        
                        
                        <div class="span1 tr">
                            <a href="/member/<?=$member['_id']?>/<?=$member['slug']?>"><img src="<?=SAW_PUBLIC_SSL_CDN?>/assets/img/fullprofile.png" class="pull-right"> </a>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <br>
            <? endforeach; ?>
            
            <? if(!empty($this->vars['pics'][0]) || !empty($this->vars['pics'][1]) || !empty($this->vars['pics'][2])):?>
            <a name="photos"><h2>Photos</h2></a>
            <div class="tc row-fluid">
                <div class="span4"><p><?=(!empty($this->vars['pics'][0])) ? '<img width="280" src="'.$this->vars['pics'][0].'">' : ''?></p></div>
                <div class="span4"><p><?=(!empty($this->vars['pics'][1])) ? '<img width="280" src="'.$this->vars['pics'][1].'">' : ''?></p></div>
                <div class="span4"><p><?=(!empty($this->vars['pics'][2])) ? '<img width="280" src="'.$this->vars['pics'][2].'">' : ''?></p></div>
            </div>
            <div class="clear"></div>
            <br>
            <? endif; ?>
            

            <? if(!empty($this->vars['events'])): ?>
            <a name="events"><h2>Events</h2></a>                        
            <div class=" tc row-fluid ">
                <div class="span10">
                    <div class="row-fluid sessionSeminarsDetailPage">
                        <div class="pull-left span12 tab-content">
                            <div class="tab-pane active" id="sessionsSeminarsPage">
                                
                                <table class="table-bordered" style="margin-top: 0px; width:100%">
                                    <tbody>
                                        <tr>
                                            <td><div class="bd">Name</div></td>
                                            <td><div class="bd">Sponsor</div></td>
                                            <td><div class="bd">Date</div></td>
                                        </tr>

                                         <? foreach($this->vars['events'] as $event): ?>
                                            <tr>
                                                <td><?=$event['name']?></td>
                                                <td><?=$event['sponsor']?></td>
                                                <td><?=$event['date']['fullMonth']?></td>
                                            </tr>
                                         <? endforeach; ?>              
                                         
                                    </tbody></table>
                                    <br>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <br>
            <? endif; ?>
            <? if(!empty($this->vars['content'])):?>
            <div class="row-fluid">
                <h2><a name="dui-laws">DUI Laws</a></h2>                        
                <div class="span10">
                    <?=$this->vars['content']?>
                </div>
            </div>
            <? endif; ?>
            <!--
            <div class="pagination tc">
                <ul>
                  <li><a href="#">Prev</a></li>
                  <li><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                  <li><a href="#">5</a></li>
                  <li><a href="#">Next</a></li>
              </ul>
          </div>-->
        </div>
        </div>
    </div>
</div>