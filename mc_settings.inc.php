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
if (isset($_POST['ipb']))
	$server->execute('echo "'.$_POST['ipb'].'" >> /var/bukkit/banned-ips.txt');
if (isset($_POST['usb']))
	$server->execute('echo "'.$_POST['usb'].'" >> /var/bukkit/banned-players.txt');
if (isset($_POST['usw']))
	$server->execute('echo "'.$_POST['usw'].'" >> /var/bukkit/white-list.txt');
if (isset($_POST['uso']))
	$server->execute('echo "'.$_POST['uso'].'" >> /var/bukkit/ops.txt');
if (isset($_POST['prop']))
	$server->execute('echo "'.$_POST['prop'].'" > /var/bukkit/server.properties');





?>
<h5>Einstellungen</h5>
<form action="?p=plugins&s=show&id=<?=$_GET['id']?>&spl=5" method="post">
	<fieldset>
	<?php if (!isset($_POST['file'])): ?>
	<p>
		Was möchte Sie tun?
	</p>
	<select name="file" >
		<option value="1">IP blocken</option>
		<option value="2">User blocken</option>
		<option value="3">User zur Whitelist.txt hinzufügen</option>
		<option value="4">User zur Ops.txt hinzufügen</option>
		<option value="5">server.properties bearbeiten</option>
	</select>
	<?php elseif ($_POST['file'] == 1): ?>
		<input type="text" name="ipb" class="text-long" placeholder="IP-Adresse">
	<?php elseif ($_POST['file'] == 2): ?>
		<input type="text" name="usb" class="text-long" placeholder="Username">
	<?php elseif ($_POST['file'] == 3): ?>
		<input type="text" name="usw" class="text-long" placeholder="Username">
	<?php elseif ($_POST['file'] == 4): ?>
		<input type="text" name="uso" class="text-long" placeholder="Username">
	<?php elseif ($_POST['file'] == 5): ?>
	<textarea name="prop" id="console" style=>
<?=$server->execute('cat /var/bukkit/server.properties');?>		
	</textarea>
	<div class="clearfix"></div><br>


	<? endif; ?>
	<input type="submit" value="durchführen" class="button black">
	</fieldset>
</form>