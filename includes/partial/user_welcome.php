<?php
	session_start();
	// load functions
	include_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php');
?>
<h3>Information</h3>
<p>Welcome to <?php echo(CODENAME);?>, please use the form to log tickets for engineers, once your ticket is logged you will receive email feedback on your issue, you can also return here at any time to see the status of your ticket.</p>
<p class="note">Remember the more information you provide the quicker the engineer can fix your problem. For example, your printer is out of ink please include, printer model, colour of ink cartridge, room the printer is in. etc.</p>