                    <div class="row-fluid blog">
                        <div class="title text-center">
                            <div class="bg">
                                <h3><?=$this->vars['page']['headline']?></h3>
                            </div>
                        </div>
                        <div class="blogContent">
                            <p class="blogDescr">
                                <?=$this->vars['page']['body']?>
                            </p>
                            <div class="row-fluid sessionSeminarsDetailPage">
                                <div class="span12 pull-left">
                                    <? if(!empty($this->vars['seminar'])):?>
                                    <? $seminar = $this->vars['seminar']; ?>
                                    <? $slug = (array_key_exists('slug',$seminar)) ? '/'.$seminar['slug'] : ''; ?>
                                    <!-- photo -->
                                        <div class="postBody">
                                            <ul class="postHeader">
                                                <li class="dateBlock"><a href="/seminar/<?=$seminar['_id']?><?=$slug?>"><?=$seminar['startDate']['monthDay']?> - <?=$seminar['endDate']['monthDay']?>, <?=$seminar['startDate']['year']?></a></li>
                                            </ul>
                                            <div class="postContent">
                                                <h2 class="postTitle"><?=$seminar['headline']?></h2>
                                                <h5 class="postTitle"><?=(array_key_exists('location',$seminar)) ? $seminar['location']: '';?></h5>
                                                <div class="postMainImg">
                                                    <? if(!empty($seminar['image'])){?>
                                                    <img src="<?=$seminar['image']['urls']['large']['SSLCDN'] ?>" alt="" style="width:60%"><!-- class="bigPostMainImg" -->
                                                    <? } ?>
                                                </div>
                                                <br>
                                                <p class="postDescr"><?=$seminar['description']?></p>
                                            </div>
                                            <div class="postFooter">
                                                <?if(array_key_exists('register',$seminar) && array_key_exists('currentStatus',$seminar['register']) && $seminar['register']['currentStatus'] == \Saw\Model\SeminarRegister::$status['ON']): ?>
                                                <a href="https://<?=SAW_ADMIN_WEBSITE?>/registration/seminar/<?=$seminar['_id']?><?=$slug?>" class="btn readMore pull-left">Register Online +</a>
                                                <? elseif(array_key_exists('register',$seminar) && array_key_exists('currentStatus',$seminar['register']) && $seminar['register']['currentStatus'] == \Saw\Model\SeminarRegister::$status['MEMBERSONLY']): ?>
                                                <a href="https://<?=SAW_ADMIN_WEBSITE?>/registration/seminar/<?=$seminar['_id']?><?=$slug?>" class="btn readMore pull-left">Registration Available for Members Only +</a>
                                                <? else: ?>
                                                <ul class="postTags pull-left">
                                                    <li><h5>Registration will be available soon.</h5></li>
                                                </ul>
                                                <? endif; ?>
                                            </div>
                                        </div>
                                    
                                    <? else: ?>
                                        <h1>There are currently no seminars happening.</h1>
                                    <? endif; ?>
                                    
                                </div>
                                                            
                            </div>
                            <div class="row-fluid sessionSeminarsDetailPage">
                                <div class="pull-left span12 tab-content">
                                    <div class="tab-pane active" id="sessionsSeminarsPage">
                                        <? foreach($seminar['agendas'] as $agenda): ?>
                                        <? if(!empty($agenda['timeSlots'])): ?>
                                        <table class="table-bordered" style="margin-top: 0px;">
                                            <thead>
                                                <tr>
                                                    <th colspan="3"><?=$agenda['name']?> - <?=$agenda['date']['fullMonth']?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><div class="bd">Time</div></td>
                                                    <td><div class="bd">Title</div></td>
                                                    <td><div class="bd">Description</div></td>
                                                </tr>

                                                 <? foreach($agenda['timeSlots'] as $timeSlot): ?>
                                                    <tr>
                                                        <td><?=$timeSlot['date']['shortTimeSlim']?></td>
                                                        <td><?=$timeSlot['title']?></td>
                                                        <td><?=$timeSlot['description']?></td>
                                                    </tr>
                                                 <? endforeach; ?>              
                                                 
                                            </tbody></table>
                                            <br>
                                        <? endif; ?>
                                        <? endforeach; ?>
                                    </div>
                                </div>
                            </div>
                                
                            <!-- -->
                        </div>
                    </div>