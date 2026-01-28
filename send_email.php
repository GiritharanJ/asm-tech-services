<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $to = "giritharanjanakiraman@gmail.com"; // Replace with your email
    $subject = "New IT Requirements Request";
    $message = "Mobile: " . $data['mobile'] . "\n\n";
    $message .= "Requirements:\n" . $data['requirements'];
    $headers = "From: webform@yourdomain.com";
    
    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to send email']);
    }
}
?>
