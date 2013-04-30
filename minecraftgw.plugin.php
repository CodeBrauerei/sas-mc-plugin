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
if (!file_exists('filename'))


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
        <li><a href="?p=plugins&s=show&id=<?= $_GET['id'] ?>&spl=1">Installation</a></li>
        <li><a href="?p=plugins&s=show&id=<?= $_GET['id'] ?>&spl=2">Steuerung</a></li>
        <li><a href="?p=plugins&s=show&id=<?= $_GET['id'] ?>&spl=3">Status</a></li>
        <li><a href="?p=plugins&s=show&id=<?= $_GET['id'] ?>&spl=4">Serverlog</a></li>
        <li><a href="?p=plugins&s=show&id=<?= $_GET['id'] ?>&spl=5">Einstellungen</a></li>
        <li><a href="?p=plugins&s=show&id=<?= $_GET['id'] ?>&spl=6">Entfernen</a></li>
    </ul>
</div>
<div class="clearfix"></div>

<?php
if (isset($_GET['spl']))
    switch ($_GET['spl']):
        case '1':
            if (isset($_POST['dl'])) {
                $dlcmd = "mkdir -p /var/bukkit/ && cd /var/bukkit/ && rm craftbukkit.jar -f && wget -q http://dl.bukkit.org/latest-rb/craftbukkit.jar && echo 'Aktion abgeschlossen.'";
                $info = $server->execute($dlcmd);
            }

            if (isset($_POST['script'])) {
                if (is_numeric($_POST['mem'])) {
                    if (isset($_POST['onlinemode'])) {
                        $script = '
#!/bin/sh
BINDIR=\$(dirname \"\$(readlink -fn \"\$0\")\")
cd \"\$BINDIR\"
java -Xms' . $_POST['mem'] . 'M -Xmx' . $_POST['mem'] . 'M -jar craftbukkit.jar -o true
';
                    } else {
                        $script =
                                '#!/bin/sh
BINDIR=\$(dirname \"\$(readlink -fn \"\$0\")\")
cd \"\$BINDIR\"
java -Xms' . $_POST['mem'] . 'M -Xmx' . $_POST['mem'] . 'M -jar craftbukkit.jar -o false
';
                    }
                    $scriptcmd = 'touch /var/bukkit/startmc.sh && echo -ne "' . $script . '" > /var/bukkit/startmc.sh && chmod 777 /var/bukkit/startmc.sh && echo "Aktion abgeschlossen."';
                    $info = $server->execute($scriptcmd);
                } else {
                    echo '<span class="error">Die Größe muss eine ganze Zahl sein.</span>';
                }
            }
            ?>
            <h5>Installation</h5>
            <? if (isset($_POST['script']) || isset($_POST['dl'])): ?>
                <span class="info">
                    <code><?= $info ?></code>    
                </span>
            <? endif; ?>    
            <div class="halbe-box"> 
                <fieldset>
                    <form action="?p=plugins&s=show&id=<?= $_GET['id'] ?>&spl=1" method="post">
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
                    <form action="?p=plugins&s=show&id=<?= $_GET['id'] ?>&spl=1" method="post">
                        <p>
                            Damit der Bukkit gestartet werden kann, muss ein Startskript her. Dieses wird hiermit automatisch erstellt.
                            Sollte es bereits existieren, wird es hiermit überschrieben.
                        </p>
                        <p>
                            <b>Arbeitsspeicher für Java (in MB)</b><br>
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
            <?php
            break;
        case '2':
            if (isset($_POST['start']))
                $server->execute('cd /var/bukkit/ && screen -AmdS minecraft ./startmc.sh');
            if (isset($_POST['stop']))
                $server->execute('screen -S minecraft -p 0 -X stuff "`printf "stop\r"`";');
            if (isset($_POST['cmda']))
                $server->execute('screen -S minecraft -p 0 -X stuff "`printf "' . $_POST['cmd'] . '\r"`";');
            ?>
            <h5>Steuerung</h5>
            <span class="error">
                Das Starten geht noch nicht, hier treten mysteriöse Probleme auf.<br>Sollten man hiermit einen Server starten, bekommt man einen "toten" Screen.<br>
                Befehl zum Beenden: <code>screen -wipe</code>.
            </span>
            <fieldset>
                <form action="?p=plugins&s=show&id=<?= $_GET['id'] ?>&spl=2" method="post">
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
            <?php
            break;
        case '3':
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
                        Adresse: <code><?= $ip . ":" . $port ?></code>
                        <br><br>
                        Ihr Minecraft-Server ist <b><?= $status ?></b>.
                    </p>
                </fieldset>
            </div>
            <div class="halbe-box lastbox">
                <fieldset>
                    <p>Wenn der Server nicht den Port 25565 nutzt, kann hier ein anderer Port angegeben werden.</p>
                    <form action="?p=plugins&s=show&id=<?= $_GET['id'] ?>&spl=3" method="post">
                        <input type="text" name="port" id="" class="text-small" placeholder="Port">
                        <input type="submit" value="ok" class="button green">
                    </form>
                </fieldset>
            </div>

            <?php
            break;
        case '4':

            $log = $server->execute('cat /var/bukkit/server.log');
            $logf = explode("\n", $log);

            function highlightLog($logline) {
                $logline = explode("\n", (wordwrap($logline, 10, "\n", false)));
                if (isset($logline[0])) {
                    $logline[0] = '<span style="color:#00008F; font-weight: bold;">' . $logline[0] . '</span>';
                }
                if (isset($logline[1])) {
                    $logline[1] = '<span style="color:#9D0077; font-weight: bold;">' . $logline[1] . '</span>';
                }
                return implode(" ", $logline);
            }
            ?>
            <h3>Server.log</h3>
            <ul id="logline" class="log">
                <?php
                foreach ($logf as $value) {
                    echo "<li>" . highlightLog($value) . "</li>\n";
                }
                ?>
            </ul>
            <?php
            break;
        case '5':

            if (isset($_POST['ipb']))
                $server->execute('echo "' . $_POST['ipb'] . '" >> /var/bukkit/banned-ips.txt');
            if (isset($_POST['usb']))
                $server->execute('echo "' . $_POST['usb'] . '" >> /var/bukkit/banned-players.txt');
            if (isset($_POST['usw']))
                $server->execute('echo "' . $_POST['usw'] . '" >> /var/bukkit/white-list.txt');
            if (isset($_POST['uso']))
                $server->execute('echo "' . $_POST['uso'] . '" >> /var/bukkit/ops.txt');
            if (isset($_POST['prop']))
                $server->execute('echo "' . $_POST['prop'] . '" > /var/bukkit/server.properties');
            ?>
            <h5>Einstellungen</h5>
            <form action="?p=plugins&s=show&id=<?= $_GET['id'] ?>&spl=5" method="post">
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
<?
$data = $server->execute('cat /var/bukkit/server.properties');
$arrd = explode("\n", $data);
foreach ($arrd as $value) {
echo trim($value) . "\n";
}
?>      
                        </textarea>
                        <div class="clearfix"></div><br>


                    <? endif; ?>
                    <input type="submit" value="durchführen" class="button black">
                </fieldset>
            </form>
            <?php
            break;
        case '6':
            if (isset($_POST[''])) {
                $server->execute('rm -r /var/bukkit');
            }
            ?>
            <h5>Minecraft löschen</h5>
            <p>
                Diese Aktion löscht den vollständigen Bukkit-Server.
            </p>
            <form action="?p=plugins&s=show&id=<?= $_GET['id'] ?>&spl=6" method="post">
                <input type="submit" name="del" value="Bukkit löschen" class="button pink">
            </form>
            <?php
            break;
        default:
            ?>
            <div class="boxcenter">
                <img src="src="data:image/jpg;base64,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"" style="float:right;width:90px;heigt:90px;">
                <h1>Willkommen im SAS Minecraft Plugin</h1>
                <p>Nutzen Sie die Tabs um zu den jeweiligen Funktionen zu kommen</p>
                <br>
            </div>
            <p><i>sas-mc-plugin v1.0 </i>- programmiert von <a href="https://github.com/GabrielWanzek">Gabriel Wanzek</a></p>
            <?php
            break;

    endswitch; else {
    ?>
    <div class="boxcenter">
        <img src="http://i.imgur.com/GiCD3X6.png" style="float:right;width:90px;heigt:90px;">
        <h1>Willkommen im SAS Minecraft Plugin</h1>
        <p>Nutzen Sie die Tabs um zu den jeweiligen Funktionen zu kommen</p>
        <br>
    </div>
    <p><i>sas-mc-plugin v1.0 </i>- programmiert von <a href="https://github.com/GabrielWanzek">Gabriel Wanzek</a></p>
    <?php
}
?>