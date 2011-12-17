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

<form name='operator' action='<?php echo base_url().'operator/view_contact'?>' method='post'>

	operator id
	<input type='text' name='operator_id'
			value='<?= set_value('operator_id', isset($operator['id']) ? $operator['id'] : '')  ?>' />
	<br/>

	contact name
	<input type='text' name='contact[name]'
			value='<?= set_value('contact[name]', isset($contact['name']) ? $contact['name'] : '')  ?>' />
	<br/>

	contact first_name
	<input type='text' name='contact[first_name]'
			value='<?= set_value('contact[first_name]', isset($contact['first_name']) ? $contact['first_name'] : '')  ?>' />
	<br/>

	contact last_name
	<input type='text' name='contact[last_name]'
			value='<?= set_value('contact[last_name]', isset($contact['last_name']) ? $contact['last_name'] : '')  ?>' />
	<br/>

	contact address
	<input type='text' name='contact[address]'
			value='<?= set_value('contact[address]', isset($contact['address']) ? $contact['address'] : '')  ?>' />
	<br/>

	contact city
	<input type='text' name='contact[city]'
			value='<?= set_value('contact[city]', isset($contact['city']) ? $contact['city'] : '')  ?>' />
	<br/>

	contact state
	<input type='text' name='contact[state]'
			value='<?= set_value('contact[state]', isset($contact['state']) ? $contact['state'] : '')  ?>' />
	<br/>

	contact country
	<input type='text' name='contact[country]'
			value='<?= set_value('contact[country]', isset($contact['country']) ? $contact['country'] : '')  ?>' />
	<br/>

	contact phone
	<input type='text' name='contact[phone]'
			value='<?= set_value('contact[phone]', isset($contact['phone']) ? $contact['phone'] : '')  ?>' />
	<br/>

	contact gender
	<input type='text' name='contact[gender]'
			value='<?= set_value('contact[gender]', isset($contact['gender']) ? $contact['gender'] : '')  ?>' />
	<br/>

	contact email
	<input type='text' name='contact[email]'
			value='<?= set_value('contact[email]', isset($contact['email']) ? $contact['email'] : '')  ?>' />
	<br/>

	<input type='submit' name='submit' value='submit' />

</form>