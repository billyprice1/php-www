<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$domain = api::send('self/domain/list', array('id'=>$_GET['id']));
$domain = $domain[0];

if( is_array($domain['aRecord']) )
        $domain['aRecord'] = $domain['aRecord'][0];

$subdomains = api::send('self/subdomain/list', array('domain'=>$domain['hostname']));
		
$content = "
			<div class=\"panel\">
				<div class=\"top\">
					<div class=\"left\" style=\"width: 500px; padding-top: 5px;\"\">
						<h1 class=\"dark\">{$lang['title']} {$domain['hostname']}</h1>
					</div>
					<div class=\"right\">
						<a class=\"button classic\" href=\"#\" onclick=\"$('#new').dialog('open');\" style=\"width: 200px; height: 22px; float: right;\">
							<img style=\"float: left;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/plus-white.png\" />
							<span style=\"display: block; padding-top: 3px;\">{$lang['add']}</span>
						</a>
					</div>
				</div>
				<div class=\"clear\"></div><br /><br />
				<div class=\"container\">
					<div style=\"float: left; width: 300px;\">
						<h2 class=\"dark\">{$lang['dns']}</h2>
						<form action=\"/panel/domains/config_action\" method=\"post\">
							<input type=\"hidden\" name=\"id\" value=\"{$domain['id']}\" />
							<input type=\"hidden\" name=\"domain\" value=\"{$domain['hostname']}\" />
							<fieldset>
								<input type=\"text\" value=\"".str_replace('10 ', '', $domain['mxRecord'][0])."\" name=\"mx1\" />
								<span class=\"help-block\">{$lang['mx1']}</span>
							</fieldset>
							<fieldset>
								<input type=\"text\" value=\"".str_replace('20 ', '', $domain['mxRecord'][1])."\" name=\"mx2\" />
								<span class=\"help-block\">{$lang['mx2']}</span>
							</fieldset>
							<fieldset>
								<input type=\"text\" value=\"".($domain['mxRecord'][2]?"":"mx3.olympe.in")."".str_replace('30 ', '', $domain['mxRecord'][2])."\" name=\"mx3\" />
								<span class=\"help-block\">{$lang['mx3']}</span>
							</fieldset>
							<fieldset>
								<input type=\"text\" value=\"".($domain['mxRecord'][3]?"":"mx4.olympe.in")."".str_replace('40 ', '', $domain['mxRecord'][3])."\" name=\"mx4\" />
								<span class=\"help-block\">{$lang['mx4']}</span>
							</fieldset>							
							<fieldset>
								<input type=\"text\" value=\"{$domain['aRecord']}\" name=\"domain_arecord\" />
								<span class=\"help-block\">{$domain['hostname']}</span>
							</fieldset>
							<fieldset>				
								<input type=\"submit\" value=\"{$lang['update']}\" />
							</fieldset>
						</form>					
					</div>
					<div style=\"float: right; width: 800px;\">
						<h2 class=\"dark\">{$lang['subdomains']}</h2>
						<table>
							<tr>
								<th>{$lang['address']}</th>
								<th>{$lang['record']}</th>
								<th>{$lang['actions']}</th>
							</tr>
";

if( count($subdomains) > 0 )
{
	foreach( $subdomains as $s )
	{
		$content .= "
							<tr class=\"gradeA\">
								<td>{$s['hostname']}</td>
								<td>{$s['aRecord']}{$s['cNAMERecord']}</td>
								<td style=\"width: 70px;\">
									<a href=\"#\" onclick=\"$('#record').val('{$s['aRecord']}{$s['cNAMERecord']}'); $('#subdomainid').val('{$s['id']}'); $('#config').dialog('open'); return false;\" title=\"\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/settings.png\" alt=\"\" /></a>
									<a href=\"#\" onclick=\"$('#subdomain').val('{$s['id']}'); $('#delete').dialog('open'); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a>
								</td>
							</tr>
			";
	}
}

$content .= "
						</table>
					</div>
					<div class=\"clear\"></div>
				</div>
			</div>
			<div id=\"new\" style=\"display: none;\" class=\"floatingdialog\">
				<h3 class=\"center\">{$lang['new']}</h3>
				<p style=\"text-align: center;\">{$lang['new_text']}</p>
				<div class=\"form-small\">
					<form action=\"/panel/domains/add_subdomain_action\" method=\"post\" class=\"center\">
						<input type=\"hidden\" name=\"id\" value=\"{$domain['id']}\" />
						<input type=\"hidden\" name=\"domain\" value=\"{$domain['hostname']}\" />
						<fieldset>
							<input class=\"auto\" type=\"text\" value=\"{$lang['subdomain']}\" name=\"subdomain\" onfocus=\"this.value = this.value=='{$lang['subdomain']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$lang['subdomain']}' : this.value; this.value=='{$lang['subdomain']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" />
							<span class=\"help-block\">".str_replace('{DOMAIN}', $domain['hostname'], $lang['tipsubdomain'])."</span>
						</fieldset>
						<fieldset autofocus>	
							<input type=\"submit\" value=\"{$lang['create']}\" />
						</fieldset>
					</form>
				</div>
			</div>
			<div id=\"config\" style=\"display: none;\" class=\"floatingdialog\">
				<h3 class=\"center\">{$lang['config']}</h3>
				<p style=\"text-align: center;\">{$lang['config_text']}</p>
				<div class=\"form-small\">
					<form action=\"/panel/domains/config_subdomain_action\" method=\"post\" class=\"center\">
						<input id=\"subdomainid\" type=\"hidden\" name=\"id\" value=\"\" />
						<input type=\"hidden\" name=\"domain\" value=\"{$domain['hostname']}\" />
						<input type=\"hidden\" name=\"domain_id\" value=\"{$domain['id']}\" />
						<fieldset>
							<input id=\"record\" type=\"text\" value=\"\" name=\"record\" />
							<span class=\"help-block\">{$lang['tiprecord']}</span>
						</fieldset>
						<fieldset autofocus>	
							<input type=\"submit\" value=\"{$lang['update']}\" />
						</fieldset>
					</form>
				</div>
			</div>
			<div id=\"delete\" class=\"floatingdialog\">
				<h3 class=\"center\">{$lang['delete']}</h3>
				<p style=\"text-align: center;\">{$lang['delete_text']}</p>
				<div class=\"form-small\">		
					<form action=\"/panel/domains/del_subdomain_action?domain={$domain['hostname']}\" method=\"post\" class=\"center\">
						<input id=\"subdomain\" type=\"hidden\" value=\"\" name=\"subdomain\" />
						<fieldset autofocus>	
							<input type=\"submit\" value=\"{$lang['delete_now']}\" />
						</fieldset>
					</form>
				</div>
			</div>
			<script>
				newFlexibleDialog('new', 550);
				newFlexibleDialog('config', 550);
				newFlexibleDialog('delete', 550);
			</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>
