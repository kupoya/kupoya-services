<?php

var_dump($data);

echo validation_errors();

echo form_open('order/order_manage/create');

?>

<h2>order name</h2>
<input type="text" name="order_name" value="<?php echo set_value('order_name'); ?>" size="50" />

<input type='submit' value='submit'/>
</form>