<?
$user = $this->app['session']->get('user');
?>
                    <div class="row-fluid shoppingCart">
                        <div class="obliqueLineTitle text-center"><h2><?=$this->vars['page']['headline']?></h2></div>
                        <div class="shoppingCartBody productDescrrr">
                            <? if(strlen(trim($this->vars['page']['body'])) > 10){ ?>
                            <?=$this->vars['page']['body']?>
                            <br>
                            <? } 

                            if(is_array($this->vars['cart_items']) && !empty($this->vars['cart_items'])){
                            ?>
                            <form id="saw-form">
                            <table class="table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th></th>
                                        <th>quantity</th>
                                        <th>unit price</th>
                                        <th>price</th>
                                    </tr>
                                </thead>
                                <? 
                                $total = 0;
                                $discount = 0;
                                $fullprice = 0;
                                
                                foreach($this->vars['cart_items'] as $item): ?>
                                
                                <tr id="row-<?=$item['_id']?>">
                                    <td><img style="width:50%" src="<?=$item['image']['urls']['small']['CDN'] ?>" alt=""></td>
                                    <td>
                                        <div class="row-fluid">
                                            <b><a href="/store/<?=$item['_id']?><?=$item['slug']?>"><?=$item['name'] ?> </a></b>
                                        </div>
                                        <? if(!empty($item['purchaseInstructions'])){?>
                                        
                                        <div class="row-fluid">
                                            <div class="span10 ">
                                              <div class="control-group ">
                                                <span class="help-block"><?=$item['purchaseInstructions']?></span>
                                                 <label class="control-label">Preference:</label>
                                                 <div class="controls">
                                                    <textarea name="doc[<?=$item['_id']?>][preference]" id="preference-<?=$item['_id']?>" rows="3" class="span10 preference-<?=$item['_id']?>"><?=$item['preference']?></textarea>
                                                    
                                                 </div>
                                              </div>
                                           </div>
                                        </div>
                                        
                                        <? } ?>
                                    </td>
                                    <td id="cell-<?=$item['_id']?>">
                                        <span>
                                            <div class="control-group ">
                                                 <label class="control-label"></label>
                                                 <div class="controls">
                                                    <input id="quantity-<?=$item['_id']?>" type="text" name="doc[<?=$item['_id']?>][quantity]" value="<?=$item['quantity']?>" class="quantity-<?=$item['_id']?>">
                                                 </div>
                                              </div>
                                            
                                            <input type="button" value="Update" data-id="<?=$item['_id']?>" class="btn update">
                                            <a href="" data-id="<?=$item['_id']?>" class="remove">Remove</a>
                                        </span>
                                    </td>
                                    <td>$<?=number_format($item['price'],2);?></td>
                                    <td>$<?=number_format($item['price']*$item['quantity'],2)?></td>
                                </tr>
                                <? 
                                $total = $total + $item['price'] * $item['quantity'];
                                $discount = $discount + (($item['price']-$item['memberPrice']) * $item['quantity']);
                                endforeach; 
                                ?>
                                
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <? if(is_array($user) && array_key_exists('accessLevel', $user)): ?>
                                    <td>
                                        <ul>
                                            <li>Subtotal</li>
                                            <li>Member Discount</li>
                                        </ul>
                                    </td>

                                    <td>
                                        <ul>
                                            <li>$<?=number_format($total,2)?></li>
                                            <li>-$<?=number_format($discount,2)?></li>
                                        </ul>
                                    </td>
                                    <? else: ?>
                                    <td></td>
                                    <td></td>
                                    <? endif; ?>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>TOTAL</td>
                                    <? if(is_array($user) && array_key_exists('accessLevel', $user)): ?>
                                    <td>$<?=number_format($total-$discount,2)?></td>
                                    <? else: ?>
                                    <td>$<?=number_format($total,2)?></td>
                                    <? endif; ?>
                                </tr>
                            </table>
                            <!-- ERROR -->
                             <div class="alert alert-error hide">
                                <button class="close" data-dismiss="alert"></button>
                                You have some form errors. Please check below.
                             </div>
                             <!--/ ERROR -->
                            </form>
                            <? } else { ?>

                            <? } ?>
                            <? if(is_array($this->vars['cart_items']) && !empty($this->vars['cart_items']) && $total > 0){ ?>
                            <a href="#" class="checkoutBtn  pull-right">Checkout</a>
                            <? } ?>
                            <a href="/store" class="btn pull-right">Continue Shopping</a>
                            
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