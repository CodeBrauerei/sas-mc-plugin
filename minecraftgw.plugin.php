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
$dlcmd = "mkdir -p /var/bukkit/ && cd /var/bukkit/ && wget -s ".$_POST['dllink'];
$script = "#!/bin/sh\n
 BINDIR=$(dirname \"$(readlink -fn \"$0\")\")\n
 cd \"$BINDIR\"\n
 java -Xms1024M -Xmx1024M -jar craftbukkit.jar true\n";


?>
<h3>Minecraft-Plugin</h3>
<fieldset>
	<div class="halbe-box">
	<legend>Aktionen</legend>
		<form action="?p=plugin&s=###" method="post">
			<p>
				Hiermit können Sie die aktuellste Bukkit.jar herunterladen. Diese wird unter <code>/var/bukkit/</code> gespeichert. 
				Wenn Sie eine ältere Version möchten, können Sie diese als Downloadlink angeben.
			</p>
			<p>
				<b>bukkit.jar Download-Link</b> (alternativ ändern):<br>
				<input type="text" class="text-long" name="dllink" value="http://dl.bukkit.org/latest-rb/craftbukkit.jar">
				<br>
				<input type="submit" name="dl" value="Herunterladen" class="button black">
			</p>
		</form>
	</div>
	<div class="halbe-box lastbox">
		<form action="?p=plugin&s=###" method="post">
			<p>
				Damit der Bukkit gestartet werden kann 
			</p>
			<p>
				<b>Arbeitsspeicher für Java (in MB)<br>
				<input type="text" class="text-long" name="dllink" value="1024">
				<br>
				<input type="submit" name="script" value="Script erstellen" class="button black">
			</p>
		</form>
	</div>
	<div class="clearfix"></div>
</fieldset>