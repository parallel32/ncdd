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
												<h2 class="h2">NCDD Seminar Confirmation</h2>
												<br />
												<div class="textdark">
<h4 class="h4">Seminar Details:</h4>
<br/><?=$this->vars['seminar']['headline']?>
<br/><?=$this->vars['seminar']['location']?>
<br/><?=$this->vars['seminar']['startDate']['monthDay']?> - <?=$this->vars['seminar']['endDate']['monthDay']?>, <?=$this->vars['seminar']['startDate']['year']?>

<br/><br/><h4 class="h4">Registration Details:</h4>
<table>
	<tr><td><strong>Registrant Name:</strong></td><td><?=$this->vars['registration']['name']?></td></tr>
	<tr><td><strong>Attendees Dinner RSVP:</strong></td><td><?=$this->vars['registration']['rsvp']?></td></tr>
	<tr><td><strong>Material hard copy:</strong></td><td><?=$this->vars['registration']['hardCopy']?></td></tr>
</table>

<br/><br/>Dear <?=$this->vars['registration']['name']?>,
<br/>
<?=$this->vars['seminar']['register']['confirmationLetter']?>
<br/>
<br/>
If you have any questions don't hesitate to contact us at: rhea@ncdd.com
<br/>
<br/>
<br/>National College for DUI Defense, Inc. 
<br/>445 S. Decatur St. 
<br/>Montgomery, AL 36104
<br/>Tel: 334-264-1950 
<br/>Fax: 334-264-1920

<br/>
<br/>


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