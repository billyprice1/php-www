<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

require_once('on/doc/menu.php');

$content = "
			<div class=\"head-light\">
				<div class=\"container\">
					<h1 class=\"dark\" style=\"float: left;\">{$lang['title']}</h1>
					<form id=\"searchform\" action=\"/doc/search\" method=\"get\"><input type=\"submit\" style=\"display: none;\" /><input name=\"keyword\" class=\"auto\" style=\"width: 380px; font-size: 15px; float: right;\" type=\"text\" id=\"search\" value=\"{$GLOBALS['lang']['search']}\" onfocus=\"this.value = this.value=='{$GLOBALS['lang']['search']}' ? '' : this.value; this.style.color='#4c4c4c';\" onfocusout=\"this.value = this.value == '' ? this.value = '{$GLOBALS['lang']['search']}' : this.value; this.value=='{$GLOBALS['lang']['search']}' ? this.style.color='#cccccc' : this.style.color='#4c4c4c'\" /></form>
					<div class=\"clear\"></div>
				</div>
			</div>	
			<div class=\"content\">
				<div class=\"left small\">
					<div class=\"sidemenu\">
						{$menu}
					</div>					
				</div>
				<div class=\"right big\">
					<span style=\"font-size: 25px; color: #555555; font-weight: bold;\">{$lang['questions']}</span>
					<br /><br />
					<span style=\"font-size: 20px; color: #555555;\">{$lang['answers']}</span>
					<br /><br /><br />
					<div style=\"float: left; width: 370px;\">
						<div style=\" padding-left: 10px; margin: 0 0 30px 0;\">
							<h3 class=\"grey bordered\">{$lang['started']}</h3>
							<ol>
								<li><a href=\"/doc/first\">{$lang['first']}</a></li>
								<li><a href=\"/doc/publish\">{$lang['publish']}</a></li>
								<li><a href=\"/doc/info\">{$lang['infos']}</a></li>
								<li><a href=\"/doc/php\">{$lang['php']}</a></li>
							</ol>
						</div>
						<div style=\"padding-left: 10px; margin: 20px 0 30px 0;\">
							<h3 class=\"grey bordered\">{$lang['services']}</h3>
							<ol>
								<li><a href=\"/doc/cloud\">{$lang['cloud']}</a></li>
								<li><a href=\"/doc/stats\">{$lang['stats']}</a></li>
								<li><a href=\"/doc/quotas\">{$lang['quota']}</a></li>
								<li><a href=\"/doc/tokens\">{$lang['tokens']}</a></li>
							</ol>
						</div>
					</div>
					<div style=\"float: right; width: 370px;\">
						<div style=\"padding-left: 10px; margin: 0 0 30px 0;\">
							<h3 class=\"grey bordered\">{$lang['features']}</h3>
							<ol>
								<li><a href=\"/doc/domains\">{$lang['domains']}</a></li>
								<li><a href=\"/doc/databases\">{$lang['databases']}</a></li>
								<li><a href=\"/doc/mails\">{$lang['mails']}</a></li>
								<li><a href=\"/doc/backups\">{$lang['backups']}</a></li>	
							</ol>	
						</div>
						<div style=\"padding-left: 10px; margin: 20px 0 30px 0;\">
							<h3 class=\"grey bordered\">{$lang['about']}</h3>
							<ol>
								<li><a href=\"/doc/what\">{$lang['what']}</a></li>
								<li><a href=\"/doc/techno\">{$lang['techno']}</a></li>
								<li><a href=\"/about/contact\">{$lang['contact']}</a></li>
								<li><a href=\"/about/contact?report\">{$lang['report']}</a></li>
							</ol>			
						</div>						
					</div>
					<div class=\"clear\"></div>
					<div class=\"separator\" style=\"width: 600px;\"></div>
					<div style=\"position: relative;\">
						<h3 class=\"grey\" id=\"title\">{$lang['faq']}</h3>
						<div id=\"hiddentitle\" style=\"display: none;\">{$lang['faq']}</div>
						<div class=\"faq\">
							<div id=\"questions\">
								<div style=\"float: left; width: 400px;\">
									<div id=\"question-1\" class=\"question\"><a style=\"color:#e89062;\" href=\"/doc/publish\">{$lang['question_1']}</a></div>
									<div id=\"question-2\" class=\"question\" onclick=\"showAnswer(2); return false;\">{$lang['question_2']}</div>
									<div id=\"question-3\" class=\"question\" onclick=\"showAnswer(3); return false;\">{$lang['question_3']}</div>
									<div id=\"question-4\" class=\"question\" onclick=\"showAnswer(4); return false;\">{$lang['question_4']}</div>
									<div id=\"question-5\" class=\"question\" onclick=\"showAnswer(5); return false;\">{$lang['question_5']}</div>
								</div>
								<div style=\"float: right; width: 400px;\">
									<div id=\"question-6\" class=\"question\" onclick=\"showAnswer(6); return false;\">{$lang['question_6']}</div>
									<div id=\"question-7\" class=\"question\"><a style=\"color:#e89062;\" href=\"/doc/stats\">{$lang['question_7']}</a></div>
									<div id=\"question-8\" class=\"question\" onclick=\"showAnswer(8); return false;\">{$lang['question_8']}</div>
									<div id=\"question-9\" class=\"question\" onclick=\"showAnswer(9); return false;\">{$lang['question_9']}</div>
									<div id=\"question-10\" class=\"question\" onclick=\"showAnswer(10); return false;\">{$lang['question_10']}</div>
								</div>
							</div>
							<div id=\"answer-2\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(2); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['dns']}</p>
								<br />
								<table>
									<tr>
										<th>{$lang['serv']}</th>
										<th>{$lang['host']}</th>
										<th>{$lang['ip']}</th>
									</tr>
									<tr>
										<td>{$lang['ns1']}</td>
										<td>ns1.olympe.in</td>
										<td>178.32.167.243</td>
									</tr>
									<tr>
										<td>{$lang['ns2']}</td>
										<td>ns2.olympe.in</td>
										<td>178.32.65.67</td>
									</tr>
								</table>
								<div style=\"float:right; margin-top: 20px;\">
									<a class=\"button classic\" style=\"width: 275px; height: 22px; float: right;\" href=\"/doc/publish\">
										<img src=\"/on/images/arrow-right.png\" style=\"float: left;\">
										<span style=\"display: block; padding-top: 3px;\">{$lang['domain_conf']}</span>
									</a>
								</div>
							</div>
							<div id=\"answer-3\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(3); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['dir']}</p>
								<div style=\"float:right; margin-top: 20px;\">
									<a class=\"button classic\" style=\"width: 275px; height: 22px; float: right;\" href=\"/doc/publish\">
										<img src=\"/on/images/arrow-right.png\" style=\"float: left;\">
										<span style=\"display: block; padding-top: 3px;\">{$lang['domain_conf']}</span>
									</a>
								</div>
							</div>
							<div id=\"answer-4\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(4); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['phperrors']}</p>
							</div>
							<div id=\"answer-5\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(5); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['access']}</p>
								<div style=\"float:right; margin-top: 20px;\">
									<a class=\"button classic\" style=\"width: 275px; height: 22px; float: right;\" href=\"/doc/databases\">
										<img src=\"/on/images/arrow-right.png\" style=\"float: left;\">
										<span style=\"display: block; padding-top: 3px;\">{$lang['db_conf']}</span>
									</a>
								</div>
							</div>
							<div id=\"answer-6\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(6); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['admindb']}</p>
								<br />
								<table>
									<tr>
										<th>{$lang['service']}</th>
										<th>{$lang['desc']}</th>
										<th>{$lang['address']}</th>
									</tr>
									<tr>
										<td>PHPMyAdmin</td>
										<td>{$lang['mysql']}</td>
										<td><a href=\"https://pma.olympe.in\">https://pma.olympe.in</a></td>
									</tr>
									<tr>
										<td>PHPPgAdmin</td>
										<td>{$lang['pgsql']}</td>
										<td><a href=\"https://pma.olympe.in\">https://ppa.olympe.in</a></td>
									</tr>
								</table>
								<div style=\"float:right; margin-top: 20px;\">
									<a class=\"button classic\" style=\"width: 275px; height: 22px; float: right;\" href=\"/doc/databases\">
										<img src=\"/on/images/arrow-right.png\" style=\"float: left;\">
										<span style=\"display: block; padding-top: 3px;\">{$lang['db_conf']}</span>
									</a>
								</div>
							</div>
							<div id=\"answer-8\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(8); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['capture']}</p>
							</div>
							<div id=\"answer-9\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(9); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['finance']}</p>
							</div>
							<div id=\"answer-10\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(10); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['opensource']}</p>
							</div>
						</div>
					</div>
					<br /><br />
				</div>
				<div class=\"clear\"></div>
				<br /><br />
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>