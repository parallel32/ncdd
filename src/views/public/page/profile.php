                    <? $member = $this->vars['member']; ?>
                    <div class="row-fluid memberProfile">
                        <div class="contactMe pull-right"><a href="mailto:<?=$member['email']?>">CONTACT  ME</a></div>
                        <div class="userMainInfo">
                            <div class="avatar pull-left"><img width="161" src="<?=$member['image']?>" alt=""></div>
                            <div class="pull-left">
                                <h3 class="username"><?=$member['firstName']?> <?=$member['lastName']?></h3>
                                <ul class="links ">
                                    <li class="linksItem">Specialize in <a href="#"><?=$member['specializeIn']?></a></li>
                                    <li class="linksItem"><a href="//<?=(!empty($member['websites']) && is_array($member['websites'])) ? $member['websites'][0]['website'] : '#' ?>">Visit Member’s Website</a></li>
                                </ul>
                            </div>
                            <div class="pull-right">
                                <ul class="socialNetwork inline">
                                    <? if(!empty($member['linkedInUrl'])): ?>
                                    <li class="socialNetworkItem"><a href="<?=$member['linkedInUrl']?>" target="_blank" class="socialNetworkLink linkedin"></a></li>
                                    <? endif; ?>
                                    
                                    <? if(!empty($member['googlePlusUrl'])): ?>
                                    <li class="socialNetworkItem"><a href="<?=$member['googlePlusUrl']?>" target="_blank" class="socialNetworkLink google"></a></li>
                                    <? endif; ?>
                                    
                                    <? if(!empty($member['twitterUrl'])): ?>
                                    <li class="socialNetworkItem"><a href="<?=$member['twitterUrl']?>" target="_blank" class="socialNetworkLink twitter"></a></li>
                                    <? endif; ?>
                                    
                                    <? if(!empty($member['facebookUrl'])): ?>
                                    <li class="socialNetworkItem"><a href="<?=$member['facebookUrl']?>" target="_blank" class="socialNetworkLink facebook"></a></li>
                                    <? endif; ?>
                                    
                                </ul>
                                <p class="telephone"><?=$member['primaryPhone']?></p>
                            </div>
                        </div>
                        <ul class="userProfile">
                            <li class="userProfileItem">
                                <h5 class="userProfileTitle">Types of Membership</h5>
                                <ul class="memberBadgeBlock inline">

                                    <li class="memberBadge"><img width="102" src="http://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$member['_id']?>/member" alt="NCDD National College for DUI Defense: <?=$member['firstName']?> <?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?> <?=$member['lastName']?>" /></li>
                                    <? if($member['boardCertified'] =='Yes'): ?>
                                        <li class="memberBadge"><img width="138" src="http://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$member['_id']?>/boardcertified" alt="NCDD National College for DUI Defense: <?=$member['firstName']?> <?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?> <?=$member['lastName']?>" /></li>
                                    <? endif; ?>
                                    <? if(!empty($member['currentFacultyPosition'])): ?>
                                        <li class="memberBadge"><img src="http://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$member['_id']?>/exec" alt="NCDD National College for DUI Defense: <?=$member['firstName']?> <?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?> <?=$member['lastName']?>" /></li>
                                    <? endif; ?>
                                    
                                </ul>
                            </li>
                            <li class="userProfileItem numbers">
                                <h5 class="userProfileTitle">Additional Numders</h5>
                                <ul class="infoList">
                                    <? foreach($member['locations'] as $location): ?>
                                    <li class="infoListItem"><?=$location['phone']?></li>
                                    <? endforeach; ?>
                                </ul>
                            </li>
                            <li class="userProfileItem">
                                <h5 class="userProfileTitle">Additional Websites</h5>
                                <ul class="infoList websites">
                                    <? foreach($member['websites'] as $website): ?>
                                    <li class="infoListItem"><a href="//<?=$website['website']?>" alt="<?=$website['websiteDesc']?>" title="<?=$website['websiteDesc']?>"><?=$website['website']?></a></li>
                                    <? endforeach; ?>
                                </ul>
                            </li>
                            
                        </ul>
                        <div class="aboutMe dottedSep">
                            <h4 class="memberProfileTitle">About Me:</h4>
                            <p><?=$member['aboutMe']?></p>
                            <div class="languages">
                                <h5 class="languagesTitle">Languages</h5>
                                <ul class="languagesList">
                                    <? $i=0; foreach($member['languages'] as $lang): ?>
                                    <li><?=$lang['language']?></li>
                                    <? if($i < count($member['languages'])-1){?>
                                    <li class="sep"></li><?}?>
                                    <? $i++; endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="contactInfo dottedSep">
                            <h5 class="memberProfileTitle">Contact Information:</h5>
                            <div class="pull-left contactInfoMap">
                                <img src="/assets/img/contactInfoMap.png" alt="">
                            </div>
                            <div class="pull-right address">
                                <ul class="addressBlock dottedSep">
                                <? $i=1; foreach($member['locations'] as $location): ?>
                                
                                    <li>
                                        <address>
                                            <b><?=$location['name']?></b> <br>
                                            <?=$location['addressLine1']?> <br>
                                            <?=$location['city']?>, <?=$location['state']?> <?=$location['zip']?> <br>
                                            <b>Office:</b> <?=$location['phone']?> <br>
                                            <b>Fax:</b> <?=$location['fax']?> <br>
                                            <a target="_blank" href="https://maps.google.com/maps?q=<?=$location['raw']?>&hl=en&t=m&z=16&iwloc=A" class="viewMap">View map</a>
                                        </address>
                                    </li>
                                    <? if($i % 2 == 0): ?>
                                        </ul>
                                        <ul class="addressBlock">
                                    <? endif; ?>

                                <? $i++; endforeach; ?>    
                                </ul>
                                
                            </div>
                        </div>
                        <div class="pricticeCaseFinancial">
                            <div class="practiceCase dottedSepVertical pull-left">
                                <h5 class="memberProfileTitle">Practice and Cases</h5>
                                


    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
          <? foreach($member['practiceAreas'] as $pa): 
          $paa = addslashes($pa['pa']);
          ?>
          ['<?=$paa?>',     <?=$pa['percent']?>],
          <? endforeach; ?>
        ]);

        var options = {
          title: ''
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
    <div id="chart_div" style="width: 500px; height: 160px;"></div>

                            </div>
                            <div class="financial pull-right">
                                <h5 class="memberProfileTitle">Financial</h5>
                                <p><b>Fees:</b><br><?=$member['financialFees']?></p>
                                <p><b>Payment:</b><br><?=$member['financialPayment']?></p>
                            </div>
                        </div>
                    </div>