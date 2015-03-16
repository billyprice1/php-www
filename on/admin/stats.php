<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

// Last 24 hours
$dayago = mktime(date('H')+1, 0, 0, date('n'), date('j'), date('Y'))-(3600*24);
$users = api::send('users/list', array('group' => 'HOUR', 'from' => $dayago, 'to' => $now, 'start' => 0, 'limit' => 1000), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
$data_day = array();
$current = $dayago;
for( $i = 1; $i <= 24; $i++ )
{
	$next = $current+3600;
	$data_day[$current]['count'] = 0;
	$data_day[$current]['date'] = date($lang['dateformathour'], $current);
	foreach( $users as $u )
	{
		if( $u['HOUR'] == date('H', $current) )
			$data_day[$current]['count'] = $u['count'];
	}
	$current = $next;
}

// Last month
$monthago = mktime(date('H'), 0, 0, date('n'), date('j')+1, date('Y'))-(3600*24*30);
$users = api::send('user/list', array('group' => 'DAY', 'from' => $monthago, 'to' => $now, 'start' => 0, 'limit' => 1000), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
$data_month = array();
$current = $monthago;
for( $i = 1; $i <= 30; $i++ )
{
	$next = $current+(3600*24);
	$data_month[$current]['count'] = 0;
	$data_month[$current]['date'] = date($lang['dateformat'], $current);
	foreach( $users as $u )
	{
		if( $u['DAY'] == date('d', $current) )
			$data_month[$current]['count'] = $u['count'];
	}
	$current = $next;
}

// Last year
$yearago = mktime(date('H'), 0, 0, date('n')+1, date('j'), date('Y'))-(3600*24*365);
$users = api::send('user/list', array('group' => 'MONTH', 'from' => $yearago, 'to' => $now, 'start' => 0, 'limit' => 1000), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
$data_year = array();
$current = $yearago;
for( $i = 1; $i <= 12; $i++ )
{
	$next = $current+(3600*24*30.3);
	$data_year[$current]['count'] = 0;
	$data_year[$current]['date'] = date($lang['dateformatmonth'], $current);
	foreach( $users as $u )
	{
		if( $u['MONTH'] == date('n', $current) )
			$data_year[$current]['count'] = $u['count'];
	}
	$current = $next;
}

$users = api::send('user/list', array('count'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
$sites = api::send('site/list', array('count'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
$dbs = api::send('database/list', array('count'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
$domains = api::send('domain/list', array('count'=>1), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);

switch( translator::getLanguage() )
{
	case 'FR':
		$users['count'] = number_format($users['count'], 0, ',', ' ');
		$sites['count'] = number_format($sites['count'], 0, ',', ' ');
		$dbs['count'] = number_format($dbs['count'], 0, ',', ' ');
		$domains['count'] = number_format($domains['count'], 0, ',', ' ');
	break;
	default:
		$users['count'] = number_format($users['count']);
		$sites['count'] = number_format($sites['count']);
		$dbs['count'] = number_format($dbs['count']);
		$domains['count'] = number_format($domains['count']);
}

$content = "
	<div class=\"panel\">
		<div class=\"content\" style=\"margin-top: 0;\">
			<h1 class=\"dark\" style=\"text-align: center;\">{$lang['title']}</h1>
			<br />
			<div style=\"width: 260px; float: left; text-align: center;\">
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/user-big.png\" style=\"width: 80px;\" />
				<br />
				<span style=\"font-size: 40px; display: block; margin: 10px 0 10px 0;\">{$users['count']}</span>
				<span style=\"font-size: 14px; display: block; color: #a2a2a2;\">{$lang['user']}</span>
			</div>
			<div style=\"width: 260px; float: left; text-align: center; margin-left: 20px;\">
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/site-big.png\" style=\"width: 80px;\"/>
				<br />
				<span style=\"font-size: 40px; display: block; margin: 10px 0 10px 0;\">{$sites['count']}</span>
				<span style=\"font-size: 14px; display: block; color: #a2a2a2;\">{$lang['sites']}</span>
			</div>
			<div style=\"width: 260px; float: left; text-align: center; margin-left: 20px;\">
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/database-big.png\" style=\"width: 80px;\" />
				<br />
				<span style=\"font-size: 40px; display: block; margin: 10px 0 10px 0;\">{$dbs['count']}</span>
				<span style=\"font-size: 14px; display: block; color: #a2a2a2;\">{$lang['databases']}</span>
			</div>
			<div style=\"width: 260px; float: left; text-align: center; margin-left: 20px;\">
				<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/domain-big.png\" style=\"width: 80px;\" />
				<br />
				<span style=\"font-size: 40px; display: block; margin: 10px 0 10px 0;\">{$domains['count']}</span>
				<span style=\"font-size: 14px; display: block; color: #a2a2a2;\">{$lang['domains']}</span>
			</div>
			<div class=\"clear\"></div><br /><br />
			<div id=\"chart1\" style=\"margin-bottom: 20px;\"></div>
			<div id=\"chart2\" style=\"margin-bottom: 20px;\"></div>
			<div id=\"chart3\" style=\"margin-bottom: 20px;\"></div>
		</div>
	</div>
	<script>
		$(function()
		{
			var dataSourceDay = [";

foreach( $data_day as $key => $value )
{
	$content .= "
			{ hour: '".date($lang['dateformathour'], $key)."', users: {$value['count']} },
	";
}

$content .= "
			];
			
			var dataSourceMonth = [";

foreach( $data_month as $key => $value )
{
	$content .= "
			{ day: '".date($lang['dateformat'], $key)."', users: {$value['count']} },
	";
}

$content .= "
			];

			var dataSourceYear = [";

foreach( $data_year as $key => $value )
{
	$content .= "
			{ month: '".date($lang['dateformatmonth'], $key)."', users: {$value['count']} },
	";
}

$content .= "
			];
			
			$(\"#chart1\").dxChart({
				dataSource: dataSourceDay,
				commonSeriesSettings: {
					argumentField: \"hour\"
				},
				series: [
					{ valueField: \"users\", name: \"{$lang['users']}\", type: 'bar', 'color': '#de5711' }
				],
				argumentAxis:{
					grid:{
						visible: true
					}
				},
				tooltip:{
					enabled: true,
					font: { size: 15 }
				},
				title: {
					text: '{$lang['chart1_title']}',
					font: { size: 15 }
				},
				legend: {
					verticalAlignment: \"bottom\",
					visible: \"center\",
					visible: false
				},
				size: {
					width: 1050,
					height: 200
				},
				commonPaneSettings: {
					border:{
						visible: true,
						right: false
					}       
				}
			});

			$(\"#chart2\").dxChart({
				dataSource: dataSourceMonth,
				commonSeriesSettings: {
					argumentField: \"day\"
				},
				series: [
					{ valueField: \"users\", name: \"{$lang['users']}\", type: 'line', 'color': '#de5711' }
				],
				argumentAxis:{
					grid:{
						visible: true
					}
				},
				tooltip:{
					enabled: true,
					font: { size: 15 }
				},
				title: {
					text: '{$lang['chart2_title']}',
					font: { size: 15 }
				},
				legend: {
					verticalAlignment: \"bottom\",
					horizontalAlignment: \"center\",
					visible: false
				},
				size: {
					width: 1050,
					height: 200
				},
				commonPaneSettings: {
					border:{
						visible: true,
						right: false
					}       
				}
			});
			
			$(\"#chart3\").dxChart({
				dataSource: dataSourceYear,
				commonSeriesSettings: {
					argumentField: \"month\"
				},
				series: [
					{ valueField: \"users\", name: \"{$lang['users']}\", type: 'splineArea', 'color': '#e28d61' }
				],
				argumentAxis:{
					grid:{
						visible: true
					},
					label: {
						overlappingBehavior: { mode: 'rotate', rotationAngle: 50 }
					}
				},
				tooltip:{
					enabled: true,
					font: { size: 15 }
				},
				title: {
					text: '{$lang['chart3_title']}',
					font: { size: 15 }
				},
				legend: {
					verticalAlignment: \"bottom\",
					horizontalAlignment: \"center\",
					visible: false					
				},
				size: {
					width: 1050,
					height: 200
				},
				commonPaneSettings: {
					border:{
						visible: true,
						right: false
					}       
				}
			});
		});
	</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>