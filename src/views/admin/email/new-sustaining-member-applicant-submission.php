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
<br/>Your application for Sustaining Membership has been received.
<br/>
<br/>Below is a link to the online reference form.  Please forward it to your 4 references, one being from your sponsoring Regent or Fellow and remind them to submit is as soon as they can.
<br/>Once we have your 4 references, your application will be presented to the board at the next meeting.
<br/>
<br/><a href="https://<?=SAW_ADMIN_WEBSITE?>/reference/<?=$this->vars['applicationId']?>/<?=$this->vars['firstName'].'-'.$this->vars['lastName']?>" target="_blank">Click here to view the reference form</a>.
<br>
<br/>When your application is approved, you will receive an email with instructions.
<br/>
<br/>Thak you for your Sustaining Member Application.
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