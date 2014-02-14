<style>
@font-face {
  font-family: 'Bree Serif';
  font-style: normal;
  font-weight: 400;
  src: local('Bree Serif'), local('BreeSerif-Regular'), url(/assets/fonts/LQ7WLTaITDg4OSRuOZCps73hpw3pgy2gAi-Ip7WPMi0.woff) format('woff');
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
<h3><?=$this->vars['page']['headline']?></h3>
</div>
</div></div>
<div class="container-fluid pagecontent" id="learn">
                    <div class="row-fluid">
                        <div class="center span12">
                            <div class="dropdown visible-phone mapsPhone">
                                <a class="dropdown-toggle btn" href="javascript:void(0)">
                                    Select A State
                                    <b class="caret"></b>
                                </a>
                                <ul class="mapsPhoneDropdown">
                                    <li class="titleMap">USA</li>
                                    <li><a href="/founding-members/usa/alabama">Alabama</a></li>
                                <!-- <li><a href="/founding-members/usa/alaska">Alaska</a></li> -->
                                <li><a href="/founding-members/usa/arizona">Arizona</a></li>
                                <li><a href="/founding-members/usa/arkansas">Arkansas</a></li>
                                <li><a href="/founding-members/usa/california">California</a></li>
                                <li><a href="/founding-members/usa/colorado">Colorado</a></li>
                                <li><a href="/founding-members/usa/connecticut">Connecticut</a></li>
                                <!-- <li><a href="/founding-members/usa/delaware">Delaware</a></li> -->
                                <!-- <li><a href="/founding-members/usa/washington-dc">Washington DC</a></li> -->
                                <li><a href="/founding-members/usa/florida">Florida</a></li>
                                <li><a href="/founding-members/usa/georgia">Georgia</a></li>
                                <!-- <li><a href="/founding-members/usa/hawaii">Hawaii</a></li> -->
                                <!-- <li><a href="/founding-members/usa/idaho">Idaho</a></li> -->
                                <li><a href="/founding-members/usa/illinois">Illinois</a></li>
                                <li><a href="/founding-members/usa/indiana">Indiana</a></li>
                                <li><a href="/founding-members/usa/iowa">Iowa</a></li>
                                <li><a href="/founding-members/usa/kansas">Kansas</a></li>
                                <li><a href="/founding-members/usa/kentucky">Kentucky</a></li>
                                <li><a href="/founding-members/usa/louisiana">Louisiana</a></li>
                                <!-- <li><a href="/founding-members/usa/maine">Maine</a></li> -->
                                <li><a href="/founding-members/usa/maryland">Maryland</a></li>
                                <!-- <li><a href="/founding-members/usa/massachusetts">Massachusetts</a></li> -->
                                <!-- <li><a href="/founding-members/usa/michigan">Michigan</a></li> -->
                                <li><a href="/founding-members/usa/minnesota">Minnesota</a></li>
                                <li><a href="/founding-members/usa/mississippi">Mississippi</a></li>
                                <li><a href="/founding-members/usa/missouri">Missouri</a></li>
                                <!-- <li><a href="/founding-members/usa/montana">Montana</a></li> -->
                                <!-- <li><a href="/founding-members/usa/nebraska">Nebraska</a></li>
                                <li><a href="/founding-members/usa/nevada">Nevada</a></li> -->
                                <li><a href="/founding-members/usa/new-hampshire">New Hampshire</a></li>
                                <li><a href="/founding-members/usa/new-jersey">New Jersey</a></li>
                                <li><a href="/founding-members/usa/new-mexico">New Mexico</a></li>
                                <li><a href="/founding-members/usa/new-york">New York</a></li>
                                <li><a href="/founding-members/usa/north-carolina">North Carolina</a></li>
                                <!-- <li><a href="/founding-members/usa/north-dakota">North Dakota</a></li> -->
                                <li><a href="/founding-members/usa/ohio">Ohio</a></li>
                                <!-- <li><a href="/founding-members/usa/oklahoma">Oklahoma</a></li> -->
                                <!-- <li><a href="/founding-members/usa/oregon">Oregon</a></li> -->
                                <!-- <li><a href="/founding-members/usa/pennsylvania">Pennsylvania</a></li> -->
                                <li><a href="/founding-members/usa/rhode-island">Rhode Island</a></li>
                                <li><a href="/founding-members/usa/south-carolina">South Carolina</a></li>
                                <!-- <li><a href="/founding-members/usa/south-dakota">South Dakota</a></li> -->
                                <li><a href="/founding-members/usa/tennessee">Tennessee</a></li>
                                <li><a href="/founding-members/usa/texas">Texas</a></li>
                                <!-- <li><a href="/founding-members/usa/utah">Utah</a></li> -->
                                <!-- <li><a href="/founding-members/usa/vermont">Vermont</a></li> -->
                                <li><a href="/founding-members/usa/virginia">Virginia </a></li>
                                <li><a href="/founding-members/usa/washington">Washington</a></li>
                                <!-- <li><a href="/founding-members/usa/west-virginia">West Virginia</a></li> -->
                                <li><a href="/founding-members/usa/wisconsin">Wisconsin</a></li>
                                <!-- <li><a href="/founding-members/usa/wyoming">Wyoming </a></li> -->
                                    <!--
                                    <li class="titleMap">Canada</li>
                                    <li><a href="http://ncdd.com/find-an-attorney/cananda/ontario">Ontario </a></li>
                                    <li><a href="http://ncdd.com/find-an-attorney/cananda/quebec">Quebec </a></li>
                                    -->
                                </ul>
                            </div>
                           

                            
                            <div class="text-left becomeAmember">
                                <p>
                                <?=$this->vars['page']['body']?>
                            </p>
                            </div>
                       </div> 
                    <div class="pagecontent ">
                        <div class="span2 hidden-phone">
                          <div class="selectstate center bc">SELECT ANOTHER STATE</div>
                          <div class="country bc">USA</div>
                          <ul class="sidebarlist bc">
                            <li><a href="/founding-members/usa/alabama">Alabama</a></li>
                                <!-- <li><a href="/founding-members/usa/alaska">Alaska</a></li> -->
                                <li><a href="/founding-members/usa/arizona">Arizona</a></li>
                                <li><a href="/founding-members/usa/arkansas">Arkansas</a></li>
                                <li><a href="/founding-members/usa/california">California</a></li>
                                <li><a href="/founding-members/usa/colorado">Colorado</a></li>
                                <li><a href="/founding-members/usa/connecticut">Connecticut</a></li>
                                <!-- <li><a href="/founding-members/usa/delaware">Delaware</a></li> -->
                                <!-- <li><a href="/founding-members/usa/washington-dc">Washington DC</a></li> -->
                                <li><a href="/founding-members/usa/florida">Florida</a></li>
                                <li><a href="/founding-members/usa/georgia">Georgia</a></li>
                                <!-- <li><a href="/founding-members/usa/hawaii">Hawaii</a></li> -->
                                <!-- <li><a href="/founding-members/usa/idaho">Idaho</a></li> -->
                                <li><a href="/founding-members/usa/illinois">Illinois</a></li>
                                <li><a href="/founding-members/usa/indiana">Indiana</a></li>
                                <li><a href="/founding-members/usa/iowa">Iowa</a></li>
                                <li><a href="/founding-members/usa/kansas">Kansas</a></li>
                                <li><a href="/founding-members/usa/kentucky">Kentucky</a></li>
                                <li><a href="/founding-members/usa/louisiana">Louisiana</a></li>
                                <!-- <li><a href="/founding-members/usa/maine">Maine</a></li> -->
                                <li><a href="/founding-members/usa/maryland">Maryland</a></li>
                                <!-- <li><a href="/founding-members/usa/massachusetts">Massachusetts</a></li> -->
                                <!-- <li><a href="/founding-members/usa/michigan">Michigan</a></li> -->
                                <li><a href="/founding-members/usa/minnesota">Minnesota</a></li>
                                <li><a href="/founding-members/usa/mississippi">Mississippi</a></li>
                                <li><a href="/founding-members/usa/missouri">Missouri</a></li>
                                <!-- <li><a href="/founding-members/usa/montana">Montana</a></li> -->
                                <!-- <li><a href="/founding-members/usa/nebraska">Nebraska</a></li>
                                <li><a href="/founding-members/usa/nevada">Nevada</a></li> -->
                                <li><a href="/founding-members/usa/new-hampshire">New Hampshire</a></li>
                                <li><a href="/founding-members/usa/new-jersey">New Jersey</a></li>
                                <li><a href="/founding-members/usa/new-mexico">New Mexico</a></li>
                                <li><a href="/founding-members/usa/new-york">New York</a></li>
                                <li><a href="/founding-members/usa/north-carolina">North Carolina</a></li>
                                <!-- <li><a href="/founding-members/usa/north-dakota">North Dakota</a></li> -->
                                <li><a href="/founding-members/usa/ohio">Ohio</a></li>
                                <!-- <li><a href="/founding-members/usa/oklahoma">Oklahoma</a></li> -->
                                <!-- <li><a href="/founding-members/usa/oregon">Oregon</a></li> -->
                                <!-- <li><a href="/founding-members/usa/pennsylvania">Pennsylvania</a></li> -->
                                <li><a href="/founding-members/usa/rhode-island">Rhode Island</a></li>
                                <li><a href="/founding-members/usa/south-carolina">South Carolina</a></li>
                                <!-- <li><a href="/founding-members/usa/south-dakota">South Dakota</a></li> -->
                                <li><a href="/founding-members/usa/tennessee">Tennessee</a></li>
                                <li><a href="/founding-members/usa/texas">Texas</a></li>
                                <!-- <li><a href="/founding-members/usa/utah">Utah</a></li> -->
                                <!-- <li><a href="/founding-members/usa/vermont">Vermont</a></li> -->
                                <li><a href="/founding-members/usa/virginia">Virginia </a></li>
                                <li><a href="/founding-members/usa/washington">Washington</a></li>
                                <!-- <li><a href="/founding-members/usa/west-virginia">West Virginia</a></li> -->
                                <li><a href="/founding-members/usa/wisconsin">Wisconsin</a></li>
                                <!-- <li><a href="/founding-members/usa/wyoming">Wyoming </a></li> -->
                        </ul>
                        <!--
                        <div class="country bc">Canada</div>
                        <ul class="sidebarlist bc">
                           <li><a href="/find-an-attorney/canada/ontario">Ontario </a></li>
                            <li><a href="/find-an-attorney/canada/quebec">Quebec </a></li>
                        </ul>
                        -->
                    </div>
                    <div class="cityNameBlock">
                        <h5 class="cityName pull-left"></h5>
                    </div>
                    <div class="span10">

                        <? foreach($this->vars['members'] as $member): ?>
                            <div class=" tc searchresultswrap">
                                <div style="overflow-y: hidden;width: 130px;height: 150px;float: left;">
                                <img width="130" src="<?=$member['image']?>" alt="" class="searchlayerimg"> 
                            </div>
                                <div class="row-fluid searchmeta">
                                    <span class="meta muted"></span>
                                    <div class="span5 tc">
                                        <? $middleName = (!empty($member['middleName'])) ? ' '.$member['middleName'].' ':' '; ?>
                                        <strong class="bc laywername"><?=$member['firstName']?><?=$middleName?><?=$member['lastName']?></strong><br>
                                        <!--
                                        <span class="orange meta"><?=$member['currentMembership']?></span><br>
                                        <?if(!empty($member['currentFacultyPosition'])):?>
                                            <span class="orange meta"><?=$member['currentFacultyPosition']?></span><br>
                                        <?endif;?>
                                        -->
                                        
                                        <img class="sheild" width="100" src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$member['_id']?>/member" alt="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" />
                                        <? if($member['staff'] =='Yes'): ?>
                                        <img class="sheild" width="100" src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$member['_id']?>/staff" alt="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" />
                                        <? endif; ?>
                                        <? if($member['boardCertified'] =='Yes'): ?>
                                        <img class="sheild" width="120" src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$member['_id']?>/boardcertified" alt="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" />
                                        <? endif; ?>
                                    </div>
                                    <div class="span4 bc">
                                        <a href="mailto:<?=$member['email']?>"><img src="/assets/img/contactme.png"></a>
                                        <br><br><br> <span class="phone"><a href="tel:<?=$member['primaryPhone']?>"><?=$member['primaryPhone']?></a></span>
                                        <div class="clear"></div>
                                        <? if(!empty($member['currentFacultyPosition'])): ?>
                                            <img class="delegation" src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$member['_id']?>/exec" alt="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" />
                                        <? endif; ?>
                                    </div>
                                </div>
                                <div class="row-fluid searchmetafooter">
                                    <div class="span3 tl">
                                        <? if(!empty($member['websites'])): ?>
                                            <a href="//<?=$member['websites'][0]['website']?>"><i class="icon-share"></i> <?=$member['websites'][0]['website']?></a>
                                        <? endif; ?>
                                    </div>
                                    
                                    <? if(!empty($member['location']['raw'])): ?>
                                    <div class="span8 tl">
                                        <a href="/member/<?=$member['_id']?>/<?=$member['slug']?>"><i class="icon-map-marker"></i> <?=$member['location']['raw']?></a>
                                    </div>
                                    <? endif; ?>
                                    
                                    <div class="span1 tr">
                                        <a href="/member/<?=$member['_id']?>/<?=$member['slug']?>"><img src="/assets/img/fullprofile.png" class="pull-right"> </a>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <br>
                        <? endforeach; ?>
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
                    <div class="clear"></div>
                    </div>
                </div>
</div>
