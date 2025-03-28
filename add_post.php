<?php
require 'db_connect.php'; // Ensure database connection

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $imageBase64 = null; // Default null if no image uploaded

    // Check if an image was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $fileTmp = $_FILES['image']['tmp_name'];
        $fileType = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        // Convert image to Base64
        $imageData = file_get_contents($fileTmp);
        $imageBase64 = "data:image/" . $fileType . ";base64," . base64_encode($imageData);
    }

    // Insert into Supabase database
    $data = json_encode([
        "title" => $title,
        "content" => $content,
        "image" => $imageBase64
    ]);

    $url = SUPABASE_URL . "/rest/v1/news_posts";
    $options = [
        "http" => [
            "method" => "POST",
            "header" => [
                "apikey: " . SUPABASE_KEY,
                "Content-Type: application/json",
                "Prefer: return=minimal"
            ],
            "content" => $data
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        echo json_encode(["message" => "Error adding post to Supabase"]);
    } else {
        echo json_encode(["message" => "Post added successfully!", "image" => $imageBase64]);
    }
}
?>
