<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 50%;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background: #5cb85c;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background: #4cae4c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Checkout</h2>
        <form id="checkout-form">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="address">Adresse</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="payment">Zahlungsmethode</label>
                <select id="payment" name="payment" required>
                    <option value="credit-card">Kreditkarte</option>
                    <option value="paypal">PayPal</option>
                </select>
            </div>
            <button type="submit" class="btn">Bezahlen</button>
        </form>
    </div>
    <script>
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Zahlung erfolgreich!');
        });
    </script>
</body>
</html>
