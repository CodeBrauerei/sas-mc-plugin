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

$server = \Classes\Main::Server();

if (isset($_POST[''])) {
	$server->execute('rm -r /var/bukkit');
}
?>
<h5>Minecraft löschen</h5>
<p>
	Diese Aktion löscht den vollständigen Bukkit-Server.
</p>
<form action="?p=plugins&s=show&id=<?=$_GET['id']?>&spl=6" method="post">
	<input type="submit" name="del" value="Bukkit löschen" class="button pink">
</form>