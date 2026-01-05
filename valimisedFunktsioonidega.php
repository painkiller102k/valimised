<?php
require("funktsioonid.php");
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
</body>
</html>
