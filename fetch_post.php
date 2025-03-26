<?php
// Force CORS headers
header("Access-Control-Allow-Origin: *", true);
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "db_connect.php";

$url = SUPABASE_URL . "/rest/v1/news_posts?select=*&order=created_at.desc";
$options = [
    "http" => [
        "method" => "GET",
        "header" => [
            "apikey: " . SUPABASE_KEY,
            "Authorization: Bearer " . SUPABASE_KEY,
            "Content-Type: application/json"
        ]
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

if ($response === FALSE) {
    echo json_encode(["message" => "Failed to fetch posts", "error" => error_get_last()]);
} else {
    echo $response;
}
?>