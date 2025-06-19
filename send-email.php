<?php
// Only allow POST requests
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $to = "info@devguy.site";
    $subject = "New Lead from Website";

    // Sanitize inputs
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $company = htmlspecialchars($_POST['company'] ?? '');
    $service = htmlspecialchars($_POST['service'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');
    $goals = isset($_POST['goals']) ? implode(", ", $_POST['goals']) : '';

    $body = "
        Name: $name\n
        Email: $email\n
        Company: $company\n
        Service: $service\n
        Project Goals: $goals\n
        Message:\n$message
    ";

    $headers = "From: $email\r\nReply-To: $email\r\n";

    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(["success" => true]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "error" => "Failed to send email"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
}
