<?php

var_dump($data);

echo validation_errors();

echo form_open('brand/brand_manage/create');

?>

<h2>Brand name</h2>
<input type="text" name="brand_name" value="<?php echo set_value('brand_name'); ?>" size="50" />

<input type='submit' value='submit'/>
</form>