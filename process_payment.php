<?php

require_once('C:\xampp\htdocs\nearsureTest\vendor\stripe\stripe-php\init.php');
require_once('C:\xampp\htdocs\nearsureTest\secrets.php');

\Stripe\Stripe::setApiKey($stripeSecretKey);

$cardNumber = $_POST['cardNumber'];
$expirationDate = $_POST['expirationDate'];
$cvv = $_POST['cvv'];

$cardType = '';
if (preg_match('/^4/', $cardNumber)) {
    $cardType = 'Visa';
} elseif (preg_match('/^5[1-5]/', $cardNumber)) {
    $cardType = 'Mastercard';
} elseif (preg_match('/^3[47]/', $cardNumber)) {
    $cardType = 'Amex';
} elseif (preg_match('/^3(?:0[0-5]|[68][0-9])/', $cardNumber)) {
    $cardType = 'DinersClub';
} elseif (preg_match('/^6(?:011|5[0-9]{2})/', $cardNumber)) {
    $cardType = 'Discover';
} elseif (preg_match('/^(?:2131|1800|35\d{3})/', $cardNumber)) {
    $cardType = 'JCB';
}

if ($cardType === 'Amex') {
    if (strlen($cvv) !== 4 || !ctype_digit($cvv)) {
        $response = [
            'success' => false,
            'message' => 'Invalid CVV. Please enter a 4-digit CVV for American Express.'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
} else {
    if (strlen($cvv) !== 3 || !ctype_digit($cvv)) {
        $response = [
            'success' => false,
            'message' => 'Invalid CVV. Please enter a 3-digit CVV.'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}

try {
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => 1000, // Valor em centavos (R$10,00)
        'currency' => 'brl',
        'payment_method_data' => [
            'type' => 'card',
            'card' => [
                'number' => str_replace(' ', '', $cardNumber),
                'exp_month' => substr($expirationDate, 0, 2),
                'exp_year' => substr($expirationDate, -2),
                'cvc' => $cvv,
            ],
        ],
    ]);

    if ($paymentIntent->status === 'succeeded') {
        $response = [
            'success' => true,
            'message' => 'Payment successful! Thank you.'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Payment failed.'
        ];
    }
} catch (\Stripe\Exception\CardException $e) {
    $response = [
        'success' => false,
        'message' => 'Payment failed: ' . $e->getMessage()
    ];
} catch (\Stripe\Exception\RateLimitException $e) {
    $response = [
        'success' => false,
        'message' => 'Payment failed: ' . $e->getMessage()
    ];
} catch (\Stripe\Exception\InvalidRequestException $e) {
    $response = [
        'success' => false,
        'message' => 'Payment failed: ' . $e->getMessage()
    ];
} catch (\Stripe\Exception\AuthenticationException $e) {
    $response = [
        'success' => false,
        'message' => 'Payment failed: ' . $e->getMessage()
    ];
} catch (\Stripe\Exception\ApiConnectionException $e) {
    $response = [
        'success' => false,
        'message' => 'Payment failed: ' . $e->getMessage()
    ];
} catch (\Stripe\Exception\ApiErrorException $e) {
    $response = [
        'success' => false,
        'message' => 'Payment failed: ' . $e->getMessage()
    ];
}

header('Content-Type: application/json');
echo json_encode($response);