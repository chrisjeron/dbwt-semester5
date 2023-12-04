<!--
- Praktikum DBWT. Autoren:
- Doehm, Patrick, 3532447
- Jeron, Christoph, 3537624
-->
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>E-Mensa</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<!-- Navigation-->
<div class="top">
    <img class="logo" src="logo-FH.png" alt="FHAachenLogo">
    <div class="Navigation">
        <ul class="LiNav">
            <li><a href="#ankerAnkuendigung"> Ank&#252;ndigung </a></li>
            <li><a href="#ankerTabelle">Speisen </a> </li>
            <li><a href="#ankerZahlen"> Zahlen </a> </li>
            <li><a href="#ankerKontakt"> Kontakt </a> </li>
            <li><a href="#ankerWichtig">Wichtig f&#252;r uns </a> </li>
        </ul>
    </div>
</div>

<hr>
<a href="/werbeseite/wunschgerichte.php" id="wunschlink">Wunschgericht melden</a>
<!-- Essen Online + Text -->
<div class="Ankuendigung">
    <h1 id="ankerAnkuendigung">Bald gibt es auch Essen online ;) </h1>
    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
</div>

<!-- Speisekarten Tabelle -->
<div class="Speisen">
    <h1 id="ankerTabelle">K&#246;stlichkeiten die Sie erwarten</h1>
    <table class="tabelle">
        <tbody>
        <tr>
            <th></th>
            <th>Preis intern</th>
            <th>Preis extern</th>
        </tr>

        <!-- TABELLE aus Praktikum M2 mit externer Gerichte.php -->
        <?php
        include('Gerichte.php');
        foreach ($gerichte as $gericht) {
            echo '<tr>';
            echo '<td>' . $gericht['name'] . '</td>';
            echo '<td>' . $gericht['preis_intern'] . '</td>';
            echo '<td>' . $gericht['preis_extern'] . '</td>';
            echo '<td>' . $gericht['bild'] . '</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>

<br><br>

<!-- TABELLE aus Praktikum M3 mit Datenbank -->
<table class="tabelle">
    <tbody>
    <?php
    $link = mysqli_connect(
        "localhost",
        "root",
        "1234",
        "emensawerbeseite"
    );

    // GROUP_CONCAT (https://stackoverflow.com/questions/276927/can-i-concatenate-multiple-mysql-rows-into-one-field/276949#276949)
    $sql = "SELECT g.name, g.preisintern, g.preisextern, GROUP_CONCAT(a.code) AS Allergene, GROUP_CONCAT(a.name) AS AllergenName
                FROM gericht g
                LEFT JOIN gericht_hat_allergen ga ON g.id = ga.gericht_id
                LEFT JOIN allergen a ON ga.code = a.code
                GROUP BY g.name
                ORDER BY g.name
                LIMIT 5;";

    $result = mysqli_query($link, $sql);

    $verwendeteAllergene = []; // Array für die gesammelten AllergenCodes + AllergenNamen zur Ausgabe unter der Tabelle

    echo '<table>';
    echo '<tr><th>Name</th><th>Preis intern</th><th>Preis extern</th><th>Allergene</th></tr>';
    while ($row = mysqli_fetch_assoc($result)) {

        if ($row['Allergene'] !== null) { // Überprüfen, ob es Allergen gibt und Wert nicht NULL ist
            $allergeneCodeArray = explode(',', $row['Allergene']); // Array der Allergen-Codes für ein Gericht
            $allergeneNameArray = explode(',', $row['AllergenName']); // Array der Allergen-Namen für ein Gericht
        }

        foreach ($allergeneCodeArray as $zaehler => $code) {
            $allergen = $allergeneNameArray[$zaehler];
            $Allergenpaar = "$code = $allergen"; //Allergenpaar für Ausgabe unter Tabelle erstellen
            if (!in_array($Allergenpaar, $verwendeteAllergene)) {
                $verwendeteAllergene[] = $Allergenpaar; //wenn Allergenpaar nicht im Array vorhanden, füge es hinzu
            }
        }

        echo '<tr>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['preisintern'] . '</td>';
        echo '<td>' . $row['preisextern'] . '</td>';
        echo '<td>' . $row['Allergene'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';

    mysqli_close($link);

    // Allergene unter der Tabelle ausgeben
    echo "<div class='allergenemittig'>";
    echo "<ul style='list-style-type: none'>";
    foreach ($verwendeteAllergene as $allergen) {
        echo "<li>" . $allergen . "</li>"; // Ausgabe der gespeicherten Allergenpaare in einer Liste
    }
    echo "</ul>";
    echo "</div>";
    ?>
    </tbody>
</table>


<?php
// Verbindung zur Datenbank herstellen
$conn = mysqli_connect(
    "localhost",
    "root",
    "1234",
    "emensawerbeseite"
);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// IP-Adresse des Besuchers
$ip = $_SERVER['REMOTE_ADDR'];

// Überprüfen, ob die IP bereits in der Datenbank vorhanden ist
$sqlCheckIP = "SELECT * FROM besucherzaehler WHERE ip = '$ip'";
$resultCheckIP = $conn->query($sqlCheckIP);

if ($resultCheckIP->num_rows == 0) {
    // Neue IP, daher einen neuen Besucher zählen
    $sqlInsert = "INSERT INTO besucherzaehler (besucherzahl, ip) VALUES (1, '$ip')";
    $conn->query($sqlInsert);
} else {
    // Die IP ist bereits in der Datenbank, erhöhe die Besucherzahl
    $sqlUpdate = "UPDATE besucherzaehler SET besucherzahl = besucherzahl + 1 WHERE ip = '$ip'";
    $conn->query($sqlUpdate);
}

// Aktuelle Besucherzahl aus der Datenbank abrufen
$sqlGetVisits = "SELECT besucherzahl FROM besucherzaehler";
$resultGetVisits = $conn->query($sqlGetVisits);

if ($resultGetVisits->num_rows > 0) {
    $row = $resultGetVisits->fetch_assoc();
    $besucherzahl = $row['besucherzahl'];
} else {
    $besucherzahl = 0;
}

// Datenbankverbindung schließen
$conn->close();
?>

<!-- E-Mensa in Zahlen -->
<div class="EMensaInZahlen">
    <h1 id="ankerZahlen">E-Mensa in Zahlen</h1>

    <ul class="Zahlen">
        <?php
        // Stellen Sie sicher, dass die Variable $besucherzahl definiert ist
        if (isset($besucherzahl)) {
            echo '<li>' . $besucherzahl . ' Besucher auf dieser Seite</li>';
        } else {
            echo '<li>Die Besucherzahl ist nicht verfügbar</li>';
        }
        ?>


        <li><?php echo count(file("newsletter_data.txt")) ?> Anmeldungen zum Newsletter</li>

        <li>
            <?php
            $link = mysqli_connect( //Verbindung zur Datenbank für PHP Code
                "localhost",
                "root",
                "1234",
                "emensawerbeseite"
            );

            //Zählen der rows
            $sql_count_gerichte = "SELECT COUNT(*) as gerichte_count FROM gericht;"; //Zähle jeden Eintrag in gerichte der Datenbank
            $result_count_gerichte = mysqli_query($link, $sql_count_gerichte);
            $row_count_gerichte = mysqli_fetch_assoc($result_count_gerichte);
            $gerichte_count = $row_count_gerichte['gerichte_count'];

            //Anzahl Gerichte ausgeben
            echo "<div class='gerichte-count'>";
            echo "Anzahl der Gerichte: " . $gerichte_count;
            echo "</div>";
            ?></li>
    </ul>
</div>

<!-- Newsletter Anmeldung -->
<div class="NewsletterAnmeldung">
    <h1>Interesse geweckt? Wir informieren Sie!</h1>
    <form method="post" action="werbeseite.php">
        <label class="labels" for="vname">Vorname:</label>
        <input class="inputs" type="text" id="vname" name="vname" required>

        <label class="labels" for="email">E-Mail:</label>
        <input class="inputs"  type="text" id="email" name="email" required>

        <label class="labels" for="dropdown"> Benachrichtigungsintervall: </label>
        <select class="inputs"  name="AuswahlBox" id="dropdown" required>
            <option> Tag </option>
            <option> Woche </option>
            <option> Monat </option>
        </select>

        <label class="labels" id="letzelabel" for="datenschutz">Den Datenschutzbestimmungen stimme ich zu</label>
        <input class="inputs"  type="checkbox" id="datenschutz" name="Datenschutzbestätigung" required="">

        <input class="inputs"  type="submit" value="Zum Newsletter anmelden">
    </form>

    <?php
    if (isset($_POST['vname'])) {
        echo "zeile123";
        $vname = $_POST['vname'];
        $email = $_POST['email'];
        $datenschutz = $_POST['Datenschutzbestätigung'];
        $auswahl = $_POST['AuswahlBox'];

        if (!empty($vname) && $datenschutz && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $data = "Vorname: $vname, E-Mail: $email, Benachrichtigungsintervall: $auswahl\n";
            $file = fopen('newsletter_data.txt', "a");

            if ($file) {
                fwrite($file, $data);
                fclose($file);
                echo 'Anmeldung erfolgreich!';
            } else {
                echo 'Es ist ein Fehler beim Öffnen der Datei aufgetreten.';
            }
        } else {
            echo 'Es ist ein Fehler aufgetreten. Bitte überprüfen Sie Ihre Eingaben.';
        }
        header("Location: werbeseite.php");
    }
    ?>
</div>

<!-- Das ist uns wichtig -->
<div class="DasIstUnsWichtig">
    <h1 id="ankerWichtig">Das ist uns wichtig</h1>
    <ul class="unswichtig">
        <li>Beste frische Saisonale Zutaten</li> <br>
        <li>Ausgewogene Abwechslunsgreiche Gerichte</li> <br>
        <li>Sauberkeit</li>
    </ul>
</div>

</body>

<footer>
    <!-- Footer Navigation -->
    <h1 id="ankerKontakt">Wir freuen uns auf ihren Besuch!</h1>
    <hr>
    <ul class="FooterNav">
        <li>©E-Mensa GmbH</li>
        <li>Chris Jeron, Patrick Doehm</li>
        <li><a href="impressum.html">Impressum</a></li>
    </ul>
</footer>

</html>
