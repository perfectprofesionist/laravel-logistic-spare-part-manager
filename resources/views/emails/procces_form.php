<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json'); // Set JSON response header
    
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        echo json_encode(["status" => "error", "message" => "Invalid data"]);
        exit;
    }


    $admin_email = "test@test.com";  // Replace with actual admin email
    $user_email = filter_var($data['email'], FILTER_VALIDATE_EMAIL); // Validate email

    if (!$user_email) {
        echo json_encode(["status" => "error", "message" => "Invalid email address"]);
        exit;
    }

    // Format data for the admin email
    $admin_subject = "New Inquiry Submitted";

    $summary = $data['summary'] ?? [];
    $additionalData = $data['additional_data'] ?? [];
    $interests = $data['interests'] ?? [];

    
    $admin_message = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Quote Summary</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                color: #333;
                line-height: 1.6;
            }
            h2 {
                background-color: #f5f5f5;
                padding: 10px;
                border-left: 5px solid #007BFF;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 25px;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px 12px;
                text-align: left;
            }
            th {
                background-color: #007BFF;
                color: white;
            }
            .details-table {
                width: 100%;
                border: 1px solid #ccc;
            }
            .details-table td {
                vertical-align: top;
                padding: 10px;
            }
            .details-title {
                font-weight: bold;
                background-color: #f9f9f9;
                padding: 8px;
                border-bottom: 1px solid #ddd;
            }
        </style>
    </head>
    <body>
    
    <h2>Quote Summary</h2>
    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>';
            foreach ($summary as $item) {
                $admin_message .= '
                <tr>
                    <td>' . htmlspecialchars($item['description']) . '</td>
                    <td>' . htmlspecialchars($item['price']) . '</td>
                    <td>' . htmlspecialchars($item['quantity']) . '</td>
                    <td>' . htmlspecialchars($item['total']) . '</td>
                </tr>';
            }
    $admin_message .= '
        </tbody>
    </table>
    
    <h2>Additional Info & Selected Interests</h2>
    <table class="details-table">
        <tr>
            <td width="50%">
                <div class="details-title">Additional Details</div>
                <ul>';
                    foreach ($additionalData as $label => $value) {
                        $admin_message .= '<li><strong>' . htmlspecialchars($label) . ':</strong> ' . htmlspecialchars($value) . '</li>';
                    }
    $admin_message .= '
                </ul>
                <div class="details-title">Selected Interests</div>
                <ul>
                    <li><strong>Selected Interests:</strong> ' . implode(', ', array_map('htmlspecialchars', $interests)) . '</li>
                </ul>
            </td>
        </tr>
    </table>
    
    </body>
    </html>';
    

    // Email Headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: jiliga2663@lesotica.com" . "\r\n";  // Change sender email

    // Send email to Admin
    $admin_mail_sent = mail($admin_email, $admin_subject, $admin_message, $headers);

    // Send email to User
    $user_subject = "Thank You for Your Inquiry";
    $user_message = "
        <p>Hello,</p>
        <p>Thank you for reaching out! We have received your inquiry and will get back to you as soon as possible.</p>
        <p>Best Regards,<br />Team</p>
    ";

    $user_mail_sent = mail($user_email, $user_subject, $user_message, $headers);

        echo json_encode(["status" => "success", "message" => "Emails sent successfully!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
?>
