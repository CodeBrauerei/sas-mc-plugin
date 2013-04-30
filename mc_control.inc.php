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

if (isset($_POST['start']))
	$server->execute('cd /var/bukkit/ && screen -AmdS minecraft ./startmc.sh');
if (isset($_POST['stop']))
	$server->execute('screen -S minecraft -p 0 -X stuff "`printf "stop\r"`";');
if (isset($_POST['cmda']))
	$server->execute('screen -S minecraft -p 0 -X stuff "`printf "'.$_POST['cmd'].'\r"`";');

?>
<h5>Steuerung</h5>
<span class="error">
	Das Starten geht noch nicht, hier treten mysteriöse Probleme auf.<br>Sollten man hiermit einen Server starten, bekommt man einen "toten" Screen.<br>
	Befehl zum Beenden: <code>screen -wipe</code>.
</span>
<fieldset>
	<form action="?p=plugins&s=show&id=<?=$_GET['id']?>&spl=2" method="post">
		<div class="viertel-box">
			<p>Screenname: <code>minecraft</code></p>
			<input type="submit" name="start" value="Start" class="button green" style="width:118px;height:40px">
		</div>
		<div class="viertel-box">
			<p>Sofort beenden</p>
			<input type="submit" name="stop" value="Stop" class="button pink" style="width:118px;height:40px">
		</div>
		<div class="halbe-box lastbox">
			<p>Befehl ausführen:</p>
			<input type="text" name="cmd" class="text-medium">
			<input type="submit" name="cmda" value="ausführen" class="button black">
		</div>
		<div class="clearfix"></div>
	</form>
</fieldset>
<p>
	<b>Achtung:</b><br>"Screen" und "Java" muss installiert sein!<br>
	Befehl zur Installation:<br>
	<code>apt-get install screen openjdk-6-jre -fy</code>
</p>