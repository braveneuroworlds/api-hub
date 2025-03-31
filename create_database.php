<?php
$db_file = 'api_hub.sqlite'; // The name of our database file
$db = new PDO('sqlite:' . $db_file); // Connect to the database

$db->exec("CREATE TABLE IF NOT EXISTS apis (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    description TEXT,
    category TEXT,
    documentation_url TEXT
)"); // SQL to create the 'apis' table

$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL
)");

$db->exec("CREATE TABLE IF NOT EXISTS user_apis (
    user_id INTEGER NOT NULL,
    api_id INTEGER NOT NULL,
    PRIMARY KEY (user_id, api_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (api_id) REFERENCES apis(id)
)");

echo "Database and table created successfully!";

$db = NULL; // Close the connection
?>