<?php
session_start();
$db_file = 'api_hub.sqlite';
$db = new PDO('sqlite:' . $db_file);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']); // Trim whitespace
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $documentation_url = trim($_POST['documentation_url']);

    $errors = [];

    if (empty($name)) {
        $errors['name'] = 'API Name is required.';
    }

    if (empty($documentation_url) || !filter_var($documentation_url, FILTER_VALIDATE_URL)) {
        $errors['documentation_url'] = 'Valid Documentation URL is required.';
    }

    if (count($errors) > 0) {
        // Display errors (we'll improve this later)
        foreach ($errors as $field => $message) {
            echo "<p style='color:red;'>$message</p>";
        }
    } else {
        try {
            $stmt = $db->prepare("INSERT INTO apis (name, description, category, documentation_url) VALUES (:name, :description, :category, :documentation_url)");
            $stmt->execute([
                ':name' => $name,
                ':description' => $description,
                ':category' => $category,
                ':documentation_url' => $documentation_url
            ]);
            echo "API added successfully!";
            header("Location: browse.php"); // Redirect back to browse
            exit();
        } catch (PDOException $e) {
            echo "Error adding API: " . $e->getMessage();
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
    <title>Add API</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function validateForm() {
            const name = document.getElementById('name').value.trim();
            const documentation_url = document.getElementById('documentation_url').value.trim();
            const errorDiv = document.getElementById('error-messages');
            errorDiv.innerHTML = ''; // Clear previous errors
            let isValid = true;

            if (name === '') {
                displayError('API Name is required.', 'name');
                isValid = false;
            }

            if (documentation_url === '' || !isValidUrl(documentation_url)) {
                displayError('Valid Documentation URL is required.', 'documentation_url');
                isValid = false;
            }

            return isValid;
        }

        function displayError(message, fieldId) {
            const errorDiv = document.getElementById('error-messages');
            errorDiv.innerHTML += `<p style='color:red;'>${message}</p>`;
            document.getElementById(fieldId).focus(); // Set focus to the field
        }

        function isValidUrl(url) {
            try {
                new URL(url);
                return true;
            } catch (_) {
                return false;
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>Add API</h1>
        <nav>
            <a href="home.php">Home</a> | <a href="browse.php">Browse APIs</a> | <a href="logout.php">Log Out</a>
        </nav>
    </header>

    <main>
        <section id="add-api-form">
            <h2>Add a New API</h2>
            <div id="error-messages"></div>
            <form method="post" action="add_api.php" onsubmit="return validateForm();">
                <label for="name">API Name:</label><br>
                <input type="text" id="name" name="name" required><br><br>
                <label for="description">Description:</label><br>
                <textarea id="description" name="description" rows="4" cols="50"></textarea><br><br>
                <label for="category">Category:</label><br>
                <input type="text" id="category" name="category"><br><br>
                <label for="documentation_url">Documentation URL:</label><br>
                <input type="url" id="documentation_url" name="documentation_url" required><br><br>
                <input type="submit" value="Add API">
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 API Hub</p>
    </footer>
</body>
</html>