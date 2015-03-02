<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$fh = "http://api.uptimerobot.com/getMonitors?apiKey={$GLOBALS['CONFIG']['UPTIME_TOKEN']}&format=json&customUptimeRatio=7-30-365&logs=1";

if ( @fopen($fh, 'r')) {

$fh = fopen($fh, 'r');

$response = stream_get_contents($fh);
fclose($fh);
$response = json_decode(str_replace(array('jsonUptimeRobotApi(', ')'), array('', ''), $response), true);

foreach( $response['monitors']['monitor'] as $m )
{
	if( $m['id'] == '776178358' )
	{
		$expl = explode('-', $m['customuptimeratio']);
		$up7 = $expl[0];
		$up30 = $expl[1];
		$up365 = $expl[2];
		$status = $m['status'];
		$logs = $m['log'];
	}
}

}
else {
	$status = "2";
	$up30 = "";
	$up365 = "";
}

require_once 'on/status/vendor/autoload.php';


// projets.olympe.in status
$url = 'https://projets.olympe.in';
libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTMLFile($url);
libxml_clear_errors();
$title = $doc->getElementsByTagName('title')->item(0);
$chaine = $title->nodeValue;
$dispo = "0";


if ($chaine == "Espace de travail Olympe") {
	$client = new Redmine\Client('https://projets.olympe.in', $GLOBALS['CONFIG']['REDMINE_TOKEN']);
	$issues = $client->api('issue')->all(array('project_id' => 'maintenances'));
	$issues = $issues['issues'];
} 

$content = "
		<div class=\"head\" style=\"background-color: ".($status!=2?"#ca0101":"#7bbb51")."; background-image: url('/{$GLOBALS['CONFIG']['SITE']}/images/dotgrid-black.png'); margin-bottom: 0;\">
			<br />
			<h1>".($status!=2?"{$lang['offline']}":"{$lang['online']}")."</h1>
			<h2 style=\"margin: 15px 0 15px 0; color: #ffffff;\">".date('M d Y H:i')."</h2>
			<div style=\"width: 800px; margin: 0 auto; color: #ffffff; text-align: center; font-size: 14px; line-height: 20px;\">
				{$lang['monitor']}
			</div>
			<div class=\"clear\"></div>
			<br /><br /><br />
			<div style=\"margin: 0 auto; width: 1100px;\">
				<div style=\"float: left;\">
					<div class=\"filluptimeout\">
						<div class=\"filluptime\" style=\"width: ".($up30==""?"{$lang['up30ind']}":"{$up30}")."%;\"></div>
					</div>
					<span style=\"color: #ffffff; text-align: center; display: block; margin: 0 auto; margin-top: 5px; font-size: 14px;\">{$lang['30days']} <span style=\"font-weight: bold;\">".($up30==""?"{$lang['up30ind']}":"{$up30}")."%</span></span>
				</div>
				<div style=\"float: right;\">
					<div class=\"filluptimeout\">
						<div class=\"filluptime\" style=\"width: ".($up365==""?"{$lang['up365ind']}":"{$up365}")."%;\"></div>
					</div>
					<span style=\"color: #ffffff; text-align: center; display: block; margin: 0 auto; margin-top: 5px; font-size: 14px;\">{$lang['365days']} <span style=\"font-weight: bold;\">".($up365==""?"{$lang['up365ind']}":"{$up365}")."%</span></span>
				</div>
				<div class=\"clear\"></div>
			</div>
		</div>
		<div class=\"clear\"></div>		
		<div class=\"content\">
			<h3 style=\"color: #a4a4a4;\">{$lang['issues']}</h3>
			<table>
				<tr>
					<th style=\"color: #a4a4a4; text-align: center; width: 40px;\">#</th>
					<th style=\"color: #a4a4a4;\">{$lang['type']}</th>
					<th style=\"color: #a4a4a4;\">{$lang['title']}</th>
					<th style=\"color: #a4a4a4;\">{$lang['priority']}</th>
					<th style=\"color: #a4a4a4;\">{$lang['date']}</th>
					<th style=\"color: #a4a4a4;\">{$lang['status']}</th>
					<th style=\"color: #a4a4a4;\">{$lang['updated']}</th>
				</tr>
";

if( count($issues) > 0 )
{
	foreach( $issues as $i )
	{
		$content .= "
				<tr>
					<td style=\"text-align: center; width: 40px;\"><a href=\"https://projets.olympe.in/issues/{$i['id']}\"><img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/issue.png\" /></a></td>
					<td>".$lang['tracker_' . $i['tracker']['id']]."</td>
					<td><a href=\"https://projets.olympe.in/issues/{$i['id']}\">{$i['subject']}</a></td>
					<td>".$lang['priority_' . $i['priority']['id']]."</td>
					<td>".date($lang['dateformatsimple'], strtotime($i['start_date']))."</td>
					<td>".$lang['status2_' . $i['status']['id']]."</td>
					<td>".date($lang['dateformat'], strtotime($i['updated_on']))."</td>
				</tr>
		";
	}
}
else
{
	$content .= "
				<tr>
					<td colspan=\"7\" style=\"text-align: center; width: 40px;\">
			";
			
	if ($chaine === false) {
			$content .= $lang['intervention'];
	}else{
			$content .= $lang['unavailable'];
	}
	
	$content .= "
					</td>
				</tr>
	";

}

	$content .= "
			</table>
			<br /><br />
			<div style=\"float: left; width: 500px;\">
				<h3 style=\"color: #a4a4a4;\">{$lang['last7days']}</h3>
";

for( $i = 0; $i < 7; $i++ )
{
	$current = strtotime(date('Y-m-d',strtotime('-' . $i . ' days')).' 00:00:00');
	$currentend = strtotime(date('Y-m-d',strtotime('-' . ($i-1) . ' days')).' 00:00:00');
	
	$dated = date('d', strtotime(date('Y-m-d',strtotime('-' . $i . ' days')).' 00:00:00'));
	$datem = date('M', strtotime(date('Y-m-d',strtotime('-' . $i . ' days')).' 00:00:00'));
	$datey = date('Y', strtotime(date('Y-m-d',strtotime('-' . $i . ' days')).' 00:00:00'));
	
	$problems = array();
	if( count($logs) > 0 )
	{
		foreach( $logs as $l )
		{
			$time = strtotime($l['datetime']);
			if( $time > $current && $time < $currentend )
				$problems[] = array('type'=>$l['type'], 'timestamp'=>$time);
		}
	}

	$color = '';
	if( count($problems) > 0 )
	{
		foreach( $problems as $p )
		{
			if( $p['type'] == 2 )
				$color = 'yellow';
			else if( $p['type'] == 98 )
				$color = 'blue';
		}
	}
	
	$content .= "
				<div style=\"clear: left; padding: 10px 15px 0px 15px; margin: 0; background-color: #ffffff; \">
					<span class=\"smalldate {$color}\">{$dated}<br />{$datem}<br />{$datey}</span>
					<span style=\"display: block; float: left; padding: 0 0px 0px 20px; width: 300px;\">
	";

	if( count($problems) > 0 )
	{
		foreach( $problems as $p )
		{
			$content .= "
						<span style=\"font-size: 13px; display: block;\">".date('H:i', $p['timestamp'])." CET</span>
						<span style=\"font-size: 11px; display: block; margin: 5px 0 10px 0;\">".$lang['status_' . $p['type']]."</span>
			";
		}
	}	
	else
		$content .= "{$lang['24up']}<span style=\"font-size: 12px; margin-top: 8px; display: block;\">{$lang['allrunning']}</span>";

	$content .= "			
					</span>
					<div class=\"clear\"><br /></div>
				</div>
				<div class=\"clear\"><br /></div>
						
	";
}

$content .= "
				<div style=\"clear: left; padding: 10px 15px 0px 15px; margin: 0; background-color: #ffffff; \">
					<span class=\"smalldate blue\">22<br />Dec<br />2013</span>
					<span style=\"display: block; float: left; padding: 0 0px 0px 20px; width: 300px;\">

						<span style=\"font-size: 13px; display: block;\">15:00 CET</span>
						<span style=\"font-size: 11px; display: block; margin: 5px 0 10px 0;\">{$lang['status_2']}</span>
	
						<span style=\"font-size: 13px; display: block;\">15:01 CET</span>
						<span style=\"font-size: 11px; display: block; margin: 5px 0 10px 0;\">{$lang['status_98']}</span>
					
					</span>
					<div class=\"clear\"></div>
				</div>
				<div class=\"clear\"></div>
			</div>
			<div style=\"float: right; width: 500px;\">
				<h3 style=\"color: #a4a4a4;\">{$lang['paasstats']}</h3>
				<div style=\"text-align: center;\">
					<img src=\"https://munin.anotherservice.com/ON-Nodes/olympe.in/traffic-day.png\" />
					<br /><br />
					<img src=\"https://munin.anotherservice.com/ON-Nodes/olympe.in/memory-day.png\" />
					<br /><br />
					<img src=\"https://munin.anotherservice.com/ON-Nodes/olympe.in/cpu-day.png\" />							
				</div>
			</div>		
			<div class=\"clear\"></div>
		</div>
		<div class=\"clear\"></div>
		<br />
		<script>
		</script>		
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
