<?php

echo "<br/><br/>";
if (isset($message)) echo $message;
echo "<br/><br/>";

echo validation_errors();
echo "<br/><br/>";
echo "<br/><br/>";

var_dump($brand);
echo "<br/><br/>";
var_dump($contact);

echo "<br/><br/>";
echo "<br/><br/>";

//var_dump($error);


echo "<br/><br/>";
?>
	<form name='operator' action='<?php echo base_url().'brand/edit_brand'?>' method='post'>
	
	brand id
	<input type='text' name='brand[id]'
			value='<?= set_value('brand[id]', isset($brand['id']) ? $brand['id'] : '')  ?>' />
	<br/>

	brand name
	<input type='text' name='brand[name]'
			value='<?= set_value('brand[name]', isset($brand['name']) ? $brand['name'] : '')  ?>' />
	<br/>

	brand description
	<input type='text' name='brand[description]'
			value='<?= set_value('brand[description]', isset($brand['description']) ? $brand['description'] : '')  ?>' />
	<br/>

	brand picture
	<input type='text' name='brand[picture]'
			value='<?= set_value('brand[picture]', isset($brand['picture']) ? $brand['picture'] : '')  ?>' />
	<br/>

</form>

<br/>

<?php echo form_open_multipart('brand/edit_brand_picture');?>

	brand id
	<input type='text' name='brand_id'
			value='<?= set_value('brand_id', isset($brand['id']) ? $brand['id'] : '')  ?>' />
	<br/>

	<input type="file" name="brand_picture" size="20" />

	<input type='submit' name='submit' value='submit' />

</form>