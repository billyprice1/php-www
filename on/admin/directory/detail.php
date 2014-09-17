<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

if(!isset($_GET['id']) || !is_numeric($_GET['id']))
	template::redirect('/admin/directory');
	
$site = api::send('site/list', array('site'=>$_GET['id']));
$site = $site[0];

if($site['directory'] != 0) {
	$directory = api::send('site/list', array('directory'=>1, 'site'=>$_GET['id']));
	$directory = $directory[0];
}

$content = "
		<style>li#search-li {display:none;}</style>
		<div class=\"admin\">
			<div class=\"top\">
				<div class=\"left\" style=\"padding-top: 5px; width: 700px;\">
					<h1 class=\"dark\">{$lang['title']} ({$site['hostname']})</h1>
				</div>
				<div class=\"right\">
					<a class=\"button classic\" href=\"/admin/users/detail?id={$site['user']['id']}\" style=\"width: 180px; height: 22px; float: right;\">
						<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/user-white.png\" alt=\"\" />
						<span style=\"display: block; padding-top: 3px;\">{$lang['admin_user']}</span>
					</a>
				</div>
			</div>
			<div class=\"clear\"></div><br />
			<div class=\"container\">
				<div style=\"width: 700px; float: left;\">
					<h2 class=\"dark\">{$lang['infos']}</h2>
";

if(!$directory) 
	$content .= "
					<div style=\"margin-bottom: 20px; padding: 10px 10px 10px 45px; background: url('/on/images/icons/large/info.png') no-repeat scroll 10px 8px rgb(238, 238, 238);\"> {$lang['nodirectory']} </div>
	";
	
if($site['directory']== 4) 
	$content .= "
					<div style=\"margin-bottom: 20px; padding: 10px 10px 10px 45px; background: url('/on/images/icons/large/alert.png') no-repeat scroll 10px 8px rgb(238, 238, 238);\"> {$lang['suspended_text']} </div>
	";
	
$content .= "
					
					<form action=\"/admin/directory/detail_action\" method=\"post\">	
						<input type=\"hidden\" name=\"id\" value=\"{$site['id']}\" />
						<input type=\"hidden\" name=\"action\" value=\"changedirectory\" />
						<fieldset>
							<input type=\"text\" name=\"title\" value=\"{$site['title']}\" style=\"width: 98%;\" />
							<span class=\"help-block\">{$lang['site_title']}</span>
						</fieldset>
						<fieldset>
							<textarea name=\"description\" style=\"width: 98%; height: 130px; font-family: inherit; font-size: inherit;\">{$site['description']}</textarea>						
							<span class=\"help-block\">{$lang['site_description']}</span>
						</fieldset>
						<fieldset>
							<select name=\"category\" style=\"width: 100%;\">
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
							<span class=\"help-block\">{$lang['site_category']}</span>
						</fieldset>
						<fieldset>	
							<input autofocus type=\"submit\" value=\"{$lang['update']}\" />
						</fieldset>
					</form>
				</div>
				
				<div style=\"width: 350px; float: right;\">
					<h2 class=\"dark\">{$lang['sum']}</h2>
					
					<div style=\"background-color: #f2f2f2; padding: 10px; line-height: 30px;\">
						<div style=\"float: left; width: 100px; margin-right: 20px; margin-top: 10px;\">
							<img style=\"width: 100px; max-height: 75px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/sites/?url={$site['hostname']}\" />
						</div>
						<strong style=\"display: inline-block; width: 150px;\">{$lang['user']} :</strong> <a href=\"/admin/users/detail?id={$site['user']['id']}\">{$site['user']['name']}</a>
						<strong style=\"display: inline-block; width: 150px;\">{$lang['votes']} :</strong> {$directory['rating']['count']}<br />
						<strong style=\"display: inline-block; width: 150px;\">{$lang['average']} :</strong> ".round($directory['rating']['rating'], 2)." <br />
					</div>
					<br /><br />
					
					<h2 class=\"dark\">{$lang['display']}</h2>
					
					<form action=\"/admin/directory/detail_action\" method=\"post\">	
						<input type=\"hidden\" name=\"id\" value=\"{$site['id']}\" />
						<input type=\"hidden\" name=\"action\" value=\"displaydirectory\" />

						<fieldset>
							<select name=\"display\" style=\"width: 100%;\">
								<option ".(($site['directory']>0 && $site['directory']!=4)?"selected":"")." value=\"0\">{$lang['choice_yes']}</option>
								<option ".($site['directory']==0?"selected":"")." value=\"1\">{$lang['choice_no']}</option>
								<option style=\"color: red;\" ".($site['directory']==4?"selected":"")." value=\"2\">{$lang['suspended']}</option>
							</select>
							<span class=\"help-block\">{$lang['display_help']}</span>
						</fieldset>
						
						<fieldset>
							<select name=\"status\" style=\"width: 100%;\">
								<option ".($site['directory']==1?"selected":"")." value=\"1\">{$lang['simple']}</option>
								<option ".($site['directory']==2?"selected":"")." value=\"2\">{$lang['featured']}</option>
								<option ".($site['directory']==3?"selected":"")." value=\"3\">{$lang['selection']}</option>
							</select>
							<span class=\"help-block\">{$lang['status_help']}</span>
						</fieldset>
						
						<fieldset>	
							<input autofocus type=\"submit\" value=\"{$lang['update']}\" />
						</fieldset>
					</form>
					
				</div>
			<div class=\"clear\"></div>
		</div>
	</div>";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>