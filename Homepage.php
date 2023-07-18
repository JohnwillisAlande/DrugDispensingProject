<!DOCTYPE html>
<html>
    <title>Homepage</title>
    <link rel="stylesheet" href="styles.css">
<head>
    
</head>

<body>
<div class="background-container" style="position: absolute; top: -10; right: 5; padding: 10px;">
    <div class="navbar">
        <img src="images/afyahealth.png" class="logo">
    </div>
    <div class="content">
        <h1>Welcome to Afya Health</h1>
        <h2>About Us</h2>
        <p>Welcome to Our Dispensary make prescriptions and connect pharmacys and pharmaceutcal companies</p>
        <h2>Contact Us</h2>
        <p>Email: info@example.com</p>
        <p>Phone: 123-456-7890</p>

        <div class="button">
        <button onclick="redirectToSignUpPage()"><span></span>Sign Up</button>
        <button onclick="redirectToLoginPage()"><span></span>Log In</button>
        </div>

        <script>
        // JavaScript function to redirect to the login page
        function redirectToSignUpPage() {
            window.location.href = "CreateUser.html";
        }
        function redirectToLoginPage() {
            window.location.href = "login.html";
        }
    </script>
    </div>
</div>
</body>

</html>