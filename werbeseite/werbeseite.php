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

<!-- Essne Online + Text -->

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


<!-- E-Mensa in Zahlen -->

    <div class="EMensaInZahlen">
        <h1 id="ankerZahlen">E-Mensa in Zahlen</h1>

        <ul class="Zahlen">
            <?php
            $counter_file = "counter.txt"; // Datei für Besucheranzahl

            if (file_exists($counter_file)) {
                $counter = (int)file_get_contents($counter_file); //Umwandlung in int weil file_get_contents string zurückgibt
                $counter++;
                file_put_contents($counter_file, $counter);
            }?>
            <li><?php echo $counter?> Besucher</li>

            <li><?php echo count(file("newsletter_data.txt")) ?> Anmeldungen zum Newsletter</li>
            <li><?php
                include ('Gerichte.php');
                echo count ($gerichte);
                ?> Speisen</li>
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
            $data = "\nVorname: $vname, E-Mail: $email, Benachrichtigungsintervall: $auswahl";
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