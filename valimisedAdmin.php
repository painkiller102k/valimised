<?php
require ('conf.php');
//+1 punkt
global $yhendus;
if (isset($_REQUEST['lisa1punkt'])) {
    $paring = $yhendus->prepare("UPDATE valimised SET punktid = punktid + 1 WHERE id = ?");
    $paring->bind_param("i", $_REQUEST['lisa1punkt']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']); // aadressiriba puhastab päring ja jääb failinimi
}

//-1 punkt
if (isset($_REQUEST['minus1punkt'])) {
    $paring = $yhendus->prepare("UPDATE valimised SET punktid = punktid - 1 WHERE id = ?");
    $paring->bind_param("i", $_REQUEST['minus1punkt']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']); // aadressiriba puhastab päring ja jääb failinimi
}

//lisamine admetabelisse
if (isset($_REQUEST['presidentNimi']) && !empty($_REQUEST['presidentNimi'])) {

    $paring = $yhendus->prepare(
        "INSERT INTO valimised (president, pilt, lisamisaeg, avalik) VALUES (?, ?, NOW(), ?)");

    $paring->bind_param("ssi", $_REQUEST['presidentNimi'], $_REQUEST['pilt'], $_REQUEST['avalik']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    $yhendus->close();
}

//näitamine
if (isset($_REQUEST['naita'])) {
    $paring = $yhendus->prepare("UPDATE valimised SET avalik=1 where id = ?");
    $paring->bind_param("i", $_REQUEST['naita']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']); // aadressiriba puhastab päring ja jääb failinimi
    $yhendus->close();
}

//peida
if (isset($_REQUEST['peida'])) {
    $paring = $yhendus->prepare("UPDATE valimised SET avalik=0 where id = ?");
    $paring->bind_param("i", $_REQUEST['peida']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']); // aadressiriba puhastab päring ja jääb failinimi
    $yhendus->close();
}

//kustuta
if (isset($_REQUEST["kustutusid"])) {

    $kask = $yhendus->prepare(
        "DELETE FROM valimised WHERE id=?"
    );
    $kask->bind_param("i", $_REQUEST["kustutusid"]);
    $kask->execute();
}

//nulliks
if (isset($_REQUEST['nulliks'])) {

    $paring = $yhendus->prepare("UPDATE valimised SET punktid = 0 where id=?");
    $paring->bind_param("i", $_REQUEST['nulliks']);
    $paring->execute();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

//kustuta komment - update
if (isset($_REQUEST['kommentaarid_nuliks'])) {

    $paring = $yhendus->prepare("UPDATE valimised SET kommentaarid ='' where id=?");
    $paring->bind_param("i", $_REQUEST['kommentaarid_nuliks']);
    $paring->execute();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin leht</title>
    <link rel="stylesheet" href="valimisedStyle.css">
</head>
<body>
<h1>TARpv24 presidendi valimised</h1>
<nav>
    <ul>
        <li>
            <a href="valimised.php">Kasutaja leht</a>
        </li>
        <li>
            <a href="valimisedAdmin.php">Admin leht</a>
        </li>
        <li>
            <a href="galerii.php">Galerii leht</a>
        </li>
    </ul>
</nav>
<table>
    <tr>
        <th>President nimi</th>
        <th>Pilt</th>
        <th>Punktid</th>
        <th>Lisamis aeg</th>
        <th>Kommentaar</th>
        <th>Kustuta President</th>
        <th>Kustuta Kommentaarid</th>
        <th>Punktid nulliks</th>
        <th>Haldus</th>
        <th>Status</th>
    </tr>
    <?php
    global $yhendus;
    $paring = $yhendus->prepare("Select id, president, pilt, punktid, lisamisaeg, avalik, kommentaarid  from valimised");
    $paring->bind_result($id, $president, $pilt, $punktid, $lisamisaeg, $avalik, $kommentaarid);
    $paring->execute();
    while($paring->fetch()){
        echo "<tr>";
        echo "<td>".$president."</td>";
        echo "<td><img src='$pilt.png' alt='pilt'></td>";
        echo "<td>".$punktid."</td>";
        echo "<td>".$lisamisaeg."</td>";
        echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";
        echo "<td><a href='?kustutusid=$id'> Kustuta President</a></td>";
        echo "<td><a href='?kommentaarid_nuliks=$id'> Kustuta Kommentaar</a></td>";
        echo "<td><a href='?nulliks=$id'>Kõik punktid nulliks</a></td>";
        $tekst = "Näita";
        $seisund = "naita";
        $tekstLehel = "Peidetud";

        if ($avalik == 1) {
            $tekstLehel = "Näidatud";
            $seisund = 'peida';
            $tekst = 'Peida';
        }

        echo "<td><a href='?$seisund=$id'>$tekst</a></td>";
        echo "<td>$tekstLehel</td>";
        echo "</tr>";

    }
    ?>
</table>
<h2>Lisa oma presidendi</h2>
<form action="">
    <label for="presidentNimi">President nimi : </label>
    <input type="text" name="presidentNimi" id="presidentNimi">
    <br>
    <label for="presidentNimi">President pilt : </label>
    <textarea name="pilt" id="pilt"></textarea>
    <br>
    <label for="presidentNimi">Avalik : </label>
    <label for="avalik"></label>
    <input type="checkbox" name="avalik" id="avalik" value="1">
    <input type="submit" value="Lisa">
</form>
</body>
</html>