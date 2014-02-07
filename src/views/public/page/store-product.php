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
                                                    <div id="wrap" style="top:0px;z-index:99;position:relative;"><a href="<?=$product['image']['urls']['large']['CDN'] ?>" class="cloud-zoom" id="zoom1" rel="adjustX: 20, adjustY:-4, zoomWidth:500, zoomHeight:500" style="position: relative; display: block;">
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
                                                            
                                                            <form id="saw-form">
                                                                <input id="doc-quantity" type="hidden" name="doc[quantity]" value="1">
                                                                <input id="" type="hidden" name="doc[productId]" value="<?=$product['_id']?>">
                                                                <? if(array_key_exists('purchaseInstructions', $product) && !empty($product['purchaseInstructions'])){ ?>
                                                                <div class="control-group">
                                                                    <label  class="control-label">Purchase Instructions</label>
                                                                    <p><?=$product['purchaseInstructions']?></p>
                                                                    <label class="control-label">Preference:</label>
                                                                    <div class="controls">
                                                                        <textarea class="span10 preference" name="doc[preference]"></textarea>
                                                                    </div>
                                                                </div>
                                                                <? } ?>
                                                            </form>
                                                            
                                                        </div>
                                                        <div class="quantityBox pull-right">
                                                        <form id="saw-form2" action="get" class="text-center">
                                                            <div class="quantity"><label for="quantity">quantity</label><input type="text" value="1" id="quantity"></div>
                                                            <input id="add-to-cart" type="button" value="">
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
                                    
                                    <!-- RELATED PRODUCTS-->
                                    <h3 class="relatedSubtitle">RELATED PRODUCTS</h3>
                                    <ul class="thumbnails">
                                        <? foreach($this->vars['related_products'] as $product): ?>
                                        <li class="span4 productDescr">
                                            <div class="thumbnail text-center">
                                                <div class="thumbnailBd">
                                                    <h3><?=$product['name']?></h3>
                                                    <p class="price">$<?=$product['price']?></p>
                                                    <a href="" data-id="<?=$product['_id']?>" class="addToCardBtn"></a>
                                                    <a href="/store/<?=$product['_id']?><?=$product['slug']?>" class="more">more info  &gt;</a>
                                                </div>
                                            </div>
                                        </li>
                                        <? endforeach; ?>
                                    </ul>
                                    <!--/ RELATED PRODUCTS-->

                                    <p class="subtitle"><?=$this->vars['page']['body']?></p>
                                    
                                </div>
                            </div>
                        </div>
                    </div>





                    </div>


<?=$this->element('js/Namespace.js');?>
<?=$this->element('js/BlockUI.Class.js');?>
<?=$this->element('js/FormGetClass.js');?>
<?=$this->element('js/FormPostClass.js');?>
<?=$this->element('js/ShoppingCart.js');?>
<script>
jQuery(document).ready(function() {
    io.saw.ShoppingCart.init();
       
});      
</script>