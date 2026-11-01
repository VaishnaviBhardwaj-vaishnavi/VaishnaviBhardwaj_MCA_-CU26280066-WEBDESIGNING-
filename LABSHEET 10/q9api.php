<?php

$token = "MY_SECRET_API_TOKEN";

$headers = getallheaders();

$auth = $headers['Authorization'] ?? '';

if($auth !== "Bearer " . $token) {

    http_response_code(401);

    echo json_encode([
        "error" => "Unauthorized access"
    ]);

    exit;
}
?>