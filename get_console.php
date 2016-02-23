<?php
require 'JSONAPI.php';

$host = "127.0.0.1";     // Adresse IP du serveur
$port = 20059;             // Port du serveur, par défaut 20059
$username = "admin";     // Nom d'utilisateur dans le fichier users.yml
$password = "changeme";         // Mot de passe de l'utilisateur dans users.yml

$api = new JSONAPI($host,$port,$username,$password, "");
$console = $api->call("getLatestConsoleLogs");                        // Récupération des 50 dernières lignes de la console dans un tableau
$console = $console[0]["success"];    
                                
// var_dump($api->call("getLatestConsoleLogs")); Pour afficher la console à l'état brute

if(isset($_POST["COMMANDE"]) && $_POST["COMMANDE"] != ""){            // Envoie de la commande au serveur
    $api->call("runConsoleCommand", array($_POST["COMMANDE"]));
}

foreach ($console as $value) {                                        // foreach permet de parcourir le tableau et de traiter lignes après lignes

    $console = $value["line"];
    if(strpos($console, " WARN]:") == true || strpos($console, " ERROR]:") == true) {
        $console = '<span style="color: red;">'.$console;             // Affichage de la ligne en rouge si on détecte
    }                                                                 // une erreur( chaine de texte " WARN]:" et " ERROR]:")
    $string_color = array("[0;33;22m",                                // Liste des codes 'couleurs' retourné par JSONAPI
                   "[0;37;1m",
                   "[m",
                   "[0;32;1m",
                   "[0;33;1m",
                   "[0;37;22m",
                   "[0;34;1m");

    $string_code = array('<span style="color: #57A82F;">',            // Liste des correspondances de chacun des codes 'couleurs' à une couleur en HTML
               '<span style="color: #FFF;">',
               '',
               '<span style="color: #08F600;">',
               '<span style="color: #FEF600;">',
               '<span style="color: #FFF;">',
               '<span style="color: #0000DD;">');
               
    $console = str_replace($string_color, $string_code, $console);    // Remplacement des codes 'couleurs' par sa correspondance en HTML

    echo "<span style=\"color:#BBB;\">".$console."</span><br/>";      // Affichage de la console en HTML pour être récupéré par Ajax
}
?>