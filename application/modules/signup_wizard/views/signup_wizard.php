<?php

echo "<br/><br/>";
echo $message;
echo "<br/><br/>";

echo validation_errors();
echo "<br/><br/>";
echo "<br/><br/>";

?>


<form name='test' action='<?php echo base_url().'signup_wizard/create'?>' method='post'>

	brand name
	<input type='text' name='brand_name' value='<?= set_value('brand_name', '') ?>' />
	<br/>

	first name
	<input type='text' name='first_name' value='<?= set_value('first_name', '') ?>' />
	<br/>

	last name
	<input type='text' name='last_name' value='<?= set_value('last_name', '') ?>' />
	<br/>
<!--
	// we're not going to have usernames
	username
	<input type='text' name='username' value='' />
	<br/>
-->
	password
	<input type='password' name='password' value='<?= set_value('password', '') ?>' />
	<br/>

	password confirm
	<input type='password' name='password_confirm' value='<?= set_value('password_confirm', '') ?>' />
	<br/>

	email
	<input type='text' name='email' value='<?= set_value('email', '') ?>' />
	<br/><br/>

	<input type='submit' name='submit' value='submit' />

</form>