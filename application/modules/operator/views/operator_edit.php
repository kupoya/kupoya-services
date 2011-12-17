<?php

echo "<br/><br/>";
if (isset($message)) echo $message;
echo "<br/><br/>";

echo validation_errors();
echo "<br/><br/>";
echo "<br/><br/>";

var_dump($operator);
echo "<br/><br/>";
var_dump($contact);

echo "<br/><br/>";
echo "<br/><br/>";

//var_dump($error);


echo "<br/><br/>";
?>

<form name='operator' action='<?php echo base_url().'operator/change_password'?>' method='post'>

	operator id
	<input type='text' name='operator[id]'
			value='<?= set_value('operator[id]', isset($operator['id']) ? $operator['id'] : '')  ?>' />
	<br/>

	operator old password
	<input type='text' name='old_password'
			value='<?= set_value('old_password', '')  ?>' />
	<br/>

	operator new password
	<input type='text' name='new_password'
			value='<?= set_value('new_password', '')  ?>' />
	<br/>
	operator new password (confirm)
	<input type='text' name='new_password_confirm'
			value='<?= set_value('new_password_confirm', '')  ?>' />
	<br/>

	<input type='submit' name='submit' value='submit' />

</form>