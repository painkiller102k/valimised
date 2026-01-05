<?php
require ('conf.php');
global $yhendus;

// +1 punkt
function lisapunkt($id){
    global $yhendus;
        $paring = $yhendus->prepare("UPDATE valimised SET punktid = punktid + 1 WHERE id = ?");
        $paring->bind_param("i", $id);
        $paring->execute();
        header("Location: " . $_SERVER['PHP_SELF']); // aadressiriba puhastab päring ja jääb failinimi
        $yhendus->close();

}