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
												<h2 class="h2"></h2>
												<br />
												<div class="textdark">
<? $middleName = (!empty($this->vars['middleName'])) ? ' '.$this->vars['middleName'].' ':' '; ?>
<br>Dear <?=$this->vars['firstName']?><?=$middleName?><?=$this->vars['lastName']?>,
<br>
<br>Your <?=date('Y')?> dues in the amoutn of $<?=$this->vars['membershipDues']?> have been charged.  Thank you for your payment.  Your membership renewal is NOT COMPLETE until we have also received your renewal form.
<br/>
<br>Please follow these simple instructions to submit your Membership Renewal Form:
<br/>
<br>1.  Log in to the NCDD Website Member Portal:  <a href="https://<?=SAW_ADMIN_WEBSITE?>/login" target="_blank">https://<?=SAW_ADMIN_WEBSITE?>/login</a>. 
<br/>
<br>2.  Click the green button at the top that reads: "Click Here to Submit Your Renewal Form."
<br>
<br>Please let me know if you have any questions.
<br>
<br>Sincerely,
<br>
<br>Rhea C. Kirk
<br>Executive Director
<br>
<br/>If you have any questions don't hesitate to contact us at: rhea@ncdd.com
<br>National College for DUI Defense, Inc. 
<br>445 S. Decatur St. 
<br>Montgomery, AL 36104 
<br>Tel: 334-264-1950 
<br>Fax: 334-264-1920

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