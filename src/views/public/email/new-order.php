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
												<h2 class="h2">NCDD Store Order</h2>
												<br />
												<div class="textdark">
													A new order has been placed from the NCDD Store:
													<br/>
													<br/>Placed by: <?=$this->vars['order']['payment']['name']?><br/>
													<br/>Email: <?=$this->vars['order']['payment']['email']?><br/>
													<br/>Phone: <?=$this->vars['order']['payment']['phone']?><br/>
													<br/>
													<a href="http://<?=SAW_ADMIN_WEBSITE?>/product" target="_blank">Go to the Admin Dashboard to view this and other orders. http://<?=SAW_ADMIN_WEBSITE?></a>. 
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