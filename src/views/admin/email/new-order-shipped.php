		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td style="padding-bottom:20px;">
					<center>
						<table border="0" cellpadding="0" cellspacing="0" width="600px" style="height:100%;">
							<tr>
								<td valign="top" class="bodyContent">
									<table border="0" cellpadding="20" cellspacing="0" width="100%">
										<tr>
											<td valign="top">
												<h2 class="h2">Your NCDD Store Order Has Shipped</h2>
												<br />
												<div class="textdark">
													Below you'll find your tracking number with our shipping company:
													<br/>
													<br/>Shipping Company: <?=$this->vars['order']['shippingCompany']?><br/>
													<br/>Tracking Number: <?=$this->vars['order']['trackingNumber']?><br/>
													<br/>
               										You can view your full receipt details online by clicking <a href="http://<?=SAW_CONSUMER_WEBSITE?>/shopping-cart/checkout/receipt/<?=$this->vars['order']['_id']?>" target="_blank">here</a> </a> <br>
									               <br>
									               Or browsing to here: http://<?=SAW_CONSUMER_WEBSITE?>/shopping-cart/checkout/receipt/<?=$this->vars['order']['_id']?>
         										</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</center>
				</td>
			</tr>
		</table>