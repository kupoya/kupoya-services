<?php

var_dump($data);

echo validation_errors();

echo form_open('strategy/strategy_manage/create');

?>

<h2>Strategy name</h2>
<input type="text" name="strategy_name" value="<?php echo set_value('strategy_name'); ?>" size="50" />

<input type='submit' value='submit'/>
</form>