<?php
session_start();
$db_file = 'api_hub.sqlite';
$db = new PDO('sqlite:' . $db_file);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all APIs
$stmt = $db->query("SELECT * FROM apis");
$all_apis = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse APIs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Browse APIs</h1>
        <nav>
            <a href="home.php">Home</a> | <a href="browse.php">Browse APIs</a> | <a href="add_api.php">Add API</a> | <a href="logout.php">Log Out</a>
        </nav>
    </header>

    <main>
        <section id="api-list">
            <h2>All APIs</h2>
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

            apis.forEach(api => {
                const apiDiv = document.createElement('div');
                apiDiv.classList.add('api-item');
                apiDiv.innerHTML = `
                    <h3>${api.name}</h3>
                    <p>${api.description}</p>
                    <p>Category: ${api.category}</p>
                    <a href="${api.documentation_url}">Documentation</a>
                    <button onclick="saveApi(${api.id})">Save</button>
                `;
                container.appendChild(apiDiv);
            });
        }

        // Fetch and display all APIs
        const allApis = <?php echo json_encode($all_apis); ?>;
        displayApis(allApis);

        function saveApi(apiId) {
            fetch('save_api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ apiId: apiId })
            })
            .then(response => response.text())
            .then(data => {
                alert(data); // Show a simple alert for now
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>