<?php
session_start(); // Session shuru karna lazmi hai
include "config.php"; // Database connection

$message = "";

if (isset($_POST['login'])) {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // 1. Database se user ko email ke zariye dhoondna
    $sql = "SELECT user_id, name, email, password, user_type FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // 2. Password check karna (Hashed password verify karna)
        if (password_verify($password, $user['password'])) {
            
            // 3. Login kamyab! Session mein data save karein
            $_SESSION['user_id']   = $user['user_id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_type'] = $user['user_type'];

            // Dashboard par bhej dein
            header("Location: index.php");
            exit();

        } else {
            $message = "<div class='alert alert-danger'>Invalid email or password!</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>Invalid email or password!</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EC+ | Login</title>
    <link href="assets/css/mainCSS/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/mainCSS/font-awesome.css" rel="stylesheet">
    <link href="assets/css/mainCSS/animate.css" rel="stylesheet">
    <link href="assets/css/mainCSS/style.css" rel="stylesheet">
</head>

<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div><h1 class="logo-name">EC+</h1></div>
            <h3>Welcome to Ecommerce</h3>
            <p>Login in to see it in action.</p>
            
            <?php echo $message; ?>

            <form class="m-t" role="form" method="POST" action="login.php">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="">
                </div>
                <button type="submit" name="login" class="btn btn-primary block full-width m-b">Login</button>

                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="register.php">Create an account</a>
            </form>
            <p class="m-t"> <small>Ecommerce &copy; 2026</small> </p>
        </div>
    </div>

    <script src="assets/js/mainScript/jquery-3.1.1.min.js"></script>
    <script src="assets/js/mainScript/bootstrap.js"></script>
</body>
</html>