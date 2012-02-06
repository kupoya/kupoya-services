<?php

$route['microdeal'] = "microdeal_manage/index";
$route['microdeal/manage/(:any)?'] = "microdeal_manage/$1";
$route['microdeal/reports/demographics/(:any)?'] = "microdeal_reports_demographics/$1";
$route['microdeal/reports/overview/(:any)?'] = "microdeal_reports_overview/$1";