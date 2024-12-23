<?php
session_start();
include "../config/database.php";
$CourseId = $_SESSION['CourseId'] ;
$sql = "SELECT * FROM courses WHERE Id = $CourseId";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
require dirname(__DIR__) . "/vendor/autoload.php";

// Replace with your actual Stripe secret key
$stripe_secret_key = "sk_test_51QYalsB7vHJHLZaLE1ZxK3xf7iKWIfV8izt8Q6mRzAy8Jz2GOlGwHjCRF2mIlAq1D39ZkPbkIVfgoYEScrqRQdkM00Ew3vhzZ0"; // Get this from Stripe Dashboard

\Stripe\Stripe::setApiKey($stripe_secret_key);

try {
    $checkout_session = \Stripe\Checkout\Session::create([
        "payment_method_types" => ["card"],
        "mode" => "payment",
        "success_url" => "http://localhost/E_Learning_Platform/Controllers/EnrollCourseController.php?session_id={CHECKOUT_SESSION_ID}",
        "cancel_url" => "http://localhost/E_Learning_Platform/index.php",
        "line_items" => [
            [
                "quantity" => 1,
                "price_data" => [
                    "currency" => "usd",
                    "unit_amount" => $row["Price"]*100,
                    "product_data" => [
                        "name" => $row["Title"]
                    ]
                ]
            ]
        ]
    ]);

    http_response_code(303);
    header("Location: " . $checkout_session->url);

} catch (\Stripe\Exception\ApiErrorException $e) {
    http_response_code(500);
    echo "Error creating checkout session: " . $e->getMessage();
}

