<?php
/**
 * Praktikum DBWT. Autoren:
 * Doehm, Patrick, 3532447
 * Jeron, Christoph, 3537624
 */

$link = mysqli_connect(
    "localhost",
    "root",
    "1234",
    "emensawerbeseite"
);

if (!$link) {
    echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
    exit();
}


$sql = "SELECT * FROM gericht";
$result = mysqli_query($link, $sql);

if ($result) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Beschreibung</th></tr>";

    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["beschreibung"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "Abfrage fehlgeschlagen.";
}

mysqli_free_result($result);
mysqli_close($link);