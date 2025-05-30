<?php 
include 'DBConnector.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Registration | ToyDex</title>
</head>
<body class="register">
    <section class="home">
        <header>
            <div class="main-header">
                <h1 class="toydex-logo">TOYDEX</h1>
            </div>
            <div class="divider"></div>
        </header> 
    </section>

    <section class="register-user-container">
        <div class="register-user">
            <h1>Registration</h1>
            <form method="post" action="registration.php" >
                <div class="form-group">
                    <label for="username">Username </label>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>

                <div class="form-group">
                    <input type="submit" value="Register" name="submit">
                    <button type="cancel" onclick="window.location.href='registration.php'">Cancel</button>
                </div>
            </form>
        </div>
    </section>

    <footer>
        <div class="logo">
            <img src="images/logo.png">
            <h1>TOYDEX</h1>
        </div>
        <div class="labels">
            <div class="label">
                <h2>Community</h2>
                <a href="#">Support</a>
                <a href="#">Help</a>
            </div>
            <div class="label">
                <h2>Overview</h2> 
                <a href="#">Contact</a>
                <a href="#">Terms of Use</a>
                <a href="#">Privacy Policy</a>
            </div>
            <div class="label">
                <h2>Follow Us</h2> 
                <div class="icons">
                    <a href="#"><img src="images/facebook-svgrepo-com.svg"></a>
                    <a href="#"><img src="images/youtube-svgrepo-com.svg"></a>
                    <a href="#"><img src="images/discord-fill-svgrepo-com.svg"></a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>