                    <div class="row-fluid shoppingCart" style="padding-bottom:0px;">
                        <div class="obliqueLineTitle text-center"><h2><?=$this->vars['page']['headline']?></h2></div>
                        <div class="shoppingCartBody productDescrrr">
                            <form>
                          <?=$this->element('shopping-cart-items',array('cart_items'=>$this->vars['cart_items'],'readonly'=>'yes','user'=>$this->vars['user']));?>
                            </form>
                            <a href="/shopping-cart" class="checkoutBtn pull-right">Edit Shopping Cart</a>
                          </div>
                    </div>
                    <div class="row-fluid checkout" style="padding-top:5px;">
                        
                        <!-- BEGIN FORM-->
                        <!-- PAYMENT ELEMENT -->
                          <style>
                          .card {
                          float: left;
                          width: 39px;
                          height: 25px;
                          text-indent: -9999px;
                          background-position: 0 0;
                          background-repeat: no-repeat;
                          padding-right: 2px;
                          }
                          
                          .card.visa {
                          background-image: url('/assets/img/card-visa.gif');
                          }
                          .card.master {
                          background-image: url('/assets/img/card-mastercard.gif');
                          }
                          .card.amex {
                          background-image: url('/assets/img/card-amex.gif');
                          }
                          .card.discover {
                          background-image: url('/assets/img/card-discover.gif');
                          }
                          </style>
                          <form id="payment-form" class="horizontal-form portlet">
                             <!-- ERROR -->
                             <div class="alert alert-error hide">
                                <button class="close" data-dismiss="alert"></button>
                                You have some form errors. Please check below.
                             </div>
                             <!--/ ERROR -->
                             <input id="description" type="hidden" class="description" name="doc[description]" value="">
                             <input id="title" type="hidden" class="title" name="doc[title]" value="">
                             <input type="hidden" class="cardType" name="doc[cardType]" value="">
                             <input type="hidden" class="token" name="doc[token]" value="">
                             <input type="hidden" class="orderId" name="doc[orderId]" value="">
                             <input type="hidden" class="memberId" name="doc[memberId]" value="<?=(array_key_exists('_id', $this->vars['user'])) ? $this->vars['user']['_id']: ''?>">
                             <input type="hidden" class="amount" name="doc[amount]" value="<?=$this->vars['shoppingCartTotal']?>">
                             
                             <div class="obliqueLineTitle"><h2 style="padding:0 25px 0px 0px">Payment Information</h2></div>
                             <div class="row-fluid">
                                <div class="span12 ">
                                   <div class="control-group">
                                      <label class="control-label" for="type">We Accept</label>
                                      <div class="controls">
                                         <span class="card visa" title="Visa">Visa</span>
                                         <span class="card master" title="Mastercard">Mastercard</span>
                                         <span class="card amex" title="American Express">American Express</span>
                                         <span class="card discover" title="Discover">Discover</span>
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span12 "><span class="cardType"></span></div>
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Your name as it appears on the card</label>
                                      <div class="controls">
                                         <input type="text" name="doc[name]" class="m-wrap span8 name" value="<?=(!empty($this->vars['user']) && array_key_exists('displayName', $this->vars['user']) ) ? $this->vars['user']['displayName']: '';?>">
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Credit Card Number</label>
                                      <div class="controls">
                                         <input type="text" name="doc[number]" class="m-wrap span8 number">
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">CVC or Security Code</label>
                                      <div class="controls">
                                         <input type="text" name="doc[cvc]" class="m-wrap span8 cvc">
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Expiration Date</label>
                                      <div class="controls">
                                         <select class="span4 expMonth" name="doc[expMonth]"></select>
                                         <select class="span4 expYear" name="doc[expYear]"></select>
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Email</label>
                                      <div class="controls">
                                         <input type="text" name="doc[email]" class="m-wrap span8 email" value="<?=(!empty($this->vars['user']) && array_key_exists('email', $this->vars['user']) ) ? $this->vars['user']['email']: '';?>">
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Phone</label>
                                      <div class="controls">
                                         <input type="text" name="doc[phone]" class="m-wrap span8 phone" value="<?=(!empty($this->vars['user']) && array_key_exists('phone', $this->vars['user']) ) ? $this->vars['user']['phone']: '';?>">
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             
                             <div class="obliqueLineTitle"><h2 style="padding:0 25px 0px 0px">Billing Address</h2></div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Address Line 1</label>
                                      <div class="controls">
                                         <input type="text" name="doc[addressLine1]" class="m-wrap span8 addressLine1" value="<?=(array_key_exists('location', $this->vars) ) ? $this->vars['location']['addressLine1']: '';?>">
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Address Line 2</label>
                                      <div class="controls">
                                         <input type="text" name="doc[addressLine2]" class="m-wrap span8 addressLine2" value="<?=(array_key_exists('location', $this->vars) ) ? $this->vars['location']['addressLine2']: '';?>">
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">City</label>
                                      <div class="controls">
                                         <input type="text" name="doc[city]" class="m-wrap span8 city" value="<?=(array_key_exists('location', $this->vars) ) ? $this->vars['location']['city']: '';?>">
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">State/Province/Region</label>
                                      <div class="controls">
                                         <input type="text" name="doc[stateProvinceRegion]" class="m-wrap span8 stateProvinceRegion" value="<?=(array_key_exists('location', $this->vars) ) ? $this->vars['location']['state']: '';?>">
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Zip/PostalCode</label>
                                      <div class="controls">
                                         <input type="text" name="doc[zipPostalCode]" class="m-wrap span8 zipPostalCode" value="<?=(array_key_exists('location', $this->vars) ) ? $this->vars['location']['zip']: '';?>">
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Country</label>
                                      <div class="controls">
                                         <input type="text" name="doc[country]" class="m-wrap span8 country" value="<?=(array_key_exists('location', $this->vars) ) ? $this->vars['location']['country']: '';?>">
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="obliqueLineTitle"><h2 style="padding:0 25px 0px 0px">Shipping Address</h2></div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Same as Billing?</label>
                                      <div class="controls">
                                         <input type="checkbox" name="sameasbilling" id="sameasbilling" class="m-wrap span2 " value="">
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Address Line 1</label>
                                      <div class="controls">
                                         <input type="text" name="doc[addressLine1Shipping]" class="m-wrap span8 addressLine1Shipping" value="">
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Address Line 2</label>
                                      <div class="controls">
                                         <input type="text" name="doc[addressLine2Shipping]" class="m-wrap span8 addressLine2Shipping" value="">
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">City</label>
                                      <div class="controls">
                                         <input type="text" name="doc[cityShipping]" class="m-wrap span8 cityShipping" value="">
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">State/Province/Region</label>
                                      <div class="controls">
                                         <input type="text" name="doc[stateProvinceRegionShipping]" class="m-wrap span8 stateProvinceRegionShipping" value="">
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Zip/PostalCode</label>
                                      <div class="controls">
                                         <input type="text" name="doc[zipPostalCodeShipping]" class="m-wrap span8 zipPostalCodeShipping" value="">
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Country</label>
                                      <div class="controls">
                                         <input type="text" name="doc[countryShipping]" class="m-wrap span8 countryShipping" value="">
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <!-- ERROR -->
                             <div class="alert alert-error hide">
                                <button class="close" data-dismiss="alert"></button>
                                You have some form errors. Please check below.
                             </div>
                             <!--/ ERROR -->
                             <!-- SUCCESS -->
                             <div id="payment-success-alert" class="alert alert-success hide" style="margin-bottom:-20px">
                                <button class="close" data-dismiss="alert"></button>
                                Your payment has been successfully processed.  We have sent a receipt to the email address provided.
                                <br>Also, click below for a printer friendly page.
                             </div>
                             <!--/ SUCCESS -->
                             <div class="shoppingCart" style="padding-left:0px">
                             <div class="shoppingCartBody pull-left">
                                <button id="payment-button" type="button" class="checkoutBtn" style="margin-left:0px">Submit Payment</button>
                                <button id="print-button" type="button" class="checkoutBtn hide" style="margin-left:0px">Printer Friendly Receipt</button>
                             </div>
                          </form>
                          
                          <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
                            <?=$this->element('js/Namespace.js');?>
                            <?=$this->element('js/BlockUI.Class.js');?>
                            <?=$this->element('js/FormPostClass.js');?>
                            <?=$this->element('js/Payment.js');?>
                          <script>
                          jQuery(document).ready(function() {    
                            io.saw.Payment.init();

                            $('#sameasbilling').mousedown(function() {
                                if (!$(this).is(':checked')) {
                                    $('.addressLine1Shipping').val($('.addressLine1').val());
                                    $('.addressLine2Shipping').val($('.addressLine2').val());
                                    $('.cityShipping').val($('.city').val());
                                    $('.stateProvinceRegionShipping').val($('.stateProvinceRegion').val());
                                    $('.zipPostalCodeShipping').val($('.zipPostalCode').val());
                                    $('.countryShipping').val($('.country').val());
                                }else{
                                    $('.addressLine1Shipping').val('');
                                    $('.addressLine2Shipping').val('');
                                    $('.cityShipping').val('');
                                    $('.stateProvinceRegionShipping').val('');
                                    $('.zipPostalCodeShipping').val('');
                                    $('.countryShipping').val('');
                                }
                            });


                          });      
                          </script>
                          <!--/ PAYMENT ELEMENT -->
                        <!-- END FORM--> 
                    </div>