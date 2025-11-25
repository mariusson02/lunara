<?php

require 'DatabaseConnection.php';

Database::connect();

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

// $imageBaseUrl    -> Bilder mit Link anbinden
// $imageName       -> Dynamisch aus der DB oder Upload

try {
    $stmt = $pdo->prepare("INSERT INTO public.nft (id, name, description, type, price, img, owner_id) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)");

    // planeten durchegehen
    $id = 1; // start-id
    foreach ($planetNames as $name) {
        $description = $planetDescriptions[$name];
        $type = $types[array_rand($types)]; // random type wird einem planeten zugeordnet
        $price = round((rand(100, 1000) / 100), 2); // random preis zw. 1.00 und 100.00
        //$img = imageBaseUrl -> idk
        $owner_id = null; // -> noch nicht gekauft (noch kein besitzer)

        // execution von sql
        $stmt->execute([$id, $name, $description, $type, $price, $owner_id]);
        $id = $id + 1; // id wird für den nächsten eintrag erhöht
    }

    echo count($planetNames) . "erfolgreich in public.nft eingefügt";
}
catch (PDOException $e) {
    echo $e->getMessage();     //bei errors wird message ausgegeben
}