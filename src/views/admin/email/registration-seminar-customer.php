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
												<h2 class="h2">NCDD Seminar Registration Details and Reciept</h2>
												<br />
												<div class="textdark">
<h4 class="h4">Seminar Details:</h4>
<br/><?=$this->vars['seminar']['headline']?>
<br/><?=$this->vars['seminar']['location']?>
<br/><?=$this->vars['seminar']['startDate']['monthDay']?> - <?=$this->vars['seminar']['endDate']['monthDay']?>, <?=$this->vars['seminar']['startDate']['year']?>

<br/><br/><h4 class="h4">Registration Details:</h4>
<table>
	<tr><td><strong>Registrant Name:</strong></td><td><?=$this->vars['registrantName']?></td></tr>
	<tr><td><strong>Attendees Dinner RSVP:</strong></td><td><?=$this->vars['rsvp']?></td></tr>
	<tr><td><strong>Material hard copy:</strong></td><td><?=$this->vars['hardCopy']?></td></tr>
</table>

<br/><br/><h4 class="h4">Payment Details:</h4>
<table>
	<tr><td><strong>Registration fee:</strong></td><td>$<?=$this->vars['registrationFee']?></td></tr>
	<tr><td><strong>Hard copy fee:</strong></td><td>$<?=($this->vars['hardCopy'] == 'NO') ? 0 : $this->vars['hardCopyFee']?></td></tr>
	<tr><td><strong>Total:</strong></td><td>$<?=$this->vars['total']?></td></tr>
</table>
<? if($this->vars['paymentType'] == 'credit'):?>
<br/><strong>Paid with:</strong> <?=$this->vars['cardType'].' ending in: '.$this->vars['cardNumber']?>
<? else: ?>
<br/>You have opted to pay by check.  Please mail a <strong>check payable to NCDD</strong> at the following address:
<br/>
<br/>National College for DUI Defense, Inc. 
<br/>445 S. Decatur St. 
<br/>Montgomery, AL 36104
<br/>Tel: 334-264-1950 
<br/>Fax: 334-264-1920
<? endif; ?>
<br/>
<br/>If you have any questions don't hesitate to contact us at: rhea@ncdd.com
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