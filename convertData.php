<?php
/*Read Input File*/
$json = file_get_contents('inputFile/moviedata.json');
$json_data = json_decode($json, true);

/*Define a Line of the Array*/
$temp;
$title;
$out = Array();
$item = Array();
$id = 0;
$besterfilm = 9.99;
foreach ($json_data as $item){
    //Wir nutzen einfach die ID um den Rang zuzuweisen 
    $json_data[$id]['info']['rank'] = $id + 1;

    // Absteigendes Rating berechnen mit Hilfe von ID 
    $besterfilm = $besterfilm - (9/4608); 
    $ergebnis = round($besterfilm,2);


        $json_data[$id]['info']['rating'] = $ergebnis;
        printf($json_data[$id]['info']['rating']);
        print("
            ");

    $temp = array(
        "title" => $json_data[$id]['title'],
        "info" => array(
            "directors" => $json_data[$id]['info']['directors'],
            "genres" => $json_data[$id]['info']['genres'],
            "year" => $json_data[$id]['year'],
            "image_url" => $json_data[$id]['info']['image_url'],
            "plot" => $json_data[$id]['info']['plot'],
            "actors" => $json_data[$id]['info']['actors']
        ),
        "rating" => array(
            "value" => $json_data[$id]['info']['rating'] + "",
            "counter" => rand(1000, 100000),
            "rank" => $json_data[$id]['info']['rank']
        )
    );

    //print_r($temp);
    array_push($out, $temp);
    $id++;
    
           // }
}
    $result = json_encode($out);
    file_put_contents('outputFile.json', $result);
   // print_r($result);
?>
