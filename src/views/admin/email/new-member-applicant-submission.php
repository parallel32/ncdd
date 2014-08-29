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
												<h2 class="h2">NCDD Application Received</h2>
												<br />
												<div class="textdark">
<? $middleName = (!empty($this->vars['middleName'])) ? ' '.$this->vars['middleName'].' ':' '; ?>
<br>Dear <?=$this->vars['firstName']?><?=$middleName?><?=$this->vars['lastName']?>;
<br/>
<br/>Your application for General Membership has been received.
<br/><br/>
<br/>Below is a link to the online reference form.  Please forward it to your 2 references and remind them to submit it as soon as they can.
<br/>
<br/><a href="https://<?=SAW_ADMIN_WEBSITE?>/reference/<?=$this->vars['applicationId']?>/<?=$this->vars['firstName'].'-'.$this->vars['lastName']?>" target="_blank">Click here to view the reference form</a>. 
<br><br>
<br/>When your application is approved, you will receive an email with instructions.
<br/>
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