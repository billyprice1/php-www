<?php

if( !defined('PROPER_START') )
{
	header("HTTP/1.0 403 Forbidden");
	exit;
}

//$news = api::send('news/list', array('id'=>$_GET['id']), $GLOBALS['CONFIG']['API_USERNAME'].':'.$GLOBALS['CONFIG']['API_PASSWORD']);
//$new = $news[0]

$content = "
			<div class=\"head-light\">
				<div class=\"container\" style=\"text-align: center;\">
					<h1 class=\"dark\" style=\"text-align: center;\">Modules PHP Olympe</h1>
					<br />
					<div style=\"width: 305px; margin: 0 auto;\">
						<span style=\"color: #797979; font-size: 14px; display: block; float: left; padding-top: 7px;\">15 janvier 2014 par</span>
						<img style=\"display: block; float: left; margin-left: 10px;\" src=\"/{$GLOBALS['CONFIG']['SITE']}/images/team/4.png\" class=\"author\" />
						<a style=\"display: block; float: left; padding-top: 8px; margin-left: 10px;\" href=\"/about/team#Simon Uyttendaele\">Simon Uyttendaele</a>
						<div class=\"clear\"></div>
					</div>
				</div>
			</div>
			<div class=\"content\" style=\"width: 850px;\">
<!-- DESCRIPTION -->
				<p style='color: #8e8e8e; text-align: justify;'>
					En tant qu'hébergeur de sites web et de données, la plateforme Olympe doit faire face à de nombreux défis concernant la sécurité du système et la performance des serveurs. Dans un environnement dédié, 
					chaque utilisateur est responsable de l'environnement d'exécution dans lequel le site web est installé, ce qui inscrit la politique de sécurité dans un modèle simple : se protéger des menaces extérieures.
				</p>
				<br />
				<img class='blogimage' src='/on/images/news/2/scripting.png' />
				<span class='legend'>Scripting</span>
				<br />
				<p style='color: #8e8e8e; text-align: justify;'>
					Bien que cela soit une entreprise délicate en soi, le modèle d'hébergeur fait face à une menace potentielle d'autant plus grande : se protéger de l'intérieur !
				</p>
<!-- END DESCRIPTION -->
				<br /><br />
<!-- ARTICLE -->
				<h2 class='dark'>La sécurité : une nécessité impérieuse</h2>
				<p style='text-align: justify;'>
					En effet, afin de permettre aux utilisateurs de publier leur site web, il est nécessaire de leur accorder des privilèges sur le système, 
					ce qui implique malheureusement de nombreuses tentatives de piratage des serveurs par certains utilisateurs mal intentionnés. Les nuisances volontaires ou non peuvent se classer en deux catégories 
					(i) celles dirigées vers l'hébergeur lui-même, et (ii) celles dirigées vers les autres utilisateurs. Dans la première catégorie, on retrouve la tentative de monopolisation des ressources (CPU, RAM, réseau, disque), 
					la tentative d'intrusion dans le système ou encore l'exécution de code arbitraire. Dans la deuxième catégorie, on retrouve la tentative d'injection de codes malicieux dans les pages d'un autre utilisateur, 
					la tentative de récupération des données, mots de passe ou de fichiers.<br /><br />
					En simplifié, il faut que chaque utilisateur puisse être virtuellement isolé des autres tout en pouvant exécuter un maximum d'opérations pour le bien de son site sans pour autant affecter le serveur sur lequel il est déployé.
				</p>
				<br />
				<img class='blogimage' style='width: 500px;' src='/on/images/news/2/separate.png' />
				<span class='legend'>Cloisonnement de l'infrastructure</span>
				<br />
				<p style='text-align: justify;'>
					La grande majorité des hébergeurs dits \"de masse\" procèdent effectivement à un cloisonnement des processus utilisateurs dans des environnements distincts. Ceci permet à l'utilisateur une autonomie quasi-totale
					sans risque d'influence des autres utilisateurs. Cependant, ce modèle est relativement coûteux en terme de ressources : un serveur d'entrée de gamme peut héberger un millier de sites tout au plus. Initialement 
					assez pauvre en ressources matérielles, le réseau Olympe a décidé de rompre avec ce type de configuration en exécutant tous les sites dans un seul environnement, ce qui permet d'héberger dix fois plus de 
					sites sur une même machine.
				</p>
				<br />
				<h2 class='dark'>L'exécution des scripts PHP</h2>
				<p style='text-align: justify;'>
					Dès lors, l'<a href='/about/team'>équipe Olympe</a> a dû faire face à ses ambitions en analysant en profondeur les configurations et les paramétrages des différents composants de l'infrastructure. Parmi les solutions implémentées, l'utilisation de 
					la directive <i>disable_functions</i> de PHP qui permet d'interdire l'utilisation de certaines fonctions critiques, et l'utilisation de <a href='http://www.suphp.org'>suPHP</a> qui est une version particulière de PHP permettant
					de vérifier tous les accès au système de fichiers en fonction de l'utilisateur.
				</p>
				<br />
				<img class='blogimage' style='width: 375px;' src='/on/images/news/2/logo-php.png' />
				<span class='legend'>Logo de PHP</span>
				<br />
				<p style='text-align: justify;'>
					Cependant, l'interdiction de certaines fonctions étant souhaitable, d'autres doivent uniquement être limitées ou contrôlées, ce qui n'est pas prévu par PHP. Par ailleurs, la version de <i>suPHP</i> n'est plus maintenue et 
					n'évolue pas avec les nouvelles versions de PHP.
				</p>
				<br />
				<h2 class='dark'>Les modules PHP Olympe</h2>
				<p style='text-align: justify;'>
					Après avoir longuement étudié les alternatives et les possibilités, l'équipe Olympe s'est retroussée les manches et a développé <a href='/developers/tools'>deux modules PHP</a> afin de palier à ces problématiques. Ces deux modules, 
					disponibles en opensource sur le github du réseau Olympe, visent à permettre la modification de n'importe quelle fonction existante de PHP, et d'exécuter chaque script en tant que l'utilisateur concerné tout en restant compatible 
					avec les versions courantes et à venir de PHP.
				</p>
				<br />
				<img class='blogimage' src='/on/images/news/2/github.png' />
				<span class='legend'>Github Olympe</span>
				<br />
				<h2 class='dark'>Le module <i>suphp</i></h2>
				<p style='text-align: justify;'>
					En détail, grâce au module Olympe <a href='https://github.com/OlympeNetwork/php5-suphp'>suphp</a>, chaque processus CGI lancé en root effectue un <i>setgid()</i> et un <i>setuid()</i> en fonction du propriétaire du script exécuté. Cette opération est irréversible, 
					ce qui empêche l'utilisateur d'usurper les droits de l'utilisateur root. Une meilleure rationalisation des ressources viserait à permettre la réutilisation d'un même processus pour plusieurs utilisateurs,
					et donc effectuer un <i>seteuid()</i>. Or, l'utilisation de <i>seteuid()</i> est problématique à cause de l'implémentation de la fonction kernel C <i>access()</i> qui retourne l'uid et non l'effective uid. Cette solution est 
					donc implémentée de manière optionnelle.
				</p>
				<pre><code>
	if( suphp_globals.global_use_effective_uid == 1 )
	{
		if( setegid(st.st_uid) != 0 )
			return FAILURE;
		if( seteuid(st.st_uid) != 0 )
			return FAILURE;
	}
	else
	{
		if( setgid(st.st_uid) != 0 )
			return FAILURE;
		if( setuid(st.st_uid) != 0 )
			return FAILURE;
	}
				</code></pre>
				<span class='legend'>Extrait de suphp.c</span>
				<br />
				<h2 class='dark'>Le module <i>override</i></h2>
				<p style='text-align: justify;'>
					D'autre part, le module Olympe <a href='https://github.com/OlympeNetwork/php5-override'>override</a> permet de modifier les fonctions natives de PHP afin d'en modifier le comportement. L'opération est faite directement dans les tables de pointeurs de fonctions EG(class_table) et 
					EG(function_table) de PHP, ce qui permet d'agir à la source de manière totalement transparente pour les utilisateurs. Ainsi, par exemple, lors de l'évolution de PHP 5.2 à 5.3, la fonction mysql_escape_string a été dépréciée, 
					ce qui générait un grand nombre de problèmes pour les utilisateurs qui utilisaient cette fonction; celle-ci a donc été modifiée pour appeler directement la fonction mysql_real_escape_string recommandée. De nombreuses autres fonctions 
					sont ainsi modifiées afin de permettre un contrôle des ressources et une expérience de webmaster flexible et transparente pour tous les utilisateurs Olympe.
				</p>
<pre><code>
Example if you want to eval some code :
+echo 'Hello World!';
+function hello() { echo 'Hello World!'; }
+function mysqli::hello() { echo 'Hello World!'; }

Example if you want to replace a function (remove it then re-create it) :
-shell_exec
+function shell_exec($arg) { echo 'No no!'; return false; }
-mysqli::kill
+function mysqli::kill(){ echo 'No no!'; }

Example if you want to alter a function (rename it then re-create it and call the original) :
#shell_exec
+function shell_exec($arg) { if( true ) return #shell_exec($arg); else return false; }
#mysqli::kill
+function mysqli::kill() { if( true ) $this->#mysqli::kill(); else return; }
				</code></pre>
				<span class='legend'>Exemple d'override dans le fichier ini</span>
				<br />
				<p style='text-align: justify;'>				
					Si aujourd'hui le réseau Olympe héberge plus de vingt mille sites, c'est certainement grâce à la persévérance de l'équipe dont le souci quotidien est la stabilité de la plateforme et le support personnalisé de chaque utilisateur du réseau 
					via la communauté.
				</p>
				<p style='text-align: justify;'>
					Merci à tous et bonne continuation sur Olympe !
				</p>
<!-- FIN ARTICLE -->
				<br />
			</div>
";

/* ========================== OUTPUT PAGE ========================== */
$template->output($content);

?>