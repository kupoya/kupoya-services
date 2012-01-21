<?php

$route['strategy'] = "strategy_manage/index";
$route['strategy/manage/(:any)?'] = "strategy_manage/$1";
$route['strategy/reports/demographics/(:any)?'] = "reports/strategy_reports_demographics/$1";
$route['strategy/reports/mobile/(:any)?'] = "reports/strategy_reports_mobile/$1";
$route['strategy/reports/overview/(:any)?'] = "strategy_overview/$1";
$route['strategy/widgets/(:any)?'] = "strategy_widgets/$1";