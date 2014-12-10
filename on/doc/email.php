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
				<h3>{$lang['intro']}</h3>
				<p>{$lang['intro_text']}</p>
				<pre><code class=\"php\">mail('to@domain.com', 'subject', 'message');</code></pre>
				<br />
				<p>{$lang['intro2']}</p>
				<pre><code>\$headers = 'From: webmaster@example.com' . ' ' .
'Reply-To: webmaster@example.com' . ' ';
if(! mail('to@domain.com', 'subject', 'message', \$headers))
	die('An error has occured');</code></pre>
				<br />
				<p>{$lang['documentation']}</p>
				<br /><br />
				
				<h3>{$lang['verify']}</h3>
				<p>{$lang['verify_text']}</p>
				<p>{$lang['filter']}</p>
				<pre><code>if( filter_var(\$_POST['email'], FILTER_VALIDATE_EMAIL) )</code></pre>
				<br/>
				<p>{$lang['check_dns']}</p>
				<pre><code>\$parts = explode('@',\$_POST['email']);

if( in_array(gethostbyname(\$parts[1]), array( gethostbyname('ns1.olympe.in'), gethostbyname('ns2.olympe.in') )) )
	die('Email does not exist');</code></pre>
				<br/>
				<p>{$lang['blacklist']}</p>
				<pre><code>\$lines = file('banned.txt');
\$search = array(' ', '\\t', '\\n', '\\r');

foreach (\$lines as \$key => \$content) {
	\$banned .= \$content.'|';
}

\$contents = str_replace(\$search, '', \$banned);
\$contents = explode('|', \$contents);
			
if(in_array(\$parts[1], \$contents))
	die('Temporary emails are not allowed');</code></pre>
				<br />
				<p>{$lang['quota_request']}</p>
			</div>
			<div class=\"clear\"></div>
		    <br />
		  <br />
		</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>