<?php
session_start();
$db_file = 'api_hub.sqlite';
$db = new PDO('sqlite:' . $db_file);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the user's saved APIs
$stmt = $db->prepare("SELECT apis.* FROM apis JOIN user_apis ON apis.id = user_apis.api_id WHERE user_apis.user_id = :user_id");
$stmt->execute([':user_id' => $user_id]);
$saved_apis = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My API Hub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>My API Hub</h1>
        <nav>
            <a href="home.php">Home</a> | <a href="browse.php">Browse APIs</a> | <a href="logout.php">Log Out</a>
        </nav>
    </header>

    <main>
        <section id="saved-api-list">
            <h2>My Saved APIs</h2>
            <div id="api-listings-container">
                </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 API Hub</p>
    </footer>

    <script>
        function displayApis(apis) {
            const container = document.getElementById('api-listings-container');
            container.innerHTML = '';

            if (apis.length === 0) {
                container.innerHTML = '<p>No APIs saved yet.</p>';
                return;
            }

            apis.forEach(api => {
                const apiDiv = document.createElement('div');
                apiDiv.classList.add('api-item');
                apiDiv.innerHTML = `
                    <h3>${api.name}</h3>
                    <p>${api.description}</p>
                    <p>Category: ${api.category}</p>
                    <a href="${api.documentation_url}">Documentation</a>
                `;
                container.appendChild(apiDiv);
            });
        }

        // Display the saved APIs
        const savedApis = <?php echo json_encode($saved_apis); ?>;
        displayApis(savedApis);
    </script>
</body>
</html>

