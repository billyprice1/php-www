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

if(isset($_POST['action']) && $_POST['action']=='search' && $_POST['email']!='') {
	$email = security::encode($_POST['email']);
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
					</div>
				</div>
				<div class=\"clear\"></div><br />
				<div id=\"searchrequest\" class=\"container\" style=\"{$display};\">
					<form action=\"\" method=\"post\">
						<fieldset>
							<input type=\"text\" name=\"email\" placeholder=\"{$lang['email']}\" value=\"{$email}\" style=\"width: 300px; display: inline-block;\" />
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
							<th>{$lang['date']}</th>
							<th style=\"width: 100px; text-align: center;\">{$lang['actions']}</th>
						</tr>
";

if( count($registrations) > 0 )
{
	foreach($registrations as $r)
	{
		if($i < $max) {
			$i++;
			
			$content .= "
						<tr>
							<td style=\"text-align: center; width: 40px;\">#{$i}</td>
							<td>{$r['email']}</td>
							<td>".date($lang['dateformat'], $r['date'])."</a></td>
							<td style=\"width: 100px; text-align: center;\">
								<a href=\"#\" onclick=\"$('#id').val('0'); $('#delete').dialog('open'); return false;\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/large/close.png\" alt=\"\" /></a>
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
					<form action=\"/admin/messages/del_action\" method=\"get\" class=\"center\">
						<input id=\"id\" type=\"hidden\" value=\"0\" name=\"id\" />
						<fieldset autofocus>	
							<input type=\"submit\" value=\"{$lang['delete_now']}\" />
						</fieldset>
					</form>
				</div>
			</div>
			<script>
				newFlexibleDialog('delete', 550);
			</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
