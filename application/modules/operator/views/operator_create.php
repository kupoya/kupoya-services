<?php

var_dump($data);

echo validation_errors();

echo form_open('customer/customer_manage/create');

?>

<h2>Customer name</h2>
<input type="text" name="customer_name" value="<?php echo set_value('customer_name'); ?>" size="50" />

<input type='submit' value='submit'/>
</form>