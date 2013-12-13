                    <div class="row-fluid becomeAmember">
                        <div class="title text-center">
                            <div class="bg">
                                <h3><?=$this->vars['page']['headline']?></h3>
                            </div>
                        </div>
                        <div class="becomeAmemberContent">
                            <?=$this->vars['page']['body']?>
                        </div>
                    </div>
                    
                    <div class="attorneyContent">

                        <div class="cityNameBlock">
                            <h5 class="cityName pull-left"></h5>
                            <span class="result pull-right"><?=count($this->vars['members'])?> Results</span>
                        </div>


                        <ul class="membersList">
                        <? foreach($this->vars['members'] as $member): ?>
                            <li class="membersListItem">
                                <img width="196" src="<?=$member['image']?>" alt="" class="avatar pull-left">
                                <div class="info pull-right">
                                    <div class="nameBlock">
                                        <? $middleName = (!empty($member['middleName'])) ? ' '.$member['middleName'].' ':' '; ?>
                                        <h3 class="name text-center"><?=$member['firstName']?><?=$middleName?><?=$member['lastName']?></h3>
                                        <h5 class="descr text-center"><?=$member['currentMembership']?></h5>
                                        <? if(!empty($member['currentFacultyPosition'])): ?>
                                            <div class="regentsFellowsLabel"><img src="http://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$member['_id']?>/exec" alt="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" /></div>
                                    <? endif; ?>
                                    </div>
                                    <ul class="numbers">
                                        <li>
                                            <div class="text-center"><a href="mailto:<?=$member['email']?>"><img src="/assets/img/envelopeBg.png"></a></div>
                                        </li>
                                        <li>
                                            <h6 class="nemberTitle"><?=$member['primaryPhone']?></h6>
                                            <p>Call Now</p>
                                        </li>
                                        <li>
                                            <div class="memberBadgeBlock">
                                                <div class="memberBadge"><img width="140" src="http://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$member['_id']?>/member" alt="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" /></div>
                                                <? if($member['staff'] =='Yes'): ?>
                                                <div class="memberBadge"><img width="140" src="http://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$member['_id']?>/staff" alt="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" /></div>
                                                <? endif; ?>
                                                <? if($member['boardCertified'] =='Yes'): ?>
                                                <div class="memberBadge"><img width="165" src="http://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$member['_id']?>/boardcertified" alt="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?><?=$middleName?><?=$member['lastName']?>" /></div>
                                                <? endif; ?>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="address">
                                        <p class="pull-left">
                                            <? if(!empty($member['websites'])): ?>
                                            <a style="font-size:24px" href="//<?=$member['websites'][0]['website']?>"><?=$member['websites'][0]['website']?></a>
                                            <? endif; ?>
                                        </p>
                                        <a href="/member/<?=$member['_id']?>/<?=$member['slug']?>" class="btn pull-right">Full Profile</a>
                                    </div>
                                </div>
                            </li>
                        <? endforeach; ?>
                            
                        </ul>
                    </div>