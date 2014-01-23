
                    <div class="row-fluid blog">
                        <div class="title text-center">
                            <div class="bg">
                                <h3><?=$this->vars['page']['headline']?></h3>
                            </div>
                        </div>



                        <script src="/assets/js/cloud-zoom.1.0.2.js"></script>


                        <div class="row-fluid discoverLearnPage NCDDListDetailPage">
                        <div class="discoverContent">
                            <div class="pull-right span12 tab-content">
                                <div class="tab-pane active" id="ncddStorePage">
                                    <ul class="productList">
                                        <? foreach($this->vars['products'] as $product): ?>
                                        <li class="productListItem">
                                            <? if (!empty($product['image'])): ?>
                                            <div class="pull-left text-center">
                                                <div class="productImg">
                                                    <div id="wrap" style="top:0px;z-index:9999;position:relative;"><a href="<?=$product['image']['urls']['large']['CDN'] ?>" class="cloud-zoom" id="zoom1" rel="adjustX: 20, adjustY:-4, zoomWidth:500, zoomHeight:500" style="position: relative; display: block;">
                                                     <img src="<?=$product['image']['urls']['large']['CDN'] ?>" width="242" height="302" alt="" title="" style="display: block;">
                                                    </a><div class="mousetrap" style="background-image: url(<?=$product['image']['urls']['large']['CDN'] ?>); z-index: 999; position: absolute; width: 242px; height: 302px; left: 0px; top: 0px; cursor: auto;"></div></div>
                                                </div>
                                                <p class="rollover">Roll over image to zoom in</p>
                                            </div>
                                            <? endif; ?>
                                            <div class="pull-right productInfo">
                                                <div class="productTitleBlock">
                                                    <a href="/store/<?=$product['_id']?>/<?=$product['slug']?>" class="productTitle pull-left"><?=$product['name']?></a>
                                                    <? 
                                                    $user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$this->app);
                                                    if(is_array($user) && array_key_exists('accessLevel',$user) && $product['price'] != $product['memberPrice']): ?>
                                                        <div class="price pull-right"><span class="oldPrice">$<?=$product['price']?></span><span class="newPrice">$<?=$product['memberPrice']?></span></div>
                                                    <? else: ?>
                                                        <div class="price pull-right"><span class="newPrice">$<?=$product['price']?></span></div>
                                                    <? endif; ?>
                                                    
                                                </div>
                                                <p class="descr"><?=$product['description']?></p>
                                                <!--
                                                <div class="productInfoBlock">
                                                    <form action="get" class="pull-left">
                                                        <div class="quantity pull-left"><label for="qauntity">quantity</label><input type="text" value="1"></div>
                                                        <input type="submit" value="" class="pull-left">
                                                    </form>
                                                </div>
                                                -->
                                            </div>
                                        </li>
                                        <? endforeach; ?>
                                        
                                    </ul>
                                    <p class="subtitle"><?=$this->vars['page']['body']?></p>
                                    <!--
                                    <h3 class="relatedSubtitle">RELATED PRODUCTS</h3>
                                    <ul class="thumbnails">
                                        <li class="span4">
                                            <div class="thumbnail text-center">
                                                <div class="thumbnailBd">
                                                    <h3>NCDD Logo Polartec Fleece Pullover Zip</h3>
                                                    <p class="price">$25.00</p>
                                                    <a href="#" class="addToCardBtn"></a>
                                                    <a href="#" class="more">more info  &gt;</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="span4">
                                            <div class="thumbnail text-center">
                                                <div class="thumbnailBd">
                                                    <h3>NCDD Logo Polartec Fleece Pullover Zip</h3>
                                                    <p class="price">$25.00</p>
                                                    <a href="#" class="addToCardBtn"></a>
                                                    <a href="#" class="more">more info  &gt;</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="span4">
                                            <div class="thumbnail text-center">
                                                <div class="thumbnailBd">
                                                    <h3>NCDD Logo Polartec Fleece Pullover Zip</h3>
                                                    <p class="price">$25.00</p>
                                                    <a href="#" class="addToCardBtn"></a>
                                                    <a href="#" class="more">more info  &gt;</a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    -->
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
























                        <!--
                        <? if(false): ?>
                        <div class="blogContent">
                            <p class="blogDescr">
                                <?=$this->vars['page']['body']?>
                            </p>
                            <div class="row-fluid">
                                <div class="span8 pull-left">
                                    <? if(!empty($this->vars['seminars'])):?>
                                    <? foreach($this->vars['seminars'] as $seminar): ?>
                                    <? $slug = (array_key_exists('slug',$seminar)) ? '/'.$seminar['slug'] : ''; ?>
                                        <div class="postBody">
                                            <ul class="postHeader">
                                                <li class="dateBlock"><a href="/sessions-and-seminars/<?=$seminar['_id']?><?=$slug?>"><?=$seminar['startDate']['monthDay']?> - <?=$seminar['endDate']['monthDay']?>, <?=$seminar['startDate']['year']?></a></li>
                                            </ul>
                                            <div class="postContent">
                                                <h2 class="postTitle"><?=$seminar['headline']?></h2>
                                                <h5 class="postTitle"><?=(array_key_exists('location',$seminar)) ? $seminar['location']: '';?></h5>
                                                <div class="postMainImg">
                                                    <? if(!empty($seminar['image'])){?>
                                                    <img src="<?=$seminar['image']['urls']['large']['CDN'] ?>" alt="" style="width:60%">
                                                    <? } ?>
                                                </div>
                                                <p class="postDescr"><?=substr($seminar['description'],0,500)?> … <a href="/sessions-and-seminars/<?=$seminar['_id']?><?=$slug?>">read more</a></p>
                                            </div>

                                            <div class="postFooter">
                                                <?if(array_key_exists('register',$seminar) && array_key_exists('currentStatus',$seminar['register']) && $seminar['register']['currentStatus'] == \Saw\Model\SeminarRegister::$status['ON']): ?>
                                                <a href="http://<?=SAW_ADMIN_WEBSITE?>/registration/seminar/<?=$seminar['_id']?><?=$slug?>" class="btn readMore pull-left">Register Online +</a>
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
                            
                        </div>
                    </div>

                    <? endif; ?>
                    -->