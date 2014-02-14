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
                            <div class="row-fluid">
                                <div class="span12 pull-left">
                                    <? if(!empty($this->vars['seminars'])):?>
                                    <? foreach($this->vars['seminars'] as $seminar): ?>
                                    <? $slug = (array_key_exists('slug',$seminar)) ? '/'.$seminar['slug'] : ''; ?>
                                    <!-- photo -->
                                        <div class="postBody">
                                            <ul class="postHeader">
                                                <li class="dateBlock"><a href="/sessions-and-seminars/<?=$seminar['_id']?><?=$slug?>"><?=$seminar['startDate']['monthDay']?> - <?=$seminar['endDate']['monthDay']?>, <?=$seminar['startDate']['year']?></a></li>
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
                                                <? else: ?>
                                                <ul class="postTags pull-left">
                                                    <li><h5>Registration Not Available</h5></li>
                                                </ul>
                                                <? endif; ?>
                                                <a href="/sessions-and-seminars/<?=$seminar['_id']?><?=$slug?>" class="btn readMore pull-right">View Agenda</a>
                                            </div>
                                        </div>
                                    <? endforeach; ?>
                                    <? else: ?>
                                        <h1>There are currently no seminars happening.</h1>
                                    <? endif; ?>
                                    
                                </div>
                            </div>
                            <!-- -->
                        </div>
                    </div>