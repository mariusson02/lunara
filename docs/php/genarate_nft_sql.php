<?php

$planetNames = ['Earth', 'Venus', 'Mercury', 'Mars', 'Jupiter', 'Saturn', 'Uranus', 'Neptune'];

$planetDescriptions = [
    'Earth' => 'Der einzige bekannte Planet mit Leben, bestehend aus Ozeanen und Kontinenten.',
    'Venus' => 'Ein heißer Planet mit einer dichten Atmosphäre aus Kohlendioxid.',
    'Mercury' => 'Der sonnennächste Planet mit extremen Temperaturen zwischen Tag und Nacht.',
    'Mars' => 'Der rote Planet, bekannt für seine staubigen Landschaften und eisigen Polkappen.',
    'Jupiter' => 'Der größte Planet im Sonnensystem, mit massiven Stürmen wie dem Großen Roten Fleck.',
    'Saturn' => 'Berühmt für seine auffälligen Ringe aus Eis und Gestein.',
    'Uranus' => 'Ein eisiger Riese mit einer Atmosphäre aus Wasserstoff, Helium und Methan.',
    'Neptune' => 'Ein blauer Gasriese mit den stärksten Winden im Sonnensystem.'
];

$types = ['Common', 'Rare', 'Epic', 'Legendary'];

// Pfad zur SQL-Datei
$outputFile = 'nft_planets.sql';

try {
    // Datei öffnen oder erstellen
    $fileHandle = fopen($outputFile, 'w');

    if (!$fileHandle) {
        throw new Exception('Die Datei konnte nicht erstellt/geöffnet werden.');
    }

    $id = 1; // Start-ID

    foreach ($planetNames as $name) {
        $description = $planetDescriptions[$name];
        $type = $types[array_rand($types)]; // Random Typ wird einem Planeten zugeordnet
        $price = round((rand(100, 1000) / 100), 2); // Zufälliger Preis zwischen 1.00 und 10.00
        $owner_id = 'NULL'; // Noch kein Besitzer

        // SQL-Befehl vorbereiten
        $sql = sprintf(
            "INSERT INTO public.nft (id, name, description, type, price, img, owner_id) VALUES (%d, '%s', '%s', '%s', %.2f, NULL, %s);\n",
            $id,
            addslashes($name),
            addslashes($description),
            addslashes($type),
            $price,
            $owner_id
        );

        // SQL-Befehl in Datei schreiben
        fwrite($fileHandle, $sql);

        $id++;
    }

    // Datei schließen
    fclose($fileHandle);

    echo "SQL-Datei erfolgreich erstellt: $outputFile\n";
} catch (Exception $e) {
    echo "Fehler: " . $e->getMessage();
}
