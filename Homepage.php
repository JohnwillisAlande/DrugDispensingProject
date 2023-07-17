<!DOCTYPE html>
<html>

<head>
    <title>Dispensary Homepage</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f1f1f1;
    }

    #header {
        background-color: #333;
        color: #fff;
        padding: 20px;
        text-align: center;
        display: 'flex';
        justify-content: 'center';
        flex-direction: 'row';
        align-items: 'center'

    }

    #header .buttons {
        text-align: center;

    }

    #header .buttons a {
        color: #fff;
        text-decoration: none;
        margin-left: 10px;
        text-align: center;

    }

    #content {
        margin: 20px;
    }

    h1 {
        color: #fff;
    }

    p {
        color: #555;
    }
    </style>
</head>

<body>
    <div id="header">
        <h1>Welcome to Our Dispensary</h1>
        <div class="buttons">
            <a href="CreateUser.html">Sign Up</a>
            <a href="login.html">Sign In</a>
        </div>
    </div>

    <div id="content">
        <h2>About Us</h2>
        <p>
            <?php echo "Welcome to Our Dispensary make prescriptions and connect pharmacys and pharmaceutcal companies"; ?>
        </p>


        <h2>Contact Us</h2>
        <p>Email: info@example.com</p>
        <p>Phone: 123-456-7890</p>
    </div>
</body>

</html>