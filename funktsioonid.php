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
    $paring = $yhendus->prepare("Select id, president, pilt, punktid, lisamisaeg, kommentaarid from valimised where avalik=1 or avalik=0");
    $paring->bind_result($id, $president, $pilt, $punktid, $lisamisaeg, $kommentaarid);
    $paring->execute();
    while($paring->fetch()) {
        echo "<tr>";
        echo "<td>{$president}</td>";
        echo "<td>{$punktid}</td>";
        echo "<td><a href='?lisa1punkt={$id}'> +1 punkt</a></td>";
        echo "<td><a href='?minus1punkt={$id}'> -1 punkt</a></td>";
        echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";
        echo "<td>
                <form method='POST' action=''>
                    <input type='hidden' name='uue_komment_id' value='{$id}'>
                    <input type='text' name='uus_kommentaar' placeholder='Lisa kommentaar'>
                    <input type='submit' value='OK'>
                </form>
              </td>";
        echo "<td><a href='?kustuta={$id}'> Kustuta</a></td>";
        echo "</tr>";
        }
}
// uue presidenti lisamine - INSERT
function lisaPresident($presidentNimi, $pilt, $punktid){
    global $yhendus;
    $paring = $yhendus->prepare("insert into valimised (president, pilt, punktid, lisamisaeg) values (?, ?, ?, NOW())");
    $paring->bind_param("ssi", $presidentNimi, $pilt, $punktid);
    $paring->execute();
    $yhendus->close();
}

//kustutamine
function kustutaPresident($id){
    global $yhendus;
    $paring = $yhendus->prepare("delete from valimised where id=?");
    $paring->bind_param("i", $id);
    $paring->execute();
    $yhendus->close();
}

//miinus punkt
function miinuspunkt($id){
    global $yhendus;
        $paring = $yhendus->prepare("UPDATE valimised SET punktid = punktid - 1 WHERE id = ?");
        $paring->bind_param("i", $id);
        $paring->execute();

}

// kommentaari lisamine - UPDATE
function kommentaarlisamine($kommentaar, $id){
    global $yhendus;
    $paring = $yhendus->prepare(
        "UPDATE valimised SET kommentaarid = CONCAT(kommentaarid, ?) WHERE id = ?");
    $kommentaar .= "\n";
    $paring->bind_param("si", $kommentaar, $id);
    $paring->execute();
}
