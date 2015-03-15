<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$site = api::send('self/site/list', array('id'=>$_GET['id']));
$site = $site[0];

$now = time();

// Last 24 hours
$dayago = mktime(date('H')+1, 0, 0, date('n'), date('j'), date('Y'))-(3600*24);
$logs = api::send('self/site/response', array('site'=>$_GET['id'], 'group' => 'HOUR', 'from' => $dayago, 'to' => $now, 'start' => 0, 'limit' => 1000));
$data_day = array();
$current = $dayago;
for( $i = 1; $i <= 24; $i++ )
{
	$next = $current+3600;
	$data_day[$current]['average'] = 0;
	$data_day[$current]['date'] = date($lang['dateformathour'], $current);
	foreach( $logs as $l )
	{
		if( $l['HOUR'] == date('H', $current) )
			$data_day[$current]['average'] = $l['average'];
	}
	$current = $next;
}

// Last month
$monthago = mktime(date('H'), 0, 0, date('n'), date('j')+1, date('Y'))-(3600*24*30);
$logs = api::send('self/site/response', array('site'=>$_GET['id'], 'group' => 'DAY', 'from' => $monthago, 'to' => $now, 'start' => 0, 'limit' => 1000));
$data_month = array();
$current = $monthago;
for( $i = 1; $i <= 30; $i++ )
{
	$next = $current+(3600*24);
	$data_month[$current]['average'] = 0;
	$data_month[$current]['date'] = date($lang['dateformat'], $current);
	foreach( $logs as $l )
	{
		if( $l['DAY'] == date('d', $current) )
			$data_month[$current]['average'] = $l['average'];
	}
	$current = $next;
}

// Last year
$yearago = mktime(date('H'), 0, 0, date('n')+1, date('j'), date('Y'))-(3600*24*365);
$logs = api::send('self/site/response', array('site'=>$_GET['id'], 'group' => 'MONTH', 'from' => $yearago, 'to' => $now, 'start' => 0, 'limit' => 1000));
$data_year = array();
$current = $yearago;
for( $i = 1; $i <= 12; $i++ )
{
	$next = $current+(3600*24*30.3);
	$data_year[$current]['average'] = 0;
	$data_year[$current]['date'] = date($lang['dateformatmonth'], $current);
	foreach( $logs as $l )
	{
		if( $l['MONTH'] == date('n', $current) )
			$data_year[$current]['average'] = $l['average'];
	}
	$current = $next;
}

$content .= "
	<div class=\"panel\">
		<div class=\"top\">
			<div class=\"left\" style=\"width: 500px;\">
				<img style=\"width: 100px; height: 100px; border: 1px solid #cecece; padding: 5px; border-radius: 3px; text-align: right; float: left; margin-right: 20px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/sites/?url={$site['hostname']}\" />
				<span style=\"font-size: 38px; display: block; margin-bottom: 15px; max-width: 500px; overflow: hidden; text-overflow: ellipsis;\" title=\"{$site['hostname']}\">{$site['hostname']}</span>
				<span style=\"font-size: 18px; color: #9a9a9a; display: block; margin-bottom: 10px;\">{$lang['disk']} {$site['size']} {$lang['mb']}</span>
			</div>
			<div class=\"right\" style=\"width: 600px; float: right; text-align: right;\">
				<a class=\"action pass big\" href=\"#\" onclick=\"$('#changepassword').dialog('open'); return false;\">
					{$lang['password']}
				</a>
				<a class=\"action download big\" href=\"#\" onclick=\"$('#download').dialog('open'); return false;\">
					{$lang['download']}
				</a>
				<a class=\"action delete big\" href=\"#\" onclick=\"$('#delete').dialog('open'); return false;\">
					{$lang['delete']}
				</a>
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
		<div class=\"container\">
			<div class=\"left\" style=\"width: 600px; margin-top: 5px;\">
				<h2 class=\"dark\">{$lang['access']}</h2>
				<div class=\"info\" style=\"border-bottom: 1px solid #e5e5e5;\">
					<span style=\"float: left; display: block; width: 200px; font-size: 15px; height: 30px; padding: 10px; \">
						<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/ftp.png\" alt=\"\" style=\"float: left; display: block;\" />
						<span style=\"float: left; display: block; padding: 4px 5px 5px 10px; color: #de5711;\">{$lang['ftp']}</span>
					</span>
					<span style=\"float: right; display: block; width: 390px; text-align: center; padding: 13px 0 0 0; font-size: 18px; background-color: #f9f9f9; height: 37px;\">ftp.olympe.in</span>
				</div>
				<div class=\"info\" style=\"border-bottom: 1px solid #e5e5e5;\">
					<span style=\"float: left; display: block; width: 200px; font-size: 15px; height: 30px; padding: 10px; \">
						<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/user.png\" alt=\"\" style=\"float: left; display: block;\" />
						<span style=\"float: left; display: block; padding: 4px 5px 5px 10px; color: #de5711;\">{$lang['login']}</span>
					</span>
					<span style=\"float: right; display: block; width: 390px; text-align: center; padding: 13px 0 0 0; font-size: 18px; background-color: #f9f9f9; height: 37px;\">{$site['name']}</span>
				</div>
				<div class=\"info\" style=\"border-bottom: 1px solid #e5e5e5;\">
					<span style=\"float: left; display: block; width: 200px; font-size: 15px; height: 30px; padding: 10px; \">
						<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/link.png\" alt=\"\" style=\"float: left; display: block;\" />
						<span style=\"float: left; display: block; padding: 4px 5px 5px 10px; color: #de5711;\">{$lang['url']}</span>
					</span>
					<span style=\"float: right; display: block; width: 390px; text-align: center; padding: 13px 0 0 0; font-size: 18px; background-color: #f9f9f9; height: 37px;\">
						<a href=\"http://{$site['name']}.olympe.in\">{$site['name']}.olympe.in</a>
					</span>
				</div>
				<br /><br />
				<h2 class=\"dark\">{$lang['install']}</h2>
				<div class=\"info\" style=\"border-bottom: 1px solid #e5e5e5;\">
					<span style=\"float: left; display: block; width: 200px; font-size: 15px; height: 30px; padding: 10px; \">
						<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/wordpress.jpg\" alt=\"\" style=\"float: left; display: block; margin-left: -5px;\" width=\"35\" />
						<span style=\"float: left; display: block; padding: 4px 5px 5px 10px; color: #747474;\">Wordpress 4.1</span>
					</span>
					<span style=\"float: right; display: block; width: 390px; text-align: center; padding: 13px 0 0 0; font-size: 16px; background-color: #f9f9f9; height: 37px; cursor: pointer;\" onclick=\"$('#install').dialog('open'); $('#type').val('wordpress'); return false; \">{$lang['start']}</span>
				</div>
				<div class=\"info\" style=\"border-bottom: 1px solid #e5e5e5;\">
					<span style=\"float: left; display: block; width: 200px; font-size: 15px; height: 30px; padding: 10px; \">
						<img src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/joomla.png\" alt=\"\" style=\"float: left; display: block; margin-top: 2px; margin-left: 3px;\" width=\"25\" />
						<span style=\"float: left; display: block; padding: 4px 5px 5px 10px; color: #747474;\">Joomla 3.4</span>
					</span>
					<span style=\"float: right; display: block; width: 390px; text-align: center; padding: 13px 0 0 0; font-size: 16px; background-color: #f9f9f9; height: 37px; cursor: pointer;\" onclick=\"$('#install').dialog('open'); $('#type').val('joomla'); return false; \">{$lang['start']}</span>
				</div>
				<br /><br />
				<h2 class=\"dark\">{$lang['response']}</h2>
				<div id=\"chart1\" style=\"margin-bottom: 20px;\"></div>
				<div id=\"chart2\" style=\"margin-bottom: 20px;\"></div>
				<p>{$lang['note']}</p>
			</div>
			<div class=\"right border\" style=\"width: 340px; padding-left: 60px; margin-left: 40px; margin-top: 5px;\">
				<h2 class=\"dark\">{$lang['directory']}</h2>
";

if($site['directory']!=4) 
	$content .= "
					<form action=\"/panel/sites/config_action\" method=\"post\">	
						<input type=\"hidden\" name=\"id\" value=\"{$site['id']}\" />
						<input type=\"hidden\" name=\"action\" value=\"changedirectory\" />
						<fieldset>
							<input type=\"text\" name=\"title\" value=\"{$site['title']}\" style=\"width: 300px;\" />
							<span class=\"help-block\">{$lang['title_help']}</span>
						</fieldset>
						<fieldset>
							<textarea name=\"description\" style=\"width: 300px; height: 200px;\">{$site['description']}</textarea>						
							<span class=\"help-block\">{$lang['description_help']}</span>
						</fieldset>
						<fieldset>
							<select name=\"category\" style=\"width: 320px;\">
								<option value=\"-1\">{$lang['choose_cat']}</option>
								<option ".($site['category']==1?"selected":"")." value=\"1\">{$lang['CAT_1']}</option>
								<option ".($site['category']==2?"selected":"")." value=\"2\">{$lang['CAT_2']}</option>
								<option ".($site['category']==3?"selected":"")." value=\"3\">{$lang['CAT_3']}</option>
								<option ".($site['category']==4?"selected":"")." value=\"4\">{$lang['CAT_4']}</option>
								<option ".($site['category']==5?"selected":"")." value=\"5\">{$lang['CAT_5']}</option>
								<option ".($site['category']==6?"selected":"")." value=\"6\">{$lang['CAT_6']}</option>
								<option ".($site['category']==7?"selected":"")." value=\"7\">{$lang['CAT_7']}</option>
								<option ".($site['category']==8?"selected":"")." value=\"8\">{$lang['CAT_8']}</option>
								<option ".($site['category']==9?"selected":"")." value=\"9\">{$lang['CAT_9']}</option>
								<option ".($site['category']==10?"selected":"")." value=\"10\">{$lang['CAT_10']}</option>
								<option ".($site['category']==11?"selected":"")." value=\"11\">{$lang['CAT_11']}</option>
								<option ".($site['category']==12?"selected":"")." value=\"12\">{$lang['CAT_12']}</option>
								<option ".($site['category']==13?"selected":"")." value=\"13\">{$lang['CAT_13']}</option>
								<option ".($site['category']==14?"selected":"")." value=\"14\">{$lang['CAT_14']}</option>
								<option ".($site['category']==15?"selected":"")." value=\"15\">{$lang['CAT_15']}</option>
								<option ".($site['category']==16?"selected":"")." value=\"16\">{$lang['CAT_16']}</option>
								<option ".($site['category']==17?"selected":"")." value=\"17\">{$lang['CAT_17']}</option>
								<option ".($site['category']==18?"selected":"")." value=\"18\">{$lang['CAT_18']}</option>
								<option ".($site['category']==19?"selected":"")." value=\"19\">{$lang['CAT_19']}</option>
								<option ".($site['category']==20?"selected":"")." value=\"20\">{$lang['CAT_20']}</option>
							</select>
							<span class=\"help-block\">{$lang['category_help']}</span>
						</fieldset>
						<fieldset>
							<input type=\"checkbox\" name=\"directory\" value=\"1\" ".($site['directory']>0?"checked":"")." > {$lang['directory_help']}
						</fieldset>					
						<fieldset>	
							<input autofocus type=\"submit\" value=\"{$lang['update']}\" />
						</fieldset>
					</form>
	";
else 
	$content .= "
					<div style=\"color: rgb(204, 0, 0); text-align: justify; border: 1px solid; padding: 15px;\">{$lang['no_directory']}</div>
	";

$content .= "
			</div>
			<div class=\"clear\"></div><br />
		</div>
	</div>
	<div id=\"delete\" class=\"floatingdialog\">
		<h3 class=\"center\">{$lang['delete']}</h3>
		<p style=\"text-align: center;\">{$lang['delete_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/sites/del_action\" method=\"get\" class=\"center\">
				<input id=\"id\" type=\"hidden\" value=\"{$site['id']}\" name=\"id\" />
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['delete_now']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"download\" class=\"floatingdialog\">
		<br />
		<h3 class=\"center\">{$lang['backup']}</h3>
		<p style=\"text-align: center;\">{$lang['backup_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/backups/add_action\" method=\"get\" class=\"center\">
				<input id=\"id\" type=\"hidden\" value=\"{$site['id']}\" name=\"site\" />
				<fieldset autofocus>	
					<input type=\"submit\" value=\"{$lang['backup_now']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	<div id=\"changepassword\" class=\"floatingdialog\"><br />
		<h3 class=\"center\">{$lang['changepassword']}</h3>
		<p style=\"text-align: center;\">{$lang['changepassword_text']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/sites/config_action\" method=\"post\" class=\"center\">
				<input type=\"hidden\" name=\"id\" value=\"{$site['id']}\" />
				<input type=\"hidden\" name=\"action\" value=\"changepass\" />
				<fieldset>
					<input type=\"password\" name=\"pass\" />
					<span class=\"help-block\">{$lang['pass_help']}</span>
				</fieldset>
				<fieldset>
					<input type=\"password\" name=\"confirm\" />
					<span class=\"help-block\">{$lang['confirm_help']}</span>
				</fieldset>
				<fieldset>	
					<input autofocus type=\"submit\" value=\"{$lang['update']}\" />
				</fieldset>
			</form>
		</div>
	</div>
	
	<div id=\"install\" class=\"floatingdialog\"><br />
		<h3 class=\"center\">{$lang['install']}</h3>
		<div id=\"form\">
		<p style=\"text-align: center;\">{$lang['prompt']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/sites/install\" method=\"post\" class=\"center\">
				<input type=\"hidden\" name=\"id\" value=\"{$site['id']}\" />
				<input type=\"hidden\" name=\"type\" id=\"type\" value=\"\" />
				<fieldset>
					<input type=\"password\" name=\"pass\" style=\"color: #68686B;\" />
					<span class=\"help-block\">{$lang['ftp_pass']}</span>
				</fieldset>
				<span style=\"cursor: pointer; color: #68686B; font-size: 12px;\" id=\"options\">{$lang['more']}</span><br />
				<div id= \"more\" style=\"display:none\"><br /><br />
				<fieldset>
					<input type=\"password\" name=\"sql\" style=\"color: #68686B;\" />
					<span class=\"help-block\">{$lang['sql_pass']}</span>
				</fieldset>
				<fieldset>
					<select name=\"path\">
						<option value=\"0\">{$lang['root']}</option>
						<option value=\"1\">{$lang['folder']}</option>
					</select>
					<span class=\"help-block\">{$lang['path']}</span>
				</fieldset>
				</div><br /><br />
				<fieldset>
					<input autofocus id=\"launch\" type=\"submit\" value=\"{$lang['install_btn']}\" onclick=\"$('#form').fadeOut('slow', function() { $('#note').fadeIn('slow'); }); \" />
				</fieldset>
			</form>
		</div>
		</div>
		
		<div id=\"note\" style=\"display:none; text-align: center; padding: 10px 0px 20px 0px;\"><br />
			<img src=\"/on/images/anim_loading_16x16.gif\"></img><br /><br />
			<span style=\"font-size: 12px; \">{$lang['wait']}</span><br /><br />
		</div>
	</div>
	
	<div id=\"uninstall\" class=\"floatingdialog\"><br />
		<h3 class=\"center\">{$lang['uninstall']}</h3>
		<div id=\"form2\">
		<p style=\"text-align: center;\">{$lang['prompt']}</p>
		<div class=\"form-small\">		
			<form action=\"/panel/sites/uninstall\" method=\"post\" class=\"center\">
				<input type=\"hidden\" name=\"id\" value=\"{$site['id']}\" />
				<fieldset>
					<input type=\"password\" name=\"pass\" style=\"color: #68686B;\" />
					<span class=\"help-block\">{$lang['ftp_pass']}</span>
				</fieldset><br />
				<fieldset>
					<input autofocus id=\"launch\" type=\"submit\" value=\"{$lang['uninstall_btn']}\" onclick=\"$('#form2').fadeOut('slow', function() { $('#note2').fadeIn('slow'); }); \" />
				</fieldset>
			</form>
		</div>
		</div>
		<div id=\"note2\" style=\"display:none; text-align: center; padding: 10px 0px 20px 0px;\"><br />
			<img src=\"/on/images/anim_loading_16x16.gif\"></img><br /><br />
			<span style=\"font-size: 12px; \">{$lang['wait2']}</span><br /><br />
		</div>
	</div>
	
	<script type=\"text/javascript\">
		init = 0;
		newFlexibleDialog('settings', 550);
		newFlexibleDialog('changepassword', 550);
		newFlexibleDialog('delete', 550);
		newFlexibleDialog('download', 550);
		newFlexibleDialog('install', 550);
		newFlexibleDialog('uninstall', 550);
	
		$('#options').on('click', function() { if (init == 0) { $('#more').fadeIn('slow');	$('#options').html(\"{$lang['more_toggle']}\");	init++;	} else	{ $('#more').fadeOut('slow'); $('#options').html(\"{$lang['more']}\"); init = 0; } });
		$(function()
		{
			var dataSourceDay = [";

foreach( $data_day as $key => $value )
{
	$content .= "
			{ hour: '".date($lang['dateformathour'], $key)."', responsetime: {$value['average']} },
	";
}

$content .= "
			];
			
			var dataSourceMonth = [";

foreach( $data_month as $key => $value )
{
	$content .= "
			{ day: '".date($lang['dateformat'], $key)."', responsetime: {$value['average']} },
	";
}

$content .= "
			];

			var dataSourceYear = [";

foreach( $data_year as $key => $value )
{
	$content .= "
			{ month: '".date($lang['dateformatmonth'], $key)."', responsetime: {$value['average']} },
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
					{ valueField: \"responsetime\", name: \"{$lang['responsetime']}\", type: 'bar', 'color': '#de5711' }
				],
				argumentAxis:{
					grid:{
						visible: true
					}
				},
				valueAxis: {
					label: {
						customizeText: function() {
							return this.valueText + 'ms'
						}
				}},
				tooltip:{
					enabled: true,
					font: { size: 15 }
				},
				title: {
					text: '{$lang['chart1_title']}',
					font: { size: 15 }
				},
				legend: {
					verticalAlignment: \"top\",
					horizontalAlignment: \"right\",
					visible: false
				},
				size: {
					width: 650,
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
					{ valueField: \"responsetime\", name: \"{$lang['responsetime']}\", type: 'line', 'color': '#de5711' }
				],
				argumentAxis:{
					grid:{
						visible: true
					}
				},
				valueAxis: {
					label: {
						customizeText: function() {
							return this.valueText + 'ms'
						}
				}},
				tooltip:{
					enabled: true,
					font: { size: 15 }
				},
				title: {
					text: '{$lang['chart2_title']}',
					font: { size: 15 }
				},
				legend: {
					verticalAlignment: \"top\",
					horizontalAlignment: \"right\",
					visible: false
				},
				size: {
					width: 650,
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
					{ valueField: \"responsetime\", name: \"{$lang['responsetime']}\", type: 'splineArea', 'color': '#75b5d6' }
				],
				argumentAxis:{
					grid:{
						visible: true
					},
					label: {
						overlappingBehavior: { mode: 'rotate', rotationAngle: 50 }
					}
				},
				valueAxis: {
					label: {
						customizeText: function() {
							return this.valueText + 'ms'
						}
				}},
				tooltip:{
					enabled: true,
					font: { size: 15 }
				},
				title: {
					text: '{$lang['chart3_title']}',
					font: { size: 15 }
				},
				legend: {
					verticalAlignment: \"top\",
					horizontalAlignment: \"right\",
					visible: false
				},
				size: {
					width: 650,
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
