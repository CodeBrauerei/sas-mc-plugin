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

$log = $server->execute('cat /var/bukkit/server.log');
$logf = explode("\n", $log);

function highlightLog($logline) {
	$logline =  explode("\n",(wordwrap($logline, 10,"\n",false)));
	if (isset($logline[0])) {$logline[0] = '<span style="color:#00008F; font-weight: bold;">'.$logline[0].'</span>';}
	if (isset($logline[1])) {$logline[1] = '<span style="color:#9D0077; font-weight: bold;">'.$logline[1].'</span>';}
	return implode(" ", $logline);
}
?>
<h3>Server.log</h3>
<ul id="logline" class="log">
	<?php
		foreach ($logf as $value) {
			echo "<li>". highlightLog($value) ."</li>\n";
		}
	?>
</ul>