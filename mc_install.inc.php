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
if (isset($_POST['dl'])) {
    $dlcmd = "mkdir -p /var/bukkit/ && cd /var/bukkit/ && rm craftbukkit.jar -f && wget -q http://dl.bukkit.org/latest-rb/craftbukkit.jar && echo 'Aktion abgeschlossen.'";
    $info = $server->execute($dlcmd);
}

if (isset($_POST['script'])) {
    if (is_numeric($_POST['mem'])) {
        if (isset($_POST['onlinemode'])) {
$script = '
#!/bin/sh
cd \"\${0%/*}\"; java -Xms'.$_POST['mem'].'M -Xmx'.$_POST['mem'].'M -jar craftbukkit.jar -o true
';
        } else {
$script = 
'#!/bin/sh
cd \"\${0%/*}\"; java -Xms'.$_POST['mem'].'M -Xmx'.$_POST['mem'].'M -jar craftbukkit.jar -o false
';
        }
        $scriptcmd = 'touch /var/bukkit/startmc.sh && echo -ne "'.$script.'" > /var/bukkit/startmc.sh && echo "Aktion abgeschlossen."';
        $info = $server->execute($scriptcmd);
    } else {
        echo '<span class="error">Die Größe muss eine ganze Zahl sein.</span>';
    }

}
?>    

<h5>Installation</h5>
<? if (isset($_POST['script']) || isset($_POST['dl'])): ?>
<span class="info">
<code><?=$info?></code>    
</span>
<? endif; ?>    
<div class="halbe-box"> 
    <fieldset>
        <legend>Bukkit.jar Download</legend>
        <form action="?p=plugins&s=show&id=<?=$_GET['id']?>&spl=1" method="post">
            <p>
                Hiermit können Sie die aktuellste Bukkit.jar herunterladen. Diese wird unter <code>/var/bukkit/</code> gespeichert. 
                Wenn Sie eine ältere Version möchten, können Sie diese als Downloadlink angeben. Sollte die Datei vorhanden sein, wird diese überschrieben.
            </p>
            <p>
                <b>bukkit.jar Download-Link</b> (alternativ ändern):<br>
                <input type="text" class="text-long" name="dllink" value="http://dl.bukkit.org/latest-rb/craftbukkit.jar">
            </p>
            <br>
                <input type="submit" name="dl" value="Herunterladen" class="button black">
        </form>
    </fieldset>
</div>
<div class="halbe-box lastbox">
    <fieldset>
        <legend>Startskript</legend>
        <form action="?p=plugins&s=show&id=<?=$_GET['id']?>&spl=1" method="post">
            <p>
                Damit der Bukkit gestartet werden kann, muss ein Startskript her. Dieses wird hiermit automatisch erstellt.
                Sollte es bereits existieren, wird es hiermit überschrieben.
            </p>
            <p>
                <b>Arbeitsspeicher für Java (in MB)<br>
                <input type="number" class="text-small" name="mem" value="1024" min="512" max="131072" step="128">
            </p>
            <p style="line-height:1.2;">
                <input type="checkbox" name="onlinemode"> Online Mode?
                <a href="#" class="tooltip"><i class="icon-help-circled"></i>
                        <span style="width:400px;font-weight:400;">
                            <b>Gesetzt:</b><br>
                            Aktiviert. Server nimmt an, dass eine Internetverbindung besteht und vergleicht jeden verbundenen Spieler mit der Datenbank von Minecraft.<br>
                            <b>Nicht gesetzt:</b><br>
                            Deaktiviert. Der Server vergleicht verbindene Spieler nicht mit der Datenbank. (Ohne Minecraft-Account auf Server)
                        </span></a>
                    </p>
            <input type="submit" name="script" value="Script erstellen" class="button black">
        </form>
    </fieldset>
</div>
<div class="clearfix"></div>