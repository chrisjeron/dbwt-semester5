<?php
/**
 * Praktikum DBWT. Autoren:
 * Doehm, Patrick, 3532447
 * Jeron, Christoph, 3537624
 */

$famousMeals = [
    1 => ['name' => 'Currywurst mit Pommes',
        'winner' => [2001, 2003, 2007, 2010, 2020]],
    2 => ['name' => 'Hähnchencrossies mit Paprikareis',
        'winner' => [2002, 2004, 2008]],
    3 => ['name' => 'Spaghetti Bolognese',
        'winner' => [2011, 2012, 2017]],
    4 => ['name' => 'Jägerschnitzel mit Pommes',
        'winner' => 2019]
];

//Ausgabe des Arrays sortiert

echo "<ol>";
foreach($famousMeals as $schluessel => $inner){
    echo  "<li> $inner[name] <br>";

    if(is_int($inner['winner'])) {
        echo "$inner[winner]  </li> " ;
    }
    else{
        $groesse= count($inner['winner']);
        for($i=$groesse-1; $i>=0; $i--){
            echo $inner['winner'][$i];
            if($i !== 0){
                echo ", ";
            }
        }

    }
}
echo "</ol>";


//Jahre ohne Gewinner seit 2000 herausfinden

$keineGewinner = []; // Array in dem alle Jahre ohne Gewinner gespeichert werden
for ($jahr = 2000; $jahr <= date("Y"); $jahr++){ // fo-Schleife die ab dem Jahr 2000 bis zum momentanen Jahr durchgelaufen wird
    $gewinnerjahr = false; //bool um zu indinzieren ob das durchlaufene Jahr ein Gewinnerjahr ist oder nicht

    foreach ($famousMeals as $meal) {
        if (is_array($meal['winner'])) { //Überprüfung ob Wert im Array 'winner' ein Array ist
            if (in_array($jahr, $meal['winner'])) { // Wenn ein Array, überprüfe ob das momentan durchlaufene Jahr im Array vorkommt
                $gewinnerjahr = true;
                break;
            }
        } elseif ($meal['winner'] == $jahr) { //wenn kein Array ist, sondern nur einzelner Wert, überprüfe ob dieser dem momentan durchlaufenem jahr entspricht
            $gewinnerjahr = true;
            break;
        }
    }

    if (!$gewinnerjahr) {
        $keineGewinner[] = $jahr;
    }
}

echo 'Jahre ohne Gewinner seit 2000: ' . implode(', ', $keineGewinner);