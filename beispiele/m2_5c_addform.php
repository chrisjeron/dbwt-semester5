<?php
/**
 * Praktikum DBWT. Autoren:
 * Doehm, Patrick, 3532447
 * Jeron, Christoph, 3537624
 */


include 'm2_5a_standardparameter.php';
function multiplizieren($a=0, $b=0){
    $ergebnis= $a * $b;
    return $ergebnis;
}
?>
    <form method="get">
        <label for="zahl1">Ihre erste Zahl</label>
        <input type="number" name="zahl1" id="zahl1" required>
        <label for="zahl2">Ihre zweite Zahl</label>
        <input type="number" name="zahl2" id="zahl2" required>
        <br>
        <input type="submit" name="addieren" value="addieren">
        <input type="submit" name="multiplizieren" value="multiplizieren">
    </form>
<?php

if(isset($_GET['addieren'])){
    $a= $_GET['zahl1'];
    $b= $_GET['zahl2'];

    echo addieren($a, $b);
}
if(isset($_GET['multiplizieren'])){
    $a= $_GET['zahl1'];
    $b= $_GET['zahl2'];

    echo multiplizieren($a, $b);
}
?>