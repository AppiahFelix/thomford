<?php
define('SUPABASE_URL', 'https://kcofrwsnkzgfgcsizcdr.supabase.co');  // Replace with your actual Supabase URL
define('SUPABASE_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Imtjb2Zyd3Nua3pnZmdjc2l6Y2RyIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDI2NjY2MzksImV4cCI6MjA1ODI0MjYzOX0.5Iir3AV5b_wUXgokc60xY1og3tYRcPMGeTEa6rw6Yf0');  // Replace with your actual Anon Key


function fetchFromSupabase($endpoint) {
    $url = SUPABASE_URL . "/rest/v1/" . $endpoint;

    $options = [
        'http' => [
            'method' => 'GET',
            'header' => "apikey: " . SUPABASE_KEY . "\r\nContent-Type: application/json\r\n"
        ]
    ];

    $context = stream_context_create($options);
    $response = @file_get_contents($url, false, $context);

    if ($response === false) {
        return ["error" => "Failed to fetch data from Supabase"];
    }

    return json_decode($response, true);
}
?>
