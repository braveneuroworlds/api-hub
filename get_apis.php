<?php
header('Content-Type: application/json'); // Tell the browser to expect JSON

$db_file = 'api_hub.sqlite';
$db = new PDO('sqlite:' . $db_file);

$stmt = $db->query("SELECT * FROM apis"); // Fetch all data from the 'apis' table
$apis = $stmt->fetchAll(PDO::FETCH_ASSOC); // Get the results as an associative array

echo json_encode($apis); // Convert the PHP array to JSON and send it to the browser

$db = NULL;
?>