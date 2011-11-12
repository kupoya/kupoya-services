<?php

var_dump($data);

echo validation_errors();

echo form_open('contact/contact_manage/create');

?>

<h2>Contact name</h2>
<input type="text" name="contact_name" value="<?php echo set_value('contact_name'); ?>" size="50" />

<input type='submit' value='submit'/>
</form>