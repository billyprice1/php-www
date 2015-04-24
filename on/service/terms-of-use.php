<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

$nb_articles = 7;
$i = $ii = $iii = 1;

$last_update = 1421276400;
$last_update_month = date('F', $last_update);
$last_update_month_translate = $lang[$last_update_month];
$last_update = str_replace($last_update_month, $last_update_month_translate, date($lang['DATEFORMAT'], $last_update));

$content = "
		<div class=\"head-light\">
			<div class=\"container\">
				<h1 class=\"dark\">{$lang['title']}</h1>
			</div>
		</div>	
		<div class=\"content\">		
			<div class=\"left small\">
				<div class=\"sidemenu\">
					<div id=\"menu-fixed\">
						<ul>
							<li style=\"cursor: auto;\">{$lang['index']}</li>
							<ul>
								<a class=\"goto\" name=\"art_1\" href=\"\"><li style=\"padding-left: 25px;\">{$lang['index_art1']} - {$lang['label_1']}</li></a>
								<a class=\"goto\" name=\"art_2\" href=\"\"><li style=\"padding-left: 25px;\">{$lang['index_art2']} - {$lang['label_2']}</li></a>
								<a class=\"goto\" name=\"art_3\" href=\"\"><li style=\"padding-left: 25px;\">{$lang['index_art3']} - {$lang['label_3']}</li></a>
								<a class=\"goto\" name=\"art_4\" href=\"\"><li style=\"padding-left: 25px;\">{$lang['index_art4']} - {$lang['label_4']}</li></a>
								<a class=\"goto\" name=\"art_5\" href=\"\"><li style=\"padding-left: 25px;\">{$lang['index_art5']} - {$lang['label_5']}</li></a>
								<a class=\"goto\" name=\"art_6\" href=\"\"><li style=\"padding-left: 25px;\">{$lang['index_art6']} - {$lang['label_6']}</li></a>
								<a class=\"goto\" name=\"art_7\" href=\"\"><li style=\"padding-left: 25px;\">{$lang['index_art7']} - {$lang['label_7']}</li></a>
							</ul>
						</ul>
						<p style=\"margin-top: 40px; color: #AAA; font-size: 0.9em;\">{$lang['notice']}</p>
					</div>
				</div>					
			</div>
			<div class=\"right big\">
				{$lang['language_warning']}
				<h2 class=\"dark\" style=\"font-size: 0.9em; float:right;\">{$lang['last_update']} {$last_update}</h2>
";

while ($i <= $nb_articles) {
	$label = $lang['label_'. $i];
	$article = $lang['art_'. $i];
    $content .= "
				<h3 id=\"art_{$i}\">{$label}</h3>
				<div style=\"text-align: justify; margin-bottom: 40px;\">{$article}</div>
	";
	
	$i++;
}

$content .= "
			</div>
			<div class=\"clear\"></div><br /><br />
		</div>
	</div>
	<script>
	$(window).load(function() {
		function scrollToAnchor(anchor){
			var aTag = $(\"h3[id='\"+ anchor +\"']\");
			$('html,body').animate({scrollTop: aTag.offset().top - 70},'fast');
		}

		$(\".goto\").click(function() {
			goto = $(this).attr('name');
		   scrollToAnchor(goto);
		   return false;
		});
		
		var offset = $('#menu-fixed').offset(),";

while ($ii <= $nb_articles) {
	$content .= "
			offset_art{$ii} = $('#art_{$ii}').offset(),";
	$ii++;
}

$content .= "
			topPadding = 70;
			
		if($(window).height() - 250 < 450) $('#menu-fixed a.goto li').css('padding','7px 15px 7px 25px');
		else $('#menu-fixed p').show();
		  
		if($(window).height() - 250 < 360) $('#menu-fixed p').hide();
		else $('#menu-fixed p').show();

		$(window).scroll(function() {
			if ($(window).scrollTop() > offset.top) {
				$('#menu-fixed').stop().animate({
					marginTop: $(window).scrollTop() - offset.top + topPadding
				});
			} else {
				$('#menu-fixed').stop().animate({
					marginTop: 0
				});
			}

";

while ($iii <= $nb_articles) {
	$content .= "if ($(window).scrollTop() > offset_art{$iii}.top - 100) { $('li.active').removeClass('active'); $('a[name=\"art_{$iii}\"] li').addClass('active'); }";
	$iii++;
}

$content .= "
		});
	});
	</script>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>