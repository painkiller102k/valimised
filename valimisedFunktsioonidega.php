<?php
require("funktsioonid.php");
// päringud funktsioonide otsimiseks failis funktsioonid.php
if(isset($_REQUEST['lisa1punkt'])){
    lisapunkt($_REQUEST['lisa1punkt']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// päring lisaPresident funktsioon otsimiseks
if(isset($_REQUEST['presidentNimi']) && !empty($_REQUEST['presidentNimi'])){
    lisaPresident($_REQUEST['presidentNimi'], $_REQUEST['pilt']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tabel Valimised funktsioonidega</title>
</head>
<body>
<h1>Tabel Valimised kirjutatud funktsioonide abil</h1>
<table>
    <tr>
        <th>President nimi</th>
        <th>Punktid</th>
        <th>+1 punkt</th>
        <th>-1 punkt</th>
    </tr>
    <?php
    // funktsioon mis näitab tabeli asub funktsioonid.php failis
    naitatabel();
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
