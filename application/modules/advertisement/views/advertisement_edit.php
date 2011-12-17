<?php

echo "<br/><br/>";
if (isset($message)) echo $message;
echo "<br/><br/>";

echo validation_errors();
echo "<br/><br/>";
echo "<br/><br/>";

var_dump($strategy);
echo "<br/><br/>";
var_dump($plan);

echo "<br/><br/>";
echo "<br/><br/>";

var_dump($advertisement);
echo "<br/><br/>";
echo "<br/><br/>";
var_dump($advertisement_blocks);


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

	advertisement text
	<textarea name='advertisement_blocks[block_1]'><?= set_value('advertisement_blocks[block_1]', isset($advertisement_blocks['block_1']) ? $advertisement_blocks['block_1'] : '')  ?></textarea>
	<br/>

	<h1>plan info</h1>
	Your plan <?php echo $plan['name']; ?>
	<br/>

	<?php
	/*
	choose plan
	<?= form_dropdown('plan[id]', $plans); ?>
	<br/>
	*/?>

	promotion
	<input type='text' name='order[promotion_id]' value='<?= set_value('order[promotion_id]', '') ?>' />
	<br/>

	<input type='submit' name='submit' value='submit' />

</form>

	<hr/>
	<h1>Picture</h1>
	<br/>

<?php echo form_open_multipart('advertisement/edit_strategy_picture');?>

	strategy id
	<input type='text' name='strategy_id'
			value='<?= set_value('strategy_id', isset($strategy['id']) ? $strategy['id'] : '')  ?>' />
	<br/>

	campaign id
	<input type='text' name='campaign_id'
			value='<?= set_value('campaign_id', isset($campaign['id']) ? $campaign['id'] : '')  ?>' />
	<br/>

	<input type="file" name="strategy_picture" size="20" />

	<input type='submit' name='submit' value='submit' />

</form>