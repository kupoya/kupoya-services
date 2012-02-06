<?php

	if (isset($strategy['id']) && isset($campaign['id']))
	{
		$link_1 = base_url() . 'strategy/reports/demographics/index/'.$strategy['id'].'/'.$campaign['id'];
		$link_2 = base_url() . 'strategy/reports/mobile/index/'.$strategy['id'].'/'.$campaign['id'];
	}

	$data['strategy'] = isset($strategy) ? $strategy : '';
	$data['campaign'] = isset($campaign) ? $campaign : '';
	$data['plan'] = isset($plan) ? $plan : '';

    // we need to know which stratey type is this so we can fwd to the correct module
    if (isset($strategy['strategy_type_name']))
    {
        $strategy_type = $strategy['strategy_type_name'];
        echo Modules::run($strategy_type.'/microsite_reports_overview/_get_reports_links', $data);
    }

?>

	<li><a href="<?php echo isset($link_2) ? $link_2 : '#'?>" rel="tooltip" title="Switch to next tab">Mobile</a></li>