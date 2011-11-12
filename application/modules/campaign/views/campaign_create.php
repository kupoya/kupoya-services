<?php

var_dump($data);

echo validation_errors();

echo form_open('campaign/campaign_manage/create');

?>

<h2>Campaign name</h2>
<input type="text" name="campaign_name" value="<?php echo set_value('campaign_name'); ?>" size="50" />

<input type='submit' value='submit'/>
</form>