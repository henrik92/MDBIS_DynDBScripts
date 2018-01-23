<?php require 'vendor/autoload.php';

date_default_timezone_set('Europe/Berlin');

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

    $sdk = new Aws\Sdk([
    'region' => 'eu-central-1',
    'version' => 'latest',
    'scheme' => 'http', 
    'credentials' => [
        'key' => '***************', 
        'secret' => '***************'
    ]
        ]);
        
$dynamodb = $sdk->createDynamoDb();
$marshaler = new Marshaler();

$tableName = 'Movies';

$movies = json_decode(file_get_contents('outputFile.json'), true);

foreach ($movies as $movie) {
  //MOVIETITLE
    $title = $movie['title'];
  //MOVIEINFO
    $directors = $movie['info']['directors'];
    $genres = $movie['info']['genres'];
    $year = $movie['info']['year'];
    $image = $movie['info']['image_url'];
    $plot = $movie['info']['plot'];
    $actors = $movie['info']['actors'];
  //MOVIERATING
    $rating_value = $movie['rating']['value'];
    $rating_counter = $movie['rating']['counter'];
    $rating_rank = $movie['rating']['rank'];

    $json = json_encode([
        'title' => $title,
        'info' => array(
        'directors' => $directors,
        'genres' => $genres,
        'year' => $year,
        'image_url' => $image,
        'plot' => $plot,
        'actors' => $actors
      ),
       'rating' => array(
        'rating_value' => $rating_value,
         'rating_counter' => $rating_counter,
          'rating_rank' => $rating_rank,
      )
    ]);
    print_r($json);
    $params = [
        'TableName' => $tableName,
        'Item' => $marshaler->marshalJson($json)
    ];

    try {
        $result = $dynamodb->putItem($params);
        echo "Added movie: " . $movie['title'] . "\n";
    } catch (DynamoDbException $e) {
        echo "Unable to add movie:\n";
        echo $e->getMessage() . "\n";
        break;
    }
}
?>
