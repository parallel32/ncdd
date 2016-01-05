<? 
$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$this->app);
if(is_array($user) && array_key_exists('accessLevel',$user)): 
   $signed_in = true;
else: 
   $signed_in = false;
endif; 
?>
                    <div class="row-fluid blog">
                        <div class="title text-center">
                            <div class="bg">
                                <h3><?=$this->vars['page']['headline']?></h3>
                            </div>
                        </div>



                        <script src="<?=SAW_PUBLIC_SSL_CDN?>/assets/js/cloud-zoom.1.0.2.js"></script>

                        <div class="row-fluid checkout">
                        <ul class="breadcrumb">
                            <li ><a href="/store">Store</a></li>
                            <li class="active"><?=$this->vars['category']['name']?></li>
                            <li><a href="/shopping-cart">Shopping Cart</a></li>
                        </ul>
                        </div>

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
                                                    <div id="wrap" style="top:0px;z-index:99;position:relative;"><a href="<?=$product['image']['urls']['large']['SSLCDN'] ?>" class="cloud-zoom" id="zoom1" rel="adjustX: 20, adjustY:-4, zoomWidth:500, zoomHeight:500" style="position: relative; display: block;">
                                                     <img src="<?=$product['image']['urls']['large']['SSLCDN'] ?>" width="242" height="302" alt="" title="" style="display: block;">
                                                    </a></div>
                                                </div>
                                                <p class="rollover">Roll over image to zoom in</p>
                                            </div>
                                            <? endif; ?>
                                            <div class="pull-right productInfo productDescr">
                                                <div class="productTitleBlock">
                                                    <a href="/store/<?=$product['_id']?><?=$product['slug']?>" class="productTitle pull-left"><?=$product['name']?></a>
                                                    <? if($signed_in && $product['price'] != $product['memberPrice']): ?>
                                                        <div class="price pull-right"><span class="oldPrice">$<?=$product['price']?></span><span class="newPrice">$<?=$product['memberPrice']?> (member price)</span></div>
                                                    <? else: ?>
                                                        <div class="price pull-right"><span class="newPrice">$<?=$product['price']?></span></div>
                                                    <? endif; ?>
                                                    
                                                </div>
                                                
                                                <div class="productInfoBlock pull-right">
                                                    <form class="pull-left">
                                                        <? if(!$signed_in && $product['currentStatus'] == \Saw\Model\Product::$status['MEMBERSONLY']): ?> 
                                                            <div class="quantity pull-left"><label for="qauntity">Purchase of this item is<br> reserved for members only</label></div>
                                                        <? else: ?>
                                                            <div class="quantity pull-left"><label for="qauntity">quantity</label><input class="quantity-input" type="text" value="1"></div>
                                                            <input data-id="<?=$product['_id']?>" type="button" value="" class="addToCardBtn pull-left">
                                                        <? endif; ?>
                                                    </form>
                                                </div>
                                                <p class="descr"><?=$product['description']?></p>
                                                
                                                
                                                
                                            </div>
                                        </li>
                                        <? endforeach; ?>
                                        
                                    </ul>
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