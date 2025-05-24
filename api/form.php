<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar con Stripe</title>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="number"],
        #card-element {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: rgb(12, 74, 141);
        }

        #payment-message {
            margin-top: 20px;
            color: red;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Pago con Stripe</h1>
        <form id="payment-form" action="index.php" method="POST">
            <label for="amount">Cantidad a pagar (€):</label>
            <?php
            session_start();
            $amount = isset($_SESSION['total']) ? $_SESSION['total'] : 0;
            ?>
            <input type="number" id="amount" name="amount" min="1" step="0.01" value="<?php echo $amount; ?>" required readonly>

            <div id="card-element"></div>

            <input type="hidden" id="payment_method" name="payment_method">

            <button type="submit" id="submit-button">Pagar</button>
            <div id="payment-message"></div>
        </form>
    </div>

    <script>
        const stripe = Stripe('pk_test_51QuH1FHz6qV6p936NR7iRYFkptlbC4TjDvt8KerlFZwjzi8bdJq68wE1XRpSi5r9frFwmB9QT0lrkC98dNYWtiiN004Ml92wnq');
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const {
                paymentMethod,
                error
            } = await stripe.createPaymentMethod({
                type: 'card',
                card: cardElement,
            });

            if (error) {
                document.getElementById('payment-message').innerText = error.message;
                return;
            }

            document.getElementById('payment_method').value = paymentMethod.id;
            form.submit();
        });
    </script>
</body>

</html>