<?php
$db_file = 'api_hub.sqlite';
$db = new PDO('sqlite:' . $db_file);

$apis = [
    [
        'name' => 'Weather API',
        'description' => 'Provides current weather data, forecasts, and historical information.',
        'category' => 'Weather',
        'documentation_url' => 'https://www.weatherapi.com/'
    ],
    [
        'name' => 'News API',
        'description' => 'Delivers up-to-date news articles from various sources.',
        'category' => 'News',
        'documentation_url' => 'https://newsapi.org/'
    ],
    [
        'name' => 'The Movie Database (TMDB) API',
        'description' => 'A large database of movies, TV shows, and actors.',
        'category' => 'Movies',
        'documentation_url' => 'https://developer.themoviedb.org/docs'
    ]
];

foreach ($apis as $api) {
    $stmt = $db->prepare("INSERT INTO apis (name, description, category, documentation_url) VALUES (:name, :description, :category, :documentation_url)");
    $stmt->execute([
        ':name' => $api['name'],
        ':description' => $api['description'],
        ':category' => $api['category'],
        ':documentation_url' => $api['documentation_url']
    ]);
}

echo "API data inserted successfully!";

$db = NULL;
?>