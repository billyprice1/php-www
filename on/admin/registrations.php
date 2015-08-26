<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$i = 0;
if(isset($_GET['last']) && is_numeric($_GET['last']))
	$max = intval($_GET['last']);
else 
	$max = 15;

if(isset($_POST['action']) && $_POST['action']=='search' && $_POST['email']!='' || isset($_GET['new'])) {
	if(isset($_POST['email']))
		$email = security::encode($_POST['email']);
	else if(isset($_GET['new'])) 
		$email = security::encode($_GET['new']);
	
	$registrations = api::send('registration/list', array('mail'=>$email));
	
} else {

	$display = 'display:none';
	$registrations = api::send('registration/list');
}

$content = "
			<div class=\"panel\">
				<div class=\"top\">
					<div class=\"left\" style=\"padding-top: 5px; width: 550px;\">
						<h1 class=\"dark\">{$lang['title']}</h1>
					</div>
					<div class=\"right\" style=\"width: 450px;\">
						<a class=\"button classic\" href=\"#\" onclick=\"$('#searchrequest').slideToggle('fast');\" style=\"height: 22px; float: right; width: 130px; margin-right: 20px;\">
							<img style=\"float: left; height: 98%;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/search.png\" />
							<span style=\"display: block; padding-top: 3px;\">{$lang['search']}</span>
						</a>
						<a class=\"button classic\" href=\"#\" onclick=\"$('#create').slideToggle('fast');\" style=\"height: 22px; float: right; width: 130px; margin-right: 20px;\">
							<img style=\"float: left; height: 98%;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white-big.png\" />
							<span style=\"display: block; padding-top: 3px;\">{$lang['create']}</span>
						</a>
					</div>
				</div>
				<div class=\"clear\"></div><br />
				<div id=\"searchrequest\" class=\"container\" style=\"{$display};\">
					<form action=\"\" method=\"post\">
						<fieldset>
							<input type=\"email\" required name=\"email\" placeholder=\"{$lang['email_search']}\" value=\"{$email}\" style=\"width: 300px; display: inline-block;\" />
							<input type=\"hidden\" name=\"action\" value=\"search\" />
							<input type=\"submit\" value=\"Ok\" style=\"width: 50px; display: inline-block;\" />
						</fieldset>
					</form>
				</div>
				<div id=\"create\" class=\"container\" style=\"display:none;\">
					<form action=\"/admin/registrations/add_action\" method=\"post\">
						<fieldset>
							<input type=\"email\" required name=\"email\" placeholder=\"{$lang['email_create']}\" style=\"width: 300px; display: inline-block;\" />
							<input type=\"hidden\" name=\"action\" value=\"search\" />
							<input type=\"submit\" value=\"Ok\" style=\"width: 50px; display: inline-block;\" />
						</fieldset>
					</form>
				</div>
				<div class=\"container\">
";

$content .= "
					<table>
						<tr>
							<th style=\"text-align: center; width: 40px;\">#</th>
							<th>{$lang['email']}</th>
							<th style=\"width:120px;\">{$lang['date']}</th>
							<th style=\"width:120px;\">{$lang['end']}</th>
							<th style=\"width: 150px; text-align: center;\">{$lang['actions']}</th>
						</tr>
";

if( count($registrations) > 0 )
{
	foreach($registrations as $r)
	{
		if($i < $max) {
			$end = $r['date'] + 864000;
			$i++;
			
			$content .= "
						<tr>
							<td style=\"text-align: center; width: 40px;\">#{$i}</td>
							<td>
								<div class=\"div-switch\" data-switch=\"{$i}\">{$r['email']}</div>
								<div class=\"div-switch div-link\" data-switch=\"{$i}\" style=\"display:none;\">
									<input type=\"text\" style=\"width: 98%; font-size: 0.9em; height: 20px;\" readonly value=\"https://www.olympe.in/confirm?email={$r['email']}&code={$r['code']}\">
								</div>
							</td>
							<td>".date($lang['dateformat'], $r['date'])."</a></td>
							<td>".date($lang['dateformat'], $end)."</a></td>
							<td style=\"width: 100px; text-align: center;\">
								<a href=\"#\" class=\"switch-button\" data-switch-id=\"{$i}\" title=\"{$lang['link']}\">
									<img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/link.png\" alt=\"\" />
								</a>
								<a href=\"#\" class=\"delete-button\" data-code=\"{$r['code']}\" title=\"{$lang['delete']}\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/close.png\" alt=\"\" /></a>
							</td>
						</tr>
			";
		}
	}
}
else
{
	$content .= "
						<tr>
							<td colspan=\"4\" style=\"text-align: center;\">{$lang['no_result']}</td>
						</tr>
	";
}

$content .= "
					</table>
					<br /><br />
";

$content .= "
				</div>
			</div>
			<div id=\"delete\" class=\"floatingdialog\">
				<h3 class=\"center\">{$lang['delete']}</h3>
				<p style=\"text-align: center;\">{$lang['delete_text']}</p>
				<div class=\"form-small\">		
					<form action=\"/admin/registrations/del_action\" method=\"post\" class=\"center\">
						<input id=\"code\" type=\"hidden\" value=\"0\" name=\"code\" />
						<fieldset autofocus>	
							<input type=\"submit\" value=\"{$lang['delete_now']}\" />
						</fieldset>
					</form>
				</div>
			</div>
			<script>
				newFlexibleDialog('delete', 550);
				
				$(function() {
					$('.switch-button').click(function() {
						var switchId = $(this).attr('data-switch-id');
						$('.div-switch[data-switch=\"' + switchId +'\"]').toggle('fast');
						$('.div-link[data-switch=\"' + switchId +'\"] input').focus().select();
						return false;
					});
					
					$('.delete-button').click(function() {
						$('#delete #code').val( $(this).attr('data-code') );
						$('#delete').dialog('open');
						return false;
					});
				});
			</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
