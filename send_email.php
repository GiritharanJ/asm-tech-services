<?php
// send_email.php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $mobile = htmlspecialchars(trim($_POST['mobile'] ?? ''));
    $requirements = htmlspecialchars(trim($_POST['requirements'] ?? ''));
    $captcha = htmlspecialchars(trim($_POST['captcha'] ?? ''));
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($mobile) || empty($requirements)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format']);
        exit;
    }
    
    // Email configuration
    $to = "info@asmtechservices.com, support@asmtechservices.com"; // Both emails
    $subject = "New IT Requirements Request - ASM Tech Services";
    
    // Email body
    $message = "
    <html>
    <head>
        <title>New IT Requirements Request</title>
        <style>
            body { font-family: Arial, sans-serif; }
            .container { max-width: 600px; margin: 0 auto; }
            .header { background: #4f46e5; color: white; padding: 20px; }
            .content { padding: 20px; border: 1px solid #ddd; }
            .field { margin-bottom: 15px; }
            .label { font-weight: bold; color: #333; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>New IT Requirements Request</h2>
                <p>ASM Tech Services Website</p>
            </div>
            <div class='content'>
                <div class='field'>
                    <div class='label'>Client Name:</div>
                    <div>$name</div>
                </div>
                <div class='field'>
                    <div class='label'>Email:</div>
                    <div>$email</div>
                </div>
                <div class='field'>
                    <div class='label'>Mobile:</div>
                    <div>$mobile</div>
                </div>
                <div class='field'>
                    <div class='label'>Requirements:</div>
                    <div>" . nl2br($requirements) . "</div>
                </div>
                <div class='field'>
                    <div class='label'>Submitted On:</div>
                    <div>" . date('F j, Y, g:i a') . "</div>
                </div>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // Email headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: ASM Tech Services <noreply@asmtechservices.com>" . "\r\n";
    $headers .= "Reply-To: $email" . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    // Send email
    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['success' => true, 'message' => 'Request sent successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to send email. Please try again.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
