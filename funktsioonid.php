<?php
require ('conf.php');
global $yhendus;

// +1 punkt
function lisapunkt($id){
    global $yhendus;
        $paring = $yhendus->prepare("UPDATE valimised SET punktid = punktid + 1 WHERE id = ?");
        $paring->bind_param("i", $id);
        $paring->execute();
        $yhendus->close();

}

function naitatabel()
{
    global $yhendus;
    $paring = $yhendus->prepare("Select id, president, pilt, punktid, lisamisaeg, kommentaarid from valimised where avalik=1");
    $paring->bind_result($id, $president, $pilt, $punktid, $lisamisaeg, $kommentaarid);
    $paring->execute();
    while($paring->fetch()) {
        echo "<tr>";
        echo "<td>{$president}</td>";
        echo "<td>{$punktid}</td>";
        echo "<td><a href='?lisa1punkt={$id}'> +1 punkt</a></td>";
        echo "<td><a href='?minus1punkt={$id}'> -1 punkt</a></td>";
        echo "</tr>";
        }
}