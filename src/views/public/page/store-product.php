                    <? $product = $this->vars['product']; ?>
                    <div class="row-fluid blog">
                        <div class="title text-center">
                            <div class="bg">
                                <h3><?=$this->vars['page']['headline']?></h3>
                            </div>
                        </div>
                        


                        <link href="/assets/stylesheets/jquery.formstyler.css" rel="stylesheet">

                        <script src="/assets/js/cloud-zoom.1.0.2.js"></script>
                        <script src="/assets/js/jquery.formstyler.min.js"></script>


                        <div class="row-fluid discoverLearnPage NCDDListDetailPage">
                        <div class="discoverContent">
                            
                            <div class="pull-right span12 tab-content">
                                <div class="tab-pane active" id="ncddStorePage">
                                    <ul class="productList">
                                        <li class="productListItem">
                                            <? if (!empty($product['image'])): ?>
                                            <div class="pull-left text-center">
                                                <div class="productImg">
                                                    <div id="wrap" style="top:0px;z-index:9999;position:relative;"><a href="<?=$product['image']['urls']['large']['CDN'] ?>" class="cloud-zoom" id="zoom1" rel="adjustX: 20, adjustY:-4, zoomWidth:500, zoomHeight:500" style="position: relative; display: block;">
                                                     <img src="<?=$product['image']['urls']['large']['CDN'] ?>" width="242" height="302" alt="" title="" style="display: block;">
                                                    </a></div>
                                                </div>
                                                <p class="rollover">Roll over image to zoom in</p>
                                            </div>
                                            <? endif; ?>
                                            <div class="pull-right productInfo">
                                                <div class="productTitleBlock">
                                                    <h3 class="productTitle pull-left"><?=$product['name']?></h3>
                                                    <? 
                                                    $user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$this->app);
                                                    if(is_array($user) && array_key_exists('accessLevel',$user) && $product['price'] != $product['memberPrice']): ?>
                                                        <div class="price pull-right"><span class="oldPrice">$<?=$product['price']?></span><span class="newPrice">$<?=$product['memberPrice']?></span></div>
                                                    <? else: ?>
                                                        <div class="price pull-right"><span class="newPrice">$<?=$product['price']?></span></div>
                                                    <? endif; ?>
                                                </div>
                                                <div class="flw">
                                                    <div class="productDescr">
                                                        <div class="pull-left productDescrleft">
                                                            <dl class="dl-horizontal">
                                                              <dt>Category:</dt>
                                                              <dd><?=$product['category']['name']?></dd>
                                                              <dt>Availability:</dt>
                                                              <dd>In Stock</dd>
                                                            </dl>
                                                            <!--
                                                            <form action="get">
                                                                <div class="control-group">
                                                                    <label for="colour">Colour</label>
                                                                    <select name="colour" id="colour" style="position: absolute; left: -9999px;">
                                                                        <option value="">-- Please selected --</option>
                                                                        <option value="">Red</option>
                                                                        <option value="">Blue</option>
                                                                    </select><span id="colour-styler" class="jq-selectbox jqselect" style="display: inline-block; position: relative; z-index:100"><div class="jq-selectbox__select"><div class="jq-selectbox__select-text">-- Please selected --</div><div class="jq-selectbox__trigger"><div class="jq-selectbox__trigger-arrow"></div></div></div><div class="jq-selectbox__dropdown" style="position: absolute; overflow-y: auto; overflow-x: hidden; left: 0px; display: none;"><ul style="list-style: none"><li class="selected sel">-- Please selected --</li><li class="">Red</li><li class="">Blue</li></ul></div></span>
                                                                </div>
                                                                <div class="control-group">
                                                                    <label for="size">Size</label>
                                                                    <select name="size" id="size" style="position: absolute; left: -9999px;">
                                                                        <option value="">--Please select --</option>
                                                                        <option value="">S</option>
                                                                        <option value="">M</option>
                                                                    </select><span id="size-styler" class="jq-selectbox jqselect" style="display: inline-block; position: relative; z-index:100"><div class="jq-selectbox__select"><div class="jq-selectbox__select-text">--Please select --</div><div class="jq-selectbox__trigger"><div class="jq-selectbox__trigger-arrow"></div></div></div><div class="jq-selectbox__dropdown" style="position: absolute; overflow-y: auto; overflow-x: hidden; left: 0px; display: none;"><ul style="list-style: none"><li class="selected sel">--Please select --</li><li class="">S</li><li class="">M</li></ul></div></span>
                                                                </div>
                                                            </form>
                                                            -->
                                                        </div>
                                                        <div class="quantityBox pull-right">
                                                        <form action="get" class="text-center">
                                                            <div class="quantity"><label for="qauntity">quantity</label><input type="text" value="1" id="qauntity"></div>
                                                            <input type="submit" value="">
                                                        </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="productInfoBlock">
                                                <p><?=$product['description']?></p>
                                                </div>
                                                
                                            </div>
                                        </li>
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
<script>
            $(function() {
                $('select').styler();
            });
        </script>
















                            