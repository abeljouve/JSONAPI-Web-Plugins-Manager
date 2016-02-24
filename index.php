<?php
require 'JSONAPI.php';

$host = "127.0.0.1";       // Adresse IP du serveur
$port = 20059;             // Port du serveur, par défaut 20059
$username = "admin";       // Nom d'utilisateur dans le fichier users.yml
$password = "changeme";         // Mot de passe de l'utilisateur dans users.yml

$api = new JSONAPI($host,$port,$username,$password, "");
?>
<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<style>
			@font-face{
				font-family:'Glyphicons Halflings';
				src:url(fonts/glyphicons-halflings-regular.eot);
				src:url(fonts/glyphicons-halflings-regular.eot?#iefix) format('embedded-opentype'),url(fonts/glyphicons-halflings-regular.woff) format('woff'),url(fonts/glyphicons-halflings-regular.ttf) format('truetype'),url(fonts/glyphicons-halflings-regular.svg#glyphicons_halflingsregular) format('svg')
			}
			.pl_style{
				font-family:'Arial';
				font-weight:bold;
				border:1px solid #AAA;
				border-radius:5px;
				padding:5px;
				background-color:#EEE;				
			}
			.pl_style tbody td{
				padding-top:10px;
				padding-right:10px;
			}
			.glyphicon{
				position:relative;
				top:1px;
				display:inline-block;
				font-family:'Glyphicons Halflings';
				font-style:normal;
				font-weight:400;
				line-height:1;
				-webkit-font-smoothing:antialiased;
				-moz-osx-font-smoothing:grayscale
			}
			.glyphicon-remove:before{
				color: #A94442;
				content:"\e014"
			}
			.glyphicon-ok:before{
				color: #3C763D;
				content:"\e013"
			}
		</style>
	</head>
	<body>
	<?php
			if(isset($_GET['pl']) && isset($_GET['action'])){				// Activation ou désativation d'un plugins
				switch($_GET['action']){
					case 'Stop':
						$api->call("disablePlugin",array($_GET['pl']));
					break;
					case 'Start':
						$api->call("enablePlugin",array($_GET['pl']));
					break;
				}
				header("location:.");
			}
			
			$plugins = $api->call("getPlugins");							// Liste des plugins dans un tableau array
			$plugins = $plugins[0]['success'];
			
			echo"<table class='pl_style'>";									// Tableau HTML 
			echo"<thead>
					<tr>
						<td>Nom</td><td>Version</td><td>Action</td>
					</tr>
			     </thead>";
			echo"<tbody>";
			foreach ($plugins as $value) { 									// Traitement de chaques plugins
			
			if($value['enabled']){											// Définition de variable en fonction 
				$color="#3C763D";											// de l'état de plugins (activé ou désactivé)
				$button="glyphicon-remove";
				$action = "Stop";
			}else{
				$color="#A94442";
				$button="glyphicon-ok";
				$action = "Start";
				}
																			// Affichage dans un tableau HTML
			echo "<tr>
					<td>
						<span style='color:".$color.";'>".$value['name']."</span>
					</td>
					<td>
						<span>".$value['version']."</span>
					</td>
					<td>
						<a title='".$action." ".$value['name']."' style='text-decoration:none;' href='.?pl=".$value['name']."&action=".$action."' class='glyphicon ".$button."'></a>
					</td>
				</tr>";
			
			}
			echo"</tbody></table>";
	?>
	</body>
</html>