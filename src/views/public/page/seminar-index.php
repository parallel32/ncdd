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
                                <div class="span8 pull-left">
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
                                                    <img src="<?=$seminar['image']['urls']['large']['CDN'] ?>" alt="" style="width:60%"><!-- class="bigPostMainImg" -->
                                                    <? } ?>
                                                </div>
                                                <p class="postDescr"><?=substr($seminar['description'],0,500)?> … <a href="/sessions-and-seminars/<?=$seminar['_id']?><?=$slug?>">read more</a></p>
                                            </div>

                                            <div class="postFooter">
                                                <a href="#" class="btn readMore pull-left">Register Online + (coming soon)</a>
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