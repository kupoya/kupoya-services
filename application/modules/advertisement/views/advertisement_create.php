<?php

echo "<br/><br/>";
if (isset($message)) echo $message;
echo "<br/><br/>";

echo validation_errors();
echo "<br/><br/>";
echo "<br/><br/>";

var_dump($data);

var_dump($error);


echo "<br/><br/>";
?>


<form name='test' action='<?php echo base_url().'advertisement/create'?>' method='post'>

	strategy name
	<input type='text' name='strategy[name]' value='<?= set_value('strategy[name]', '') ?>' />
	<br/>

	strategy description
	<input type='text' name='strategy[description]' value='<?= set_value('strategy[description]', '') ?>' />
	<br/>

	strategy picture
	<input type='text' name='strategy[picture]' value='<?= set_value('strategy[picture]', '') ?>' />
	<br/>

	strategy website
	<input type='text' name='strategy[website]' value='<?= set_value('strategy[website]', '') ?>' />
	<br/>

	redirect url
	<input type='text' name='advertisement[redirect_url]' value='<?= set_value('advertisement[redirect_url]', '') ?>' />
	<br/>

	choose plan
	<?= form_dropdown('plan[id]', $plans); ?>
	<br/>

	promotion
	<input type='text' name='order[promotion_id]' value='<?= set_value('order[promotion_id]', '') ?>' />
	<br/>



	<input type='submit' name='submit' value='submit' />

</form>