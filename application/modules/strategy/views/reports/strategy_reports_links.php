<?php

	if (isset($strategy['id']) && isset($campaign['id']))
	{
		$link_1 = base_url() . 'strategy/reports/demographics/index/'.$strategy['id'].'/'.$campaign['id'];
		$link_2 = base_url() . 'strategy/reports/mobile/index/'.$strategy['id'].'/'.$campaign['id'];
	}
?>

	<li><a href="<?php echo isset($link_1) ? $link_1 : '#'?>" rel="tooltip" title="Switch to next tab">Demographics</a></li>

	<li><a href="<?php echo isset($link_2) ? $link_2 : '#'?>" rel="tooltip" title="Switch to next tab">Mobile</a></li>