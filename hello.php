<?php

header("Content-Type: application/json");

$visitorName = isset($_GET['visitor_name']) ? $_GET['visitor_name'] : 'guest';
$ip = $_SERVER['REMOTE_ADDR'];
$locationData = getLocationAndTemperature($ip);

$response = [
    'client_ip' => $ip,
    'location' => $locationData['city'],
    'greeting' => "Hello, {$visitorName}!, the temperature is {$locationData['temperature']} degrees Celsius in {$locationData['city']}"
];

echo json_encode($response);

function getLocationAndTemperature($ip) {
    $locationResponse = file_get_contents('http://ip-api.com/json/' . $ip);
    $locationData = json_decode($locationResponse, true);
    $city = $locationData['city'];

    $lat = $locationData['lat'];
    $lon = $locationData['lon'];

    $getWeather = file_get_contents("https://api.open-meteo.com/v1/forecast?latitude=$lat&longitude=$lon&current_weather=true");
    $weatherData = json_decode($getWeather, true);
    $temperature = $weatherData['current_weather']['temperature'];

    return [
        'city' => $city,
        'temperature' => $temperature
    ];
}
?>
