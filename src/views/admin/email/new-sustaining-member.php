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
												<h2 class="h2">Sustaining Member Application Form</h2>
												<br />
												<div class="textdark">
													The sustaining member application form has been submitted:
													<br/>
													<? $middleName = (!empty($this->vars['middleName'])) ? ' '.$this->vars['middleName'].' ':' '; ?>
													<br/><?=$this->vars['firstName'].$middleName.$this->vars['lastName']?>
													<br/><?=$this->vars['city'].', '.$this->vars['state']?>
													<br/><?=$this->vars['email']?>
													<br/>
													<br/>
													<br/>
													<a href="http://<?=SAW_ADMIN_WEBSITE?>" target="_blank">Go to the Admin Dashboard to view this and other Applications. http://<?=SAW_ADMIN_WEBSITE?></a>. 
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