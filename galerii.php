<?php
require ("conf.php");

// +1 punkt
global $yhendus;
if (isset($_REQUEST['lisa1punkt'])) {
    $paring = $yhendus->prepare("UPDATE valimised SET punktid = punktid + 1 WHERE id = ?");
    $paring->bind_param("i", $_REQUEST['lisa1punkt']);
    $paring->execute();
    header("Location: galerii.php?vaata=".$_REQUEST['lisa1punkt']);
}

// -1 punkt
if (isset($_REQUEST['minus1punkt'])) {
    $paring = $yhendus->prepare("UPDATE valimised SET punktid = punktid - 1 WHERE id = ?");
    $paring->bind_param("i", $_REQUEST['minus1punkt']);
    $paring->execute();
    header("Location: galerii.php?vaata=".$_REQUEST['minus1punkt']);
}

// kommentaari lisamine
if (isset($_REQUEST['uue_komment_id'])) {
    $paring = $yhendus->prepare("UPDATE valimised SET kommentaarid=CONCAT(kommentaarid, ?) WHERE id = ?");
    $komment2 = $_REQUEST['uus_kommentaar']."\n";
    $paring->bind_param("si", $komment2, $_REQUEST['uue_komment_id']);
    $paring->execute();
    header("Location: galerii.php?vaata=".$_REQUEST['uue_komment_id']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Galerii leht</title>
    <link rel="stylesheet" href="galeriiStyle.css">
</head>
<body>

<h1>Presidendi Galerii</h1>
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
<div class="galerii">
    <?php
    global $yhendus;
    $paring = $yhendus->prepare("SELECT id, president, pilt FROM valimised WHERE avalik=1");
    $paring->bind_result($id, $president, $pilt);
    $paring->execute();

    while ($paring->fetch()) {
        echo "<a href='galerii.php?vaata=$id'>
                <img src='$pilt.png' alt='pilt'>
              </a>";
    }
    ?>
</div>

<?php
if (isset($_REQUEST['vaata'])) {
    $paring = $yhendus->prepare("SELECT id, president, pilt, punktid, lisamisaeg, kommentaarid FROM valimised WHERE id = ?");
    $paring->bind_param("i", $_REQUEST['vaata']);
    $paring->bind_result($id, $president, $pilt, $punktid, $lisamisaeg, $kommentaarid);
    $paring->execute();
    if ($paring->fetch()) {

        echo "<div class='infoBlokk'>
                <h2>$president</h2>
                <img src='$pilt.png' class='infopilt'>
                <p><b>Punktid:</b> $punktid</p>
                <p><b>Lisatud:</b> $lisamisaeg</p>
                <p><b>Kommentaarid:</b><br>".nl2br(htmlspecialchars($kommentaarid))."</p>
                <p>
                    <a href='?lisa1punkt=$id'>+1 punkt</a> |
                    <a href='?minus1punkt=$id'>-1 punkt</a>
                </p>
                <form action='?' method='POST'>
                    <input type='hidden' name='uue_komment_id' value='$id'>
                    <label for='uus_kommentaar'>Lisa kommentaar:</label>
                    <input type='text' name='uus_kommentaar' id='uus_kommentaar'>
                    <input type='submit' value='ok'>
                </form>
              </div>";
    }
}
?>
</body>
</html>
