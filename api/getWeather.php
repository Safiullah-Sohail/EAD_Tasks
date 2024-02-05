<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['cityName'])) {
    $cityName = $_GET['cityName'];

    $apiEndpoint = 'https://api.weatherapi.com/v1/current.json';
    $apiKey = 'fb719b54295d4b91b56190036240302';

    $apiUrl = "{$apiEndpoint}?key={$apiKey}&q={$cityName}";

    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($httpCode == 200) {
        $weatherData = json_decode($response, true);
        if (json_last_error() == JSON_ERROR_NONE) {
            $temperature = $weatherData['current']['temp_c'];
            $description = $weatherData['current']['condition']['text'];
            $weatherDetails = [
                'temperature' => $temperature,
                'description' => $description
            ];

            echo json_encode($weatherDetails);
        } else {
            $errorResponse = ['error' => 'Failed to decode JSON response'];
            echo json_encode($errorResponse);
        }
    } else {
        $errorResponse = ['error' => 'Failed to fetch weather details'];
        echo json_encode($errorResponse);
    }
} else {
    $errorResponse = ['error' => 'Invalid request'];
    echo json_encode($errorResponse);
}
