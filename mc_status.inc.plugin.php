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
$ip = $server->getAddress();
if (isset($_POST['port'])) {
	$port = $_POST['port'];
} else {
	$port = 25565;
}

if (@fsockopen($ip, $port, $errno, $errstr, 3)) {
    $status = 'online';
} else {
    $status = 'offline';
}
?>
<h5>Status</h5>
<div class="halbe-box">
	<fieldset>
		<p>		
			Adresse: <code><?=$ip.":".$port?></code>
			<br><br>
			Ihr Minecraft-Server ist <b><?=$status?></b>.
		</p>
	</fieldset>
</div>
<div class="halbe-box lastbox">
	<fieldset>
		<p>Wenn der Server nicht den Port 25565 nutzt, kann hier ein anderer Port angegeben werden.</p>
		<form action="?p=plugins&s=show&id=<?=$_GET['id']?>&spl=3" method="post">
			<input type="text" name="port" id="" class="text-small" placeholder="Port">
			<input type="submit" value="ok" class="button green">
		</form>
	</fieldset>
</div>
