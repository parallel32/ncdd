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
												<h2 class="h2">NCDD Payment Receipt</h2>
												<br />
												<div class="textdark">
<br>Dear <?=$this->vars['payment']['name']?>,
<br>
<br>On behalf of the NCDD, thank you for payment.
<br/>
<br>To view the full details of your payment you may browse to the link below:
<br>
<br><a href="https://<?=SAW_ADMIN_WEBSITE?>/payment/<?=$this->vars['paymentId']?>/view" target="_blank">https://<?=SAW_ADMIN_WEBSITE?>/payment/<?=$this->vars['paymentId']?>/view</a>. 
<br>
<br>Sincerely,
<br>
<br>Rhea C. Kirk
<br>Executive Director

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