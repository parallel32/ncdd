                    <div class="row-fluid becomeAmember">
                        <div class="title text-center">
                            <div class="bg">
                                <h3><?=$this->vars['state']?> Attorneys</h3>
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
                                    <li><a href="/find-an-attorney/usa/alabama">Alabama</a></li>
                                    <li><a href="/find-an-attorney/usa/alaska">Alaska</a></li>
                                    <li><a href="/find-an-attorney/usa/arizona">Arizona</a></li>
                                    <li><a href="/find-an-attorney/usa/arkansas">Arkansas</a></li>
                                    <li><a href="/find-an-attorney/usa/california">California</a></li>
                                    <li><a href="/find-an-attorney/usa/colorado">Colorado</a></li>
                                    <li><a href="/find-an-attorney/usa/connecticut">Connecticut</a></li>
                                    <li><a href="/find-an-attorney/usa/delaware">Delaware</a></li>
                                    <li><a href="/find-an-attorney/usa/washington-dc">Washington DC</a></li>
                                    <li><a href="/find-an-attorney/usa/florida">Florida</a></li>
                                    <li><a href="/find-an-attorney/usa/georgia">Georgia</a></li>
                                    <li><a href="/find-an-attorney/usa/hawaii">Hawaii</a></li>
                                    <li><a href="/find-an-attorney/usa/idaho">Idaho</a></li>
                                    <li><a href="/find-an-attorney/usa/illinois">Illinois</a></li>
                                    <li><a href="/find-an-attorney/usa/indiana">Indiana</a></li>
                                    <li><a href="/find-an-attorney/usa/iowa">Iowa</a></li>
                                    <li><a href="/find-an-attorney/usa/kansas">Kansas</a></li>
                                    <li><a href="/find-an-attorney/usa/kentucky">Kentucky</a></li>
                                    <li><a href="/find-an-attorney/usa/louisiana">Louisiana</a></li>
                                    <li><a href="/find-an-attorney/usa/maine">Maine</a></li>
                                    <li><a href="/find-an-attorney/usa/maryland">Maryland</a></li>
                                    <li><a href="/find-an-attorney/usa/massachusetts">Massachusetts</a></li>
                                    <li><a href="/find-an-attorney/usa/michigan">Michigan</a></li>
                                    <li><a href="/find-an-attorney/usa/minnesota">Minnesota</a></li>
                                    <li><a href="/find-an-attorney/usa/mississippi">Mississippi</a></li>
                                    <li><a href="/find-an-attorney/usa/missouri">Missouri</a></li>
                                    <li><a href="/find-an-attorney/usa/montana">Montana</a></li>
                                    <li><a href="/find-an-attorney/usa/nebraska">Nebraska</a></li>
                                    <li><a href="/find-an-attorney/usa/nevada">Nevada</a></li>
                                    <li><a href="/find-an-attorney/usa/new-hampshire">New Hampshire</a></li>
                                    <li><a href="/find-an-attorney/usa/new-jersey">New Jersey</a></li>
                                    <li><a href="/find-an-attorney/usa/new-mexico">New Mexico</a></li>
                                    <li><a href="/find-an-attorney/usa/new-york">New York</a></li>
                                    <li><a href="/find-an-attorney/usa/north-carolina">North Carolina</a></li>
                                    <li><a href="/find-an-attorney/usa/north-dakota">North Dakota</a></li>
                                    <li><a href="/find-an-attorney/usa/ohio">Ohio</a></li>
                                    <li><a href="/find-an-attorney/usa/oklahoma">Oklahoma</a></li>
                                    <li><a href="/find-an-attorney/usa/oregon">Oregon</a></li>
                                    <li><a href="/find-an-attorney/usa/pennsylvania">Pennsylvania</a></li>
                                    <li><a href="/find-an-attorney/usa/rhode-island">Rhode Island</a></li>
                                    <li><a href="/find-an-attorney/usa/south-carolina">South Carolina</a></li>
                                    <li><a href="/find-an-attorney/usa/south-dakota">South Dakota</a></li>
                                    <li><a href="/find-an-attorney/usa/tennessee">Tennessee</a></li>
                                    <li><a href="/find-an-attorney/usa/texas">Texas</a></li>
                                    <li><a href="/find-an-attorney/usa/utah">Utah</a></li>
                                    <li><a href="/find-an-attorney/usa/vermont">Vermont</a></li>
                                    <li><a href="/find-an-attorney/usa/virginia">Virginia </a></li>
                                    <li><a href="/find-an-attorney/usa/washington">Washington</a></li>
                                    <li><a href="/find-an-attorney/usa/west-virginia">West Virginia</a></li>
                                    <li><a href="/find-an-attorney/usa/wisconsin">Wisconsin</a></li>
                                    <li><a href="/find-an-attorney/usa/wyoming">Wyoming </a></li>
                                    
                                    <li class="titleMap">Canada</li>
                                    <li><a href="/find-an-attorney/cananda/ontario">Ontario </a></li>
                                    <li><a href="/find-an-attorney/cananda/quebec">Quebec </a></li>
                                    <li><a href="/find-an-attorney/cananda/saskatchewan">Saskatchewan </a></li>
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
                                            <h3 class="name text-center"><?=$member['firstName']?> <?=$member['lastName']?></h3>
                                            <h5 class="descr text-center"><?=$member['currentMembership']?></h5>
                                            <? if(!empty($member['currentFacultyPosition'])): ?>
                                                <div class="regentsFellowsLabel"><img src="http://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$member['_id']?>/exec" alt="NCDD National College for DUI Defense: <?=$member['firstName']?> <?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?> <?=$member['lastName']?>" /></div>
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
                                                    <div class="memberBadge"><img width="71" src="http://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$member['_id']?>/member" alt="NCDD National College for DUI Defense: <?=$member['firstName']?> <?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?> <?=$member['lastName']?>" /></div>
                                                    <? if($member['boardCertified'] =='Yes'): ?>
                                                    <div class="memberBadge"><img width="96" src="http://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$member['_id']?>/boardcertified" alt="NCDD National College for DUI Defense: <?=$member['firstName']?> <?=$member['lastName']?>" title="NCDD National College for DUI Defense: <?=$member['firstName']?> <?=$member['lastName']?>" /></div>
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