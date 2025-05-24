<?php
require 'vendor/autoload.php';

// Configurar la clave de API secreta de Stripe
\Stripe\Stripe::setApiKey('sk_test_51QuH1FHz6qV6p9368kH31umEi6foRbt1TSq142XEcq8CYNEgYQHrMTqPTnaDsH2ZGmpr31P99jBN8dpWc3jjN9od00CgGss2m2');

// Procesar la solicitud de pago
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
    $paymentMethod = $_POST['payment_method'] ?? '';

    if ($amount <= 0 || empty($paymentMethod)) {
        die("Error: Cantidad inválida o método de pago no recibido.");
    }

    try {
        // Convertir a céntimos (Stripe usa la unidad más pequeña)
        $amountInCents = intval($amount * 100);

        // Crear un Intento de Pago
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $amountInCents,
            'currency' => 'eur',
            'payment_method' => $paymentMethod,
            'confirm'=>true,
            'automatic_payment_methods' => [
                'enabled' => true,
                'allow_redirects' => 'never'
            ],
        ]);

        $message = "¡Pago realizado con éxito! ID: " . $paymentIntent->id;
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesar Pago</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .message {
            margin-bottom: 20px;
            font-size: 18px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <a href="../añadirBiblioteca.php" class="button">Volver a inicio</a>
    </div>
</body>
</html>
