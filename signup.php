<?php
$db_file = 'api_hub.sqlite';
$db = new PDO('sqlite:' . $db_file);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password!

    try {
        $stmt = $db->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
        $stmt->execute([':email' => $email, ':password' => $password]);
        echo "Signup successful!";
    } catch (PDOException $e) {
        if ($e->getCode() == '23000') { // Code for duplicate entry
            echo "Email already exists.";
        } else {
            echo "Signup failed: " . $e->getMessage();
        }
    }
}
$db = NULL;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <h2>Sign Up</h2>
    <form method="post" action="signup.php">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Sign Up">
    </form>
</body>
</html>