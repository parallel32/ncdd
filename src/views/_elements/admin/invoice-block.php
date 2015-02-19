<div class="row-fluid invoice">
               <div class="row-fluid invoice-logo">
                  <div class="span6 invoice-logo-space"><img src="/assets/img/ncdd-login2-logo.png" alt="" /> </div>
                  <div class="span6">
                     <p>#<?=$application['_id']?> / <? $date = new \DateTime(); echo $date->format('d');?> <?echo $date->format('M');?>, <?echo $date->format('Y');?> <span class="muted">Application ID and Date</span></p>
                  </div>
               </div>
               <hr />
               <div class="row-fluid">
                  <div class="span3">
                     <h4>Member:</h4>
                     <ul class="unstyled">
                        <? $middleName = (!empty($application['middleName'])) ? ' '.$application['middleName'].' ':' '; ?>
                        <li><?=$application['firstName']?><?=$middleName?><?=$application['lastName']?></li>
                        <li><?=$application['formattedAddress']?></li>
                        <li>email: <?=$application['email']?></li>
                        <li>phone: <?=(!empty($application['phone'])) ? $application['phone']: $location['phone']?></li>
                        <li>fax: <?=(!empty($application['fax'])) ? $application['fax']: $location['fax']?></li>
                     </ul>
                  </div>
                  <div class="span4">
                     <h4>About:</h4>
                     <ul class="unstyled">
                        <li><?=$application['type']?></li>
                        <li><?=$application['executed']?></li>
                     </ul>
                  </div>
                  <div class="span4 invoice-payment">
                     <h4></h4>
                     <ul class="unstyled">
                        
                     </ul>
                  </div>
               </div>
               <div class="row-fluid">
                  <table class="table table-striped table-hover">
                     <thead>
                        <tr>
                           <th>Item</th>
                           <th class="hidden-480">Description</th>
                           <th class="hidden-480">Quantity</th>
                           <th class="hidden-480">Unit Cost</th>
                           <th>Total</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td>Application</td>
                           <td class="hidden-480"><?=$application['type']?></td>
                           <td class="hidden-480">1</td>
                           <td class="hidden-480">$<?=$application['membershipDues']?></td>
                           <td>$<?=$application['membershipDues']?></td>
                        </tr>

                        <?
                        $discount = 0;
                        // EARLY BIRD DISCOUNT FOR 2014 .. is not over
                        ///*
                        if($application['type'] == 'UPDATE MEMBER APPLICATION'
                            //&& strtotime($application['approvedDate']['iso']) < strtotime('December 31, 2014')
                            && array_key_exists('payment', $member) && array_key_exists('renewalREUSE', $member['payment']) && $member['payment']['renewalREUSE'] == 'yes'
                            && array_key_exists('payment', $member) && array_key_exists('number', $member['payment']) && !empty($member['payment']['number'])
                            && $application['membershipDues'] > 50
                        ): 
                           $discount = 50;
                        ?>
                        <tr>
                           <td>Discount</td>
                           <td class="hidden-480">Early Payment 2014 Discount</td>
                           <td class="hidden-480">1</td>
                           <td class="hidden-480">-$50</td>
                           <td>-$50</td>
                        </tr>
                        <? 
                        endif; 
                        //*/
                        ?>
                        <?
                        $discount3 = 0;
                        // NCDD2015 NEW MEMBER PROMO
                        //*
                        if($application['type'] == 'NEW MEMBER APPLICATION'
                            //&& strtotime($application['approvedDate']['iso']) < strtotime('December 31, 2014')
                            //&& array_key_exists('payment', $member) && array_key_exists('renewalREUSE', $member['payment']) && $member['payment']['renewalREUSE'] == 'yes'
                            && is_array($member) && array_key_exists('payment', $member) 
                            && is_array($member['payment']) && array_key_exists('number', $member['payment']) 
                            //&& !empty($member['payment']['number'])
                            && $application['membershipDues'] > 50
                            && ($application['promocode'] == 'NCDD2015')
                        ): 
                           $discount3 = 50;
                        ?>
                        <tr>
                           <td>Discount</td>
                           <td class="hidden-480">NCDD2015 Promo Discount</td>
                           <td class="hidden-480">1</td>
                           <td class="hidden-480">-$50</td>
                           <td>-$50</td>
                        </tr>
                        <? 
                        endif; 
                        //*/
                        ?>
                        <?
                        // CREDIT DISCOUNT FOR MEMBERS WHO HOLD A CREDIT WITH US
                        $discount2 = 0;
                        if(is_array($member) && array_key_exists('payment',$member) 
                              && !empty($member['payment'])
                              && is_array($member['payment'])
                              && array_key_exists('renewalCredit',$member['payment'])
                              && !empty($member['payment']['renewalCredit'])
                              && $member['payment']['renewalCredit'] > 0
                        ): 
                           $discount2  = $member['payment']['renewalCredit'];
                        ?>
                        <tr>
                           <td>Credit</td>
                           <td class="hidden-480">Prior Membership Dues Credit</td>
                           <td class="hidden-480">1</td>
                           <td class="hidden-480">-$<?=$member['payment']['renewalCredit']?></td>
                           <td>-$<?=$member['payment']['renewalCredit']?></td>
                        </tr>
                        <? endif; ?>



                        <? if($pro_rated_membership_dues['q'] > 1): 
                           $amount = $pro_rated_membership_dues['a'];
                        ?>
                        <tr>
                           <td>Discount</td>
                           <td class="hidden-480">Pro-rated Discount</td>
                           <td class="hidden-480">1</td>
                           <td class="hidden-480">-$<?=$application['membershipDues']-$pro_rated_membership_dues['a']?></td>
                           <td>-$<?=$application['membershipDues']-$pro_rated_membership_dues['a']?></td>
                        </tr>
                        <? else: 
                           $amount = $application['membershipDues'];
                         endif; ?>
                     </tbody>
                  </table>
               </div>
               <div class="row-fluid">
                  <div class="span12 invoice-block">
                     <ul class="unstyled amounts">
                        <li><strong>Total:</strong> $<?$amount = $amount-$discount-$discount2-$discount3; echo ($amount <= 0) ? 0:$amount;?></li>
                     </ul>
                  </div>
               </div>
               <? if($amount <= 0): ?>
               <div class="row-fluid">
                  <div class="span12">
                     <div class="alert alert-error">
                        If you're seeing this, it means your invoice total is either $0 or less than $0.  
                        <br><br>
                        Your invoice has yet to be auto-paid by our automated system.  
                        <br><br>
                        Please wait a few more days or you may contact NCDD and they will take care of this.
                        <br><br>
                        Please note: if you're total is less than $0, the remaining amount of credit will persist in your account and will be applied in your upcoming membership renewal.
                     </div>   
                  </div>
               </div>
               <? endif; ?>
            </div>
            <?
            $this->vars['aamount'] = $amount;
            ?>