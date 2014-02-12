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
												<h2 class="h2">Blog Post Submitted for Review</h2>
												<br />
												<div class="textdark">
													Some information about the blog post and the author:
													<br/>
													<? $middleName = (!empty($this->vars['middleName'])) ? ' '.$this->vars['middleName'].' ':' '; ?>
													<br/><?=$this->vars['firstName'].$middleName.$this->vars['lastName']?>
													<br/><?=$this->vars['email']?>
													<br/>
													<br/><?=$this->vars['headline']?>
													<br/>
													<br/>
													<br/>
													<a href="http://<?=SAW_ADMIN_WEBSITE?>/blog/all-posts" target="_blank">Go to the Admin Dashboard to view this and other Blog posts. http://<?=SAW_ADMIN_WEBSITE?></a>. 
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