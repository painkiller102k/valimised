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
global $yhendus;
if (isset($_REQUEST['minus1punkt'])) {
    $paring = $yhendus->prepare("UPDATE valimised SET punktid = punktid - 1 WHERE id = ?");
    $paring->bind_param("i", $_REQUEST['minus1punkt']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']); // aadressiriba puhastab päring ja jääb failinimi
}

//lisamine admetabelisse
if(isset($_REQUEST['presidentNimi']) && !empty($_REQUEST['presidentNimi'])){
    global $yhendus;
    $paring = $yhendus->prepare("insert into valimised (president, pilt, lisamisaeg) values (?, ?, NOW())");
    $paring->bind_param("ss", $_REQUEST['presidentNimi'], $_REQUEST['pilt']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']); // aadressiriba puhastab päring ja jääb failinimi
    $yhendus->close();
}
// kommentaari lisamine - update
global $yhendus;
if (isset($_REQUEST['uue_komment_id'])) {
    $paring = $yhendus->prepare("UPDATE valimised SET kommentaarid=CONCAT(kommentaarid, ?) WHERE id = ?");
    $komment2 = $_REQUEST['uus_kommentaar']."\n";
    $paring->bind_param("si", $komment2,$_REQUEST['uue_komment_id']);
    $paring->execute();
    header("Location: " . $_SERVER['PHP_SELF']);
    $yhendus->close();
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <title>Valimiste leht</title>
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
        <th>Lisamisaeg</th>
        <th>+1 punkt</th>
        <th>-1 punkt</th>
        <th>Kommentaarid</th>
    </tr>
    <?php
    global $yhendus;
    $paring = $yhendus->prepare("Select id, president, pilt, punktid, lisamisaeg, kommentaarid from valimised where avalik=1");
    $paring->bind_result($id, $president, $pilt, $punktid, $lisamisaeg, $kommentaarid);
    $paring->execute();
    while($paring->fetch()){
        echo "<tr>";
        echo "<td>".$president."</td>";
        echo "<td><img src='$pilt.png' alt='pilt'></td>";
        echo "<td>".$punktid."</td>";
        echo "<td>".$lisamisaeg."</td>";
        echo "<td><a href='?lisa1punkt=$id'> +1 punkt</a></td>";
        echo "<td><a href='?minus1punkt=$id'> -1 punkt</a></td>";
        echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";
        echo "<td>
<form action='?' method='POST'>
<input type='hidden' name='uue_komment_id' value='$id'>
<label for='uue_komment_id'>Kommentaarid</label>
<input type='text' name='uus_kommentaar' id='uus_kommentaar'>
<input type='submit' value='ok'>
</form></td>";
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
    <input type="submit" value="Lisa">
</form>



</body>
</html>