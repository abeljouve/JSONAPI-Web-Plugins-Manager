<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<script src="jquery.min.js"></script>
	<script type="text/javascript">
	
	function sendcommand(){										// Envoie de la commande au script PHP
		var commande = $("#commande").val();					// Récupération du contenue du champ texte
		var form_data = { COMMANDE : commande };
		$.ajax({												// Envoie des données par method POST à get_console.php
			type: "POST",
			url: "get_console.php",
			data: form_data,
			dataType: "html",
			error:function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status+"T"+ajaxOptions+"I"+thrownError);
			},
		});
		document.getElementById('commande').value = "";			// On vide le champ texte après avoir envoyer la commande

	}
	
	function view_console(){									// Récupération de la console via Ajax
	$.ajax({
		url: "get_console.php",
		dataType: "html",
		error:function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status+"T"+ajaxOptions+"I"+thrownError);
		},
		success: function(response){
            $('#console').html(response);						// Insertion du code html généré par get_console.php dans la div avec id="console"
        }
		});
	}
	setInterval( view_console , 1500); 							//Intervale d'actualisation de la console, par défaut 1500
																// Ne pas indiquer une valeur trop faible pour éviter de faire lagger le Serveur et le Client
	</script>
<style>
@font-face {
	font-family: "Open Sans";
	font-style: normal;
	font-weight: 400;
	src: local("Open Sans"), local("OpenSans"), url("http://fonts.gstatic.com/s/opensans/v10/u-WUoqrET9fUeobQW7jkRT8E0i7KZn-EPnyo3HZu7kw.woff") format("woff");
}
.console {
	width: 700px;
	height: 400px;
	background-color:black;
	color:#FFF;
	font-family: 'Open Sans';
	font-size:11px;
	overflow: auto;
	font-weight:bold;
}
.sendcommand{
	width: 690px;
	padding:5px;
	background-color:black;
	color:#BBB;
	border:none;
}
</style>
</head>
<body>
	<div class="console">
		<div id="console">
		&nbsp;
		</div>
	</div>
	<input class="sendcommand" type="text" id="commande" onkeypress="if(event.keyCode==13){sendcommand();}" placeholder="Entrer votre commande"/>
</body>
</html>