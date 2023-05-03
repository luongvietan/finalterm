<!DOCTYPE HTML>
<?php
session_start();
include('database.php');

?>
<?php

if (isset($_SESSION['Login Data'])) {
    header('Location: home.php');
}

if (isset($_POST['username']) and isset($_POST['password'])) {
    $user_name = $_POST['username'];
    $pass = $_POST['password'];

    if (strlen($_POST['password']) < 6) {
        echo "<script type='text/javascript'>alert('Password contains at least 6 charaters !');</script>";
    }
    
    $sql_login = "SELECT * FROM account WHERE username = '$user_name' and password = '$pass'";

    $result_login = $database->query($sql_login);

    if ($result_login->num_rows > 0) {

        $_SESSION['Login Data'] = array(
            'status' => 'Logged',
            'username' => $user_name,
        );


?>
        <script type='text/javascript'>
            window.location.href = 'home.php';
            alert("Login success !");
        </script>
<?php
    } else {
        echo "<script type='text/javascript'>alert('Username or password does not match !');</script>";
    }
}
?>

<head>
<link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style1.css">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@700&display=swap">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Kaushan Script'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Amaranth&family=Comfortaa:wght@700&display=swap">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <title>PlantFit. | Log in</title>

    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
    <!-- used to avoid fake favicon requests
    <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon"> -->

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style data-emotion="css-global 18k73yv">

    </style>
</head>

<header>
        <div class="contain" id="myContain">
            <a href="index.php" class="headline">
                <span id="plant">Plant</span>
                <span id="fit">Fit</span>
                <span id="dot">.</span>
            </a>

            <div class="navbar" id="myNavbar">

                <div></div>
                <!-- aria-label="close menu"  -->
                <button class="cancel" data-nav-toggler="">
                    <ion-icon aria-hidden="true" role="img" class="md hydrated"></ion-icon>
                </button>

                <?php
                if (isset($_SESSION['Login Data'])) {
                ?>
                    <a href="home.php" data-nav-link=""> Home</i>
                    </a>
                <?php } ?>

                <a href="aboutus.php" data-nav-link="">About Us</a>

                <a href="https://notepad.pw/code/oOZDpfOl1ey7pgvbnY6i" data-nav-link="">Contact</a>

                <?php
                if (isset($_SESSION['Login Data'])) {
                ?>
                    <div class="dropdown">
                        <a class="dropbtn" href="" data-nav-link="">
                            <?php echo $_SESSION['Login Data']['username'] ?>
                            <i class="fa fa-caret-down"></i>
                        </a>
                        <div class="dropdown-content">
                            <a href="logout.php">Log out</a>
                        </div>
                    </div>
                <?php } ?>

                <?php
                if (!isset($_SESSION['Login Data'])) { ?>
                    <a href="register.php" data-nav-link="">Register</a>
                <?php } ?>

            </div>

            <a href="javascript:void(0);" class="icon-navbar" onclick="myFunction()">
                <ion-icon name="menu-outline"></ion-icon>
            </a>

        </div>

        <script>
            'use strict';
            const navTogglers = document.querySelectorAll("[data-nav-toggler]");
            const navLinks = document.querySelectorAll("[data-nav-link]");
            const navbar = document.querySelector("#myNavbar");

            function myFunction() {
                // showOverlay();

                var x = document.getElementById("myNavbar");
                if (x.className === "navbar") {
                    x.className += " responsive";
                } else {
                    x.className = "navbar";
                }

                var y = document.getElementById("myContain");
                if (y.className === "contain") {
                    y.className += " clicked";
                } else {
                    y.className = "contain";
                }
            }
        </script>
    </header>

<body>

    <!-- DAY LA BODY -->

    <div class="container">
        <h3 class="mt-5 mb-3">Log in</h3>
        <form action="" method="post">
            <div class="form-group" style="padding-top:10px">
                <label for="username" style="padding-bottom:7px">User name:</label>
                <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
            </div>
            <div class="form-group" style="padding-top:10px">
                <label for="password" style="padding-bottom:7px">Password:</label>
                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
                <br>
                <input type="checkbox" onclick="myFunction()">  Show Password
            </div>
            <script>
                function myFunction() {
                    var x = document.getElementById("password");
                    if (x.type === "password") {
                        x.type = "text";
                    } else {
                        x.type = "password";
                    }
                }
            </script>
            <div style="padding-top:10px">
                <input class="btn btn-primary" type="submit" value="Log in">
            </div>

            <div style="padding-top:10px">
                <a href="register.php" data-nav-link="">New comer ? Register now</a>
            </div>
        </form>
    </div>

</body>

<footer>
    <div class="footer-basic">

        <!-- Add icon -->
        <div class="social">
            <a href="#"><i class="icon ion-social-facebook"></i></a>
            <a href="#"><i class="icon ion-social-github"></i></a>
            <a href="#"><i class="icon ion-social-linkedin"></i></a>
            <a href="#"><i class="icon ion-social-chrome"></i></a>
        </div>

        <!-- Div contains text information -->
        <div class="box">
            <!-- Div contains present date, copyright and name of author -->
            <div class="date-box" id="current_date">

                <!-- Change the format of date to dd/mm/year -->
                <script>
                    date = new Date();
                    year = date.getFullYear();
                    month = date.getMonth() + 1;
                    day = date.getDate();
                    // Create a string contains current date
                    document.getElementById("current_date").innerHTML = twoNumbers(day) + "/" + twoNumbers(month) + "/" + year;

                    // If the number is lower than 10 return the string that added zero elemnent before it 
                    function twoNumbers(number) {
                        if (number < 10) {
                            return "0" + number;
                        }
                        return number;
                    }
                </script>

                <!-- Paragraph contains present date, copyright and name of author -->
                <p class="copyright">| Copyright ©2023 | Final-Project</p>
            </div>
        </div>
    </div>
</footer>