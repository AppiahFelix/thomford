<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_encode([
        "title" => $_POST["title"],
        "content" => $_POST["content"],
        "image" => $_POST["image"]
    ]);

    $url = SUPABASE_URL . "/rest/v1/news_posts";
    $options = [
        "http" => [
            "method" => "POST",
            "header" => [
                "apikey: " . SUPABASE_KEY,
                "Content-Type: application/json"
            ],
            "content" => $data
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === FALSE) {
        echo json_encode(["message" => "Failed to add post"]);
    } else {
        echo json_encode(["message" => "Post added successfully"]);
    }
}
?>