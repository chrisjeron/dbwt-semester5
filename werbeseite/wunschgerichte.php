<!--
- Praktikum DBWT. Autoren:
- Doehm, Patrick, 3532447
- Jeron, Christoph, 3537624
-->

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Wunschgericht melden</title>
</head>

<body>
<h1>Wunschgericht melden</h1>

<!-- Formular zur Erfassung eines Wunschgerichts -->
<form method="post" action="werbeseite.php">
    <label for="name">Ihr Name:</label>
    <input type="text" id="name" name="name">

    <label for="email">Ihre E-Mail:</label>
    <input type="email" id="email" name="email">

    <label for="gericht_name">Name des Wunschgerichts:</label>
    <input type="text" id="gericht_name" name="gericht_name" required>

    <label for="beschreibung">Beschreibung:</label>
    <textarea id="beschreibung" name="beschreibung" rows="4" required></textarea>

    <input type="submit" value="Wunsch abschicken">
</form>

</body>

</html>

<?php
$connection = mysqli_connect(
    "localhost",
    "root",
    "1234",
    "emensawerbeseite"
);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = ($_POST["name"]) ? : "anonym";
    $email = ($_POST["email"]) ? : "";
    $gerichtName = $_POST["gericht_name"];
    $beschreibung = $_POST["beschreibung"];


    $sql = "INSERT INTO wunschgericht (Name, Beschreibung, Erstellungsdatum)
            VALUES ('$gerichtName', '$beschreibung', NOW())
            
            INSERT INTO ersteller (Name, E-Mail)
            VALUES ('$name', '$email')";

    mysqli_query($connection, $sql);
}
mysqli_close($connection);
?>