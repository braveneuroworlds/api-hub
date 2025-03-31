<?php
session_start(); // Start the session
$db_file = 'api_hub.sqlite';
$db = new PDO('sqlite:' . $db_file);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT id, password FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        echo "Login successful!";
        $_SESSION['user_id'] = $user['id']; // Store user ID in session
        header("Location: home.php"); // Redirect to home.php
        exit(); // Stop further execution
    } else {
        echo "Login failed. Invalid email or password.";
    }
}
$db = NULL;
?>

<?php
$db_file = 'api_hub.sqlite';
$db = new PDO('sqlite:' . $db_file);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT id, password FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        echo "Login successful!";
        // In a real application, you would set a session here to keep the user logged in
    } else {
        echo "Login failed. Invalid email or password.";
    }
}
$db = NULL;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
</head>
<body>
    <h2>Log In</h2>
    <form method="post" action="login.php">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Log In">
    </form>
</body>
</html>