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
												<h2 class="h2">Your NCDD Seminar Registration Details</h2>
												<br />
												<div class="textdark">
<h4 class="h4">Seminar Details:</h4>
<br/><?=$this->vars['seminar']['headline']?>
<br/><?=$this->vars['seminar']['location']?>
<br/><?=$this->vars['seminar']['startDate']['monthDay']?> - <?=$this->vars['seminar']['endDate']['monthDay']?>, <?=$this->vars['seminar']['startDate']['year']?>

<br/><br/><h4 class="h4">Registration Details:</h4><br/>
<table>
	<tr><td><strong>Registrant Name:</strong></td><td><?=$this->vars['registration']['name']?></td></tr>
	<? if((array_key_exists('register',$this->vars['seminar']) && array_key_exists('rsvpQuestion',$this->vars['seminar']['register']) && $this->vars['seminar']['register']['rsvpQuestion'] == 'ON') || (array_key_exists('register',$this->vars['seminar']) && !array_key_exists('rsvpQuestion',$this->vars['seminar']['register'])) ): ?>
	<tr><td><strong>Attendees Dinner RSVP:</strong></td><td><?=$this->vars['registration']['rsvp']?></td></tr>
	<tr><td><strong>Children Attendees Dinner RSVP:</strong></td><td><?=(array_key_exists('rsvpkids',$this->vars['registration'])) ? $this->vars['registration']['rsvpkids'] : 0?></td></tr>
	<? endif; ?>
	<? if(array_key_exists('hardCopy',$this->vars) && !empty($this->vars['hardCopy']) && $this->vars['hardCopy'] == 'YES'): ?>
	<tr><td><strong>Material hard copy:</strong></td><td><?=$this->vars['registration']['hardCopy']?></td></tr>
	<? endif; ?>
</table>

<? 
$confirm_letter_header = <<<EOT
<br/><br/>Dear {$this->vars['registration']['name']},
<br/>
EOT;
?>

<? 
$confirm_letter_body = '';
switch ($this->vars['registration']['currentStatus']) {
	case \Saw\Model\Registration::$status['DEPOSIT']:
	case \Saw\Model\Registration::$status['DEPOSITBALANCE']:
		$confirm_letter_body = $this->vars['seminar']['register']['depositConfirmationLetter'];
		break;
	case \Saw\Model\Registration::$status['PAID']:
		$confirm_letter_body = $this->vars['seminar']['register']['confirmationLetter'];
		break;
	case \Saw\Model\Registration::$status['SCHOLARSHIP']:
		$confirm_letter_body = $this->vars['seminar']['register']['scholarshipConfirmationLetter'];
		break;
}
?>


<?
$confirm_letter_footer = '';
if(\Saw\Model\Payment::$paymentType['CHECK'] == $this->vars['registration']['currentPaymentType']){
$confirm_letter_footer = <<<EOT
<br/>
<br/>
We noticed you chose to pay for your registration by check.  Please be sure to mail your check to the address below to secure your spot in the seminar.
EOT;
}
?>
<? 
if(!empty($confirm_letter_body)){
	echo $confirm_letter_header;
	echo $confirm_letter_body;
}
echo $confirm_letter_footer;
?>

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