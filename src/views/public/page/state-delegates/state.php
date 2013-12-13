                    <div class="row-fluid becomeAmember">
                        <div class="title text-center">
                            <div class="bg">
                                <h3><?=$this->vars['state']?> State Delegates</h3>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="attorneyContent">
                        <div class="dropdown mapsPhone">
                            <a class="dropdown-toggle btn"href="javascript:void(0)">
                                Select Another State
                                <b class="caret"></b>
                            </a>
                            <ul class="mapsPhoneDropdown">
                                <li class="titleMap">USA</li>
                                <li><a href="/state-delegates/usa/alabama">Alabama</a></li>
                                <li><a href="/state-delegates/usa/alaska">Alaska</a></li>
                                <li><a href="/state-delegates/usa/arizona">Arizona</a></li>
                                <li><a href="/state-delegates/usa/arkansas">Arkansas</a></li>
                                <li><a href="/state-delegates/usa/california">California</a></li>
                                <li><a href="/state-delegates/usa/colorado">Colorado</a></li>
                                <li><a href="/state-delegates/usa/connecticut">Connecticut</a></li>
                                <li><a href="/state-delegates/usa/delaware">Delaware</a></li>
                                <li><a href="/state-delegates/usa/washington-dc">Washington DC</a></li>
                                <li><a href="/state-delegates/usa/florida">Florida</a></li>
                                <li><a href="/state-delegates/usa/georgia">Georgia</a></li>
                                <li><a href="/state-delegates/usa/hawaii">Hawaii</a></li>
                                <li><a href="/state-delegates/usa/idaho">Idaho</a></li>
                                <li><a href="/state-delegates/usa/illinois">Illinois</a></li>
                                <li><a href="/state-delegates/usa/indiana">Indiana</a></li>
                                <li><a href="/state-delegates/usa/iowa">Iowa</a></li>
                                <li><a href="/state-delegates/usa/kansas">Kansas</a></li>
                                <li><a href="/state-delegates/usa/kentucky">Kentucky</a></li>
                                <li><a href="/state-delegates/usa/louisiana">Louisiana</a></li>
                                <li><a href="/state-delegates/usa/maine">Maine</a></li>
                                <li><a href="/state-delegates/usa/maryland">Maryland</a></li>
                                <li><a href="/state-delegates/usa/massachusetts">Massachusetts</a></li>
                                <li><a href="/state-delegates/usa/michigan">Michigan</a></li>
                                <li><a href="/state-delegates/usa/minnesota">Minnesota</a></li>
                                <li><a href="/state-delegates/usa/mississippi">Mississippi</a></li>
                                <li><a href="/state-delegates/usa/missouri">Missouri</a></li>
                                <li><a href="/state-delegates/usa/montana">Montana</a></li>
                                <li><a href="/state-delegates/usa/nebraska">Nebraska</a></li>
                                <li><a href="/state-delegates/usa/nevada">Nevada</a></li>
                                <li><a href="/state-delegates/usa/new-hampshire">New Hampshire</a></li>
                                <li><a href="/state-delegates/usa/new-jersey">New Jersey</a></li>
                                <li><a href="/state-delegates/usa/new-mexico">New Mexico</a></li>
                                <li><a href="/state-delegates/usa/new-york">New York</a></li>
                                <li><a href="/state-delegates/usa/north-carolina">North Carolina</a></li>
                                <li><a href="/state-delegates/usa/ohio">Ohio</a></li>
                                <li><a href="/state-delegates/usa/oklahoma">Oklahoma</a></li>
                                <li><a href="/state-delegates/usa/oregon">Oregon</a></li>
                                <li><a href="/state-delegates/usa/pennsylvania">Pennsylvania</a></li>
                                <li><a href="/state-delegates/usa/south-carolina">South Carolina</a></li>
                                <li><a href="/state-delegates/usa/south-dakota">South Dakota</a></li>
                                <li><a href="/state-delegates/usa/tennessee">Tennessee</a></li>
                                <li><a href="/state-delegates/usa/texas">Texas</a></li>
                                <li><a href="/state-delegates/usa/utah">Utah</a></li>
                                <li><a href="/state-delegates/usa/vermont">Vermont</a></li>
                                <li><a href="/state-delegates/usa/virginia">Virginia </a></li>
                                <li><a href="/state-delegates/usa/washington">Washington</a></li>
                                <li><a href="/state-delegates/usa/west-virginia">West Virginia</a></li>
                                <li><a href="/state-delegates/usa/wisconsin">Wisconsin</a></li>
                                <li><a href="/state-delegates/usa/wyoming">Wyoming </a></li>
                            </ul>
                        </div>


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
                                        <h5 class="descr text-center"><a class="text-error"><?=$member['currentFacultyPosition']?></a></h5>
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
                                    <? if(!empty($member['location']['raw'])): ?>
                                    <div class="address">
                                        <p class="pull-left">
                                            <a style="font-size:20px"><?=$member['location']['raw']?></a>
                                        </p>
                                        <a href="/member/<?=$member['_id']?>/<?=$member['slug']?>" class=" hide btn pull-right"></a>
                                    </div>
                                    <? endif; ?>
                                    
                                </div>
                            </li>
                        <? endforeach; ?>
                            
                        </ul>
                    </div>