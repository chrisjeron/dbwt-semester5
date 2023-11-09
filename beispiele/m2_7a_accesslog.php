<?php
/**
 * Praktikum DBWT. Autoren:
 * Doehm, Patrick, 3532447
 * Jeron, Christoph, 3537624
 */


$ip = $_SERVER['REMOTE_ADDR'];
$zeitpunkt = date('Y-m-d H:i:s');
$webbrowser = $_SERVER['HTTP_USER_AGENT'];

$eintrag = "Zeitpunkt: $zeitpunkt ----- IP: $ip ------ Webbrowser: $webbrowser" . PHP_EOL;

$file = fopen("accesslog.txt", 'a');
fwrite($file, $eintrag);
fclose($file);




