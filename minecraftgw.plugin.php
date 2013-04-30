<?php

/**
*
* Minecraft Server Plugin für SAS (https://github.com/pataga/SAS)
*
* @link https://github.com/GabrielWanzek/sas-mc-plugin
* @license MIT License
* @author @GabrielWanzek
*
*/

set_time_limit(0);
$info = "";
$server = \Classes\Main::Server();
?>
<style>
    #menu {margin: auto; text-align: center;}
    #menu ul {margin:0;padding:0;list-style-type:none;}
    #menu a {display:block;width:100px;height:20px;line-height:20px;color:#000;background-color:transparent;text-decoration:none;text-align:center; border:3px solid #000;border-radius:5px;-webkit-transition:all .25s ease;-moz-transition:all .25s ease;-ms-transition:all .25s ease;-o-transition:all .25s ease;transition:all .25s ease;}
    #menu a:hover {background-color:#ccc}
    #menu li {float:left;margin-right: 3px}
</style>
<h3>Minecraft-Plugin</h3>
<div id="menu">
    <ul>
        <li><a href="?p=plugins&s=show&id=<?=$_GET['id']?>&spl=1">Installation</a></li>
        <li><a href="?p=plugins&s=show&id=<?=$_GET['id']?>&spl=2">Steuerung</a></li>
        <li><a href="?p=plugins&s=show&id=<?=$_GET['id']?>&spl=3">Status</a></li>
        <li><a href="?p=plugins&s=show&id=<?=$_GET['id']?>&spl=4">Serverlog</a></li>
        <li><a href="?p=plugins&s=show&id=<?=$_GET['id']?>&spl=5">Einstellungen</a></li>
        <li><a href="?p=plugins&s=show&id=<?=$_GET['id']?>&spl=6">Entfernen</a></li>
    </ul>
</div>
<div class="clearfix"></div>

<?php
if(isset($_GET['spl'])) {
    switch ($_GET['spl']) {
        case '1':
            require 'mc_install.inc.php';
            break;
        case '2':
            require 'mc_control.inc.php';
            break;
        case '3':
            require 'mc_status.inc.php';
            break;
        case '4':
            require 'mc_serverlog.inc.php';
            break;
        case '5':
            require 'mc_settings.inc.php';
            break;
        case '6':
            require 'mc_del.inc.php';
            break;            
        default:
            require 'mc_home.inc.php';
            break;
    }
} else {
    require 'mc_home.inc.php';
}

?>