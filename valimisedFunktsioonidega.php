<?php
require("funktsioonid.php");

// päring funktsioonid kustuta
if(isset($_REQUEST['kustuta'])){
    kustutaPresident($_REQUEST['kustuta']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// päringud funktsioonide otsimiseks failis funktsioonid.php
if(isset($_REQUEST['lisa1punkt'])){
    lisapunkt($_REQUEST['lisa1punkt']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// päring lisaPresident funktsioon otsimiseks
if(!empty($_REQUEST['presidentNimi'])){
    lisaPresident($_REQUEST['presidentNimi'], $_REQUEST['pilt'], $_REQUEST['punktid']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// -punkt funktsioon
if(isset($_REQUEST['minus1punkt'])){
    miinuspunkt($_REQUEST['minus1punkt']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// kommentaari lisamise päring
if (isset($_REQUEST['uue_komment_id']) && !empty($_REQUEST['uus_kommentaar'])) {
    kommentaarlisamine($_REQUEST['uus_kommentaar'], $_REQUEST['uue_komment_id']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// näita
if (isset($_REQUEST['naita'])) {
    naitaPresident($_REQUEST['naita']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// peida
if (isset($_REQUEST['peida'])) {
    peidaPresident($_REQUEST['peida']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// punktid nulliks
if (isset($_REQUEST['nulliks'])) {
    punktidNulliks($_REQUEST['nulliks']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tabel Valimised funktsioonidega</title>
    <link rel="stylesheet" href="valimisedStyle.css">
</head>
<body>
<h1>Tabel Valimised kirjutatud funktsioonide abil</h1>

<table>
    <tr>
        <th>President nimi</th>
        <th>Punktid</th>
        <th>+1 punkt</th>
        <th>-1 punkt</th>
        <th>Kommentaar</th>
        <th>Lisa kommentaar</th>
        <th>Punktid nulliks</th>
        <th>Näita / Peida</th>
        <th>Status</th>
        <th>Kustuta</th>
    </tr>

    <?php
    // funktsioon mis näitab tabeli asub funktsioonid.php failis
    naitatabel();
    ?>
</table>

<h2>Lisa oma presidendi</h2>
<form action="" method="GET">
    <label for="presidentNimi">President nimi : </label>
    <input type="text" name="presidentNimi" id="presidentNimi">
    <br>
    <label for="pilt">President pilt : </label>
    <textarea name="pilt" id="pilt"></textarea>
    <br>
    <label for="punktid">Punktid : </label>
    <input type="number" name="punktid" id="punktid">
    <br>
    <input type="submit" value="Lisa">
</form>

</body>
</html>
