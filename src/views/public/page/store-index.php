
                    <div class="row-fluid blog">
                        <div class="title text-center">
                            <div class="bg">
                                <h3><?=$this->vars['page']['headline']?></h3>
                            </div>
                        </div>



                        <script src="<?=SAW_PUBLIC_SSL_CDN?>/assets/js/cloud-zoom.1.0.2.js"></script>


                        <div class="row-fluid discoverLearnPage NCDDListDetailPage">
                        <div class="discoverContent">
                            <div class="pull-right span12 tab-content">
                                <div class="tab-pane active" id="ncddStorePage">
                                    <ul class="productList">
                                        <? foreach($this->vars['categories'] as $category): ?>
                                        <li class="productListItem">
                                            <? if (!empty($category['image'])): ?>
                                            <div class="pull-left text-center">
                                                <div class="categoryImg">
                                                    <div id="wrap" style="top:0px;z-index:9999;position:relative;"><a href="<?=$category['image']['urls']['large']['SSLCDN'] ?>" class="cloud-zoom" id="zoom1" rel="adjustX: 20, adjustY:-4, zoomWidth:500, zoomHeight:500" style="position: relative; display: block;">
                                                     <img src="<?=$category['image']['urls']['large']['SSLCDN'] ?>" width="400" alt="" title="" style="display: block;">
                                                    </a></div>
                                                </div>
                                                <p class="rollover">Roll over image to zoom in</p>
                                            </div>
                                            <? endif; ?>
                                            <div class="pull-right productInfo">
                                                <div class="productTitleBlock">
                                                    <a href="/store<?=$category['slug']?>" class="productTitle pull-left"><?=$category['name']?></a>
                                                </div>
                                                
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
