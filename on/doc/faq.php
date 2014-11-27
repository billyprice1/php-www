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
					<div style=\"position: relative;\">
						<h3 class=\"grey\" id=\"title\">{$lang['popular']}</h3>
						<div id=\"hiddentitle\" style=\"display: none;\">{$lang['popular']}</div>
						<div class=\"faq\">
							<div id=\"questions\">
								<div style=\"float: left; width: 400px;\">
									<div id=\"question-1\" class=\"question\"><a style=\"color:#e89062;\" href=\"/doc/publish\">{$lang['question_1']}</a></div>
									<div id=\"question-2\" class=\"question\" onclick=\"showAnswer(2); return false;\">{$lang['question_2']}</div>
									<div id=\"question-3\" class=\"question\" onclick=\"showAnswer(3); return false;\">{$lang['question_3']}</div>
									<div id=\"question-4\" class=\"question\" onclick=\"showAnswer(4); return false;\">{$lang['question_4']}</div>
									<div id=\"question-5\" class=\"question\" onclick=\"showAnswer(5); return false;\">{$lang['question_5']}</div>
									<div id=\"question-11\" class=\"question\" onclick=\"showAnswer(11); return false;\">{$lang['question_11']}</div>
								</div>
								<div style=\"float: right; width: 400px;\">
									<div id=\"question-6\" class=\"question\" onclick=\"showAnswer(6); return false;\">{$lang['question_6']}</div>
									<div id=\"question-7\" class=\"question\"><a style=\"color:#e89062;\" href=\"/doc/stats\">{$lang['question_7']}</a></div>
									<div id=\"question-8\" class=\"question\" onclick=\"showAnswer(8); return false;\">{$lang['question_8']}</div>
									<div id=\"question-9\" class=\"question\" onclick=\"showAnswer(9); return false;\">{$lang['question_9']}</div>
									<div id=\"question-10\" class=\"question\" onclick=\"showAnswer(10); return false;\">{$lang['question_10']}</div>
									<div id=\"question-12\" class=\"question\" onclick=\"showAnswer(12); return false;\">{$lang['question_12']}</div>
								</div>
							</div>
							<div id=\"answer-1\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(1); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['transfer']}</p>
								<br />
								<table>
									<tr>
										<th>{$lang['type']}</th>
										<th>{$lang['hostname']}</th>
										<th>{$lang['port']}</th>
										<th>{$lang['user']}</th>
									</tr>
									<tr>	
										<td>FTP</td>
										<td>ftp.olympe.in</td>
										<td>21</td>
										<td><i>{$lang['name']}</i></td>
									</tr>
									<tr>	
										<td>SFTP</td>
										<td>ftp.olympe.in</td>
										<td>22</td>
										<td><i>{$lang['name']}</i></td>
									</tr>
								</table>
								<br /><br />
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
							</div>
							<div id=\"answer-3\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(3); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['dir']}</p>
							</div>
							<div id=\"answer-4\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(4); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['phperrors']}</p>
							</div>
							<div id=\"answer-5\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(5); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['access']}</p>
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
										<td><a href=\"https://ppa.olympe.in\">https://ppa.olympe.in</a></td>
									</tr>
								</table>
							</div>
							<div id=\"answer-7\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(7); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['statswhere']}</p>
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
							<div id=\"answer-11\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(11); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['nom_compte']}</p>
							</div>
							<div id=\"answer-12\" class=\"answer\">
								<div style=\"position: absolute; right: 0; top: 0;\"><a href=\"#\" onclick=\"showQuestions(12); return false;\"><img class=\"link\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/icons/small/close.png\" alt=\"\" /></a></div>
								<p>{$lang['cgu']}</p>
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