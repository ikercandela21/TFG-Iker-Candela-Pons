<?php
require 'api/vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51QuH1FHz6qV6p9368kH31umEi6foRbt1TSq142XEcq8CYNEgYQHrMTqPTnaDsH2ZGmpr31P99jBN8dpWc3jjN9od00CgGss2m2');

try {
    $balance = \Stripe\Balance::retrieve();
    if (!empty($balance->available) && isset($balance->available[0]->amount, $balance->available[0]->currency)) {
        $amount = $balance->available[0]->amount / 100;
        $currency = strtoupper($balance->available[0]->currency);

        echo json_encode([
            'available' => $amount,
            'currency' => $currency
        ]);
    } else {
        http_response_code(404);
        echo json_encode([
            'error' => 'No hay saldo disponible en Stripe'
        ]);
    }
} catch (Exception $e) {
    // Mostrar el mensaje de error real
    http_response_code(500);
    echo json_encode([
        'error' => 'Error al obtener el saldo de Stripe',
        'mensaje' => $e->getMessage()
    ]);
}
