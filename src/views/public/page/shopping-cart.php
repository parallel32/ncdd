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
                            <?=$this->element('shopping-cart-items',array('cart_items'=>$this->vars['cart_items'],'readonly'=>'no','user'=>$this->vars['user']));?>
                            <!-- ERROR -->
                             <div class="alert alert-error hide">
                                <button class="close" data-dismiss="alert"></button>
                                You have some form errors. Please check below.
                             </div>
                             <!--/ ERROR -->
                            </form>
                            <? } else { ?>

                            <? } ?>
                            <? if(is_array($this->vars['cart_items']) && !empty($this->vars['cart_items']) && $this->vars['shoppingCartTotal'] > 0){ ?>
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