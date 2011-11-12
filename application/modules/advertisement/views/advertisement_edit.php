<?php

echo "<br/><br/>";
if (isset($message)) echo $message;
echo "<br/><br/>";

echo validation_errors();
echo "<br/><br/>";
echo "<br/><br/>";

var_dump($strategy);

var_dump($plan);

//var_dump($error);


echo "<br/><br/>";
?>


<form name='test' action='<?php echo base_url().'advertisement/save'?>' method='post'>

	<!-- the strategy id -->
	<input type='text' name='strategy[id]'
			value='<?= set_value('strategy[id]', isset($strategy['id']) ? $strategy['id'] : '')  ?>' />
	<br/>

	strategy name
	<input type='text' name='strategy[name]'
			value='<?= set_value('strategy[name]', isset($strategy['name']) ? $strategy['name'] : '')  ?>' />
	<br/>

	strategy description
	<input type='text' name='strategy[description]'
			value='<?= set_value('strategy[description]', isset($strategy['description']) ? $strategy['description'] : '')  ?>' />
	<br/>

	strategy picture
	<input type='text' name='strategy[picture]'
			value='<?= set_value('strategy[picture]', isset($strategy['picture']) ? $strategy['picture'] : '')  ?>' />
	<br/>

	strategy website
	<input type='text' name='strategy[website]'
			value='<?= set_value('strategy[website]', isset($strategy['website']) ? $strategy['website'] : '')  ?>' />
	<br/>

	redirect url
	<input type='text' name='advertisement[redirect_url]'
			value='<?= set_value('advertisement[redirect_url]', isset($advertisement['redirect_url']) ? $advertisement['redirect_url'] : '')  ?>' />
	<br/>

	<input type='submit' name='submit' value='submit' />

</form>