
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
                                
                                foreach($cart_items as $item): ?>
                                
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
                                                    <? if($readonly == 'no'): ?>
                                                    <textarea name="doc[<?=$item['_id']?>][preference]" id="preference-<?=$item['_id']?>" rows="3" class="span10 preference-<?=$item['_id']?>"><?=$item['preference']?></textarea>
                                                    <? else: ?>
                                                    <?=$item['preference']?>
                                                    <? endif; ?>
                                                    
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
                                                    <? if($readonly == 'no'): ?>
                                                    <input id="quantity-<?=$item['_id']?>" type="text" name="doc[<?=$item['_id']?>][quantity]" value="<?=$item['quantity']?>" class="quantity-<?=$item['_id']?>">
                                                    <? else: ?>
                                                    <?=$item['quantity']?>
                                                    <? endif; ?>
                                                 </div>
                                              </div>
                                            <? if($readonly == 'no'): ?>
                                            <input type="button" value="Update" data-id="<?=$item['_id']?>" class="btn update">
                                            <a href="" data-id="<?=$item['_id']?>" class="remove">Remove</a>
                                            <? endif; ?>
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
                                    <td>$<?=number_format($total-$discount,2)?><?$this->vars['shoppingCartTotal'] = $total-$discount;?></td>
                                    <? else: ?>
                                    <td>$<?=number_format($total,2)?><?$this->vars['shoppingCartTotal'] = $total;?></td>
                                    <? endif; ?>
                                </tr>
                            </table>