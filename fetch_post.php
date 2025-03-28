<?php
// Force CORS headers
header("Access-Control-Allow-Origin: *", true);
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "db_connect.php";

$url = SUPABASE_URL . "/rest/v1/news_posts?select=*";
$options = [
    "http" => [
        "method" => "GET",
        "header" => [
            "apikey: " . SUPABASE_KEY,
            "Content-Type: application/json"
        ]
    ]
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);
echo $result;
?>
