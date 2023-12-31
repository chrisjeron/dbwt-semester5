<!DOCTYPE html>
<html lang="de en">
<form action="m2_7b_showtext.php" method="get">
    <label for="suche">Suchwort:</label>
    <input type="text" name="suche" id="suche" required>
    <button type="submit">Suchen</button>
</form>

<?php
/**
 * Praktikum DBWT. Autoren:
 * Doehm, Patrick, 3532447
 * Jeron, Christoph, 3537624
 */

$file = fopen('en.txt',"r" );

if (isset($_GET['suche'])) {
    $suchwort = $_GET['suche'];
    $uebersetzung = NULL;

    while(!feof($file)) {
        $line = fgets($file);

        $zeile = explode(';', $line);

        if ($zeile[0] == $suchwort ) {
            $uebersetzung = $zeile[1];
            break; //
        }
    }
    fclose($file);
    if ($uebersetzung !== NULL){
        echo "Die Übersetzung lautet: $uebersetzung";}
    else{
        echo "Das gesuchte Wort " . $suchwort . " ist nicht enthalten.";
    }


}
?>


</html>