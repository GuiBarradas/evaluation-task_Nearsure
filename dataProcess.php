<?php
require_once 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('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');  //private key 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $cardNumber = $_POST['card_number'];
    $expirationDate = $_POST['expiration_date'];
    $cvv = $_POST['cvv'];

    // Perform card data validation as necessary

    // Create a payment object using the Stripe API
    try {
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => 1000, // amount in cents (R$10.00)
            'currency' => 'brl',
            'payment_method_types' => ['card'],
        ]);

        // Do something with the returned payment object, such as saving it in the database or displaying a success message
        $response = [
            'status' => 'success',
            'message' => 'Payment successful!',
            'payment_intent_id' => $paymentIntent->id
        ];

        echo json_encode($response);
    } catch (\Stripe\Exception\CardException $e) {
        // Handle specific card errors
        $response = [
            'status' => 'error',
            'message' => 'Payment declined: ' . $e->getMessage()
        ];

        echo json_encode($response);
    } catch (\Stripe\Exception\RateLimitException $e) {
        // Handle rate limit errors
        $response = [
            'status' => 'error',
            'message' => 'Payment error: Rate limit exceeded'
        ];

        echo json_encode($response);
    } catch (\Stripe\Exception\InvalidRequestException $e) {
        // Handle invalid request errors
        $response = [
            'status' => 'error',
            'message' => 'Payment error: Invalid request'
        ];

        echo json_encode($response);
    } catch (\Stripe\Exception\AuthenticationException $e) {
        // Handle authentication errors
        $response = [
            'status' => 'error',
            'message' => 'Payment error: Invalid authentication'
        ];

        echo json_encode($response);
    } catch (\Stripe\Exception\ApiConnectionException $e) {
        // Handle API connection errors
        $response = [
            'status' => 'error',
            'message' => 'Payment error: API connection failed'
        ];

        echo json_encode($response);
    } catch (\Stripe\Exception\ApiErrorException $e) {
        // Handle other API errors
        $response = [
            'status' => 'error',
            'message' => 'Payment error: API error'
        ];

        echo json_encode($response);
    }
}
?>
