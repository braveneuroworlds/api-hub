<?php
session_start();
header('Content-Type: application/json');

$db_file = 'api_hub.sqlite';
$db = new PDO('sqlite:' . $db_file);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true); // Get JSON data from the request
$api_id = $data['apiId'];

try {
    $stmt = $db->prepare("INSERT INTO user_apis (user_id, api_id) VALUES (:user_id, :api_id)");
    $stmt->execute([':user_id' => $user_id, ':api_id' => $api_id]);
    echo json_encode(['status' => 'success', 'message' => 'API saved']);
} catch (PDOException $e) {
    if ($e->getCode() == '23000') {
        echo json_encode(['status' => 'error', 'message' => 'API already saved']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error saving API: ' . $e->getMessage()]);
    }
}

$db = NULL;
?>