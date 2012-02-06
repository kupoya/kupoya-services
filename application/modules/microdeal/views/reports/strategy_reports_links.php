<?php

	if (isset($strategy['id']) && isset($campaign['id']))
	{
		$link_1 = base_url() . 'microdeal/reports/demographics/index/'.$strategy['id'].'/'.$campaign['id'];
	}

    // // we need to know which stratey type is this so we can fwd to the correct module
    // if (isset($strategy['strategy_type_name']))
    // {
    //     $strategy_type = $strategy['strategy_type_name'];
    //     echo Modules::run($strategy_type.'/microdeal_reports/_get_reports_links', $data);
    // }

?>

	<li><a href="<?php echo isset($link_1) ? $link_1 : '#'?>" rel="tooltip" title="Switch to next tab">Demographics</a></li>