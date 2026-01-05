<?php
$serverinimi='localhost';
$kasutajanimi='martinrossakov';
$parool='1982';
$andmebaasinimi='martinrossakov';
$yhendus=new mysqli($serverinimi, $kasutajanimi, $parool, $andmebaasinimi);
$yhendus->set_charset("utf8");






//// zone.ee kasutaja
//$serverinimi='d141142.mysql.zonevs.eu';
//$kasutajanimi='d141142_martin';
//$parool='Rosmartin0688';
//$andmebaasinimi='d141142_martinrossakov';
//$yhendus=new mysqli($serverinimi, $kasutajanimi, $parool, $andmebaasinimi);
//$yhendus->set_charset("utf8");