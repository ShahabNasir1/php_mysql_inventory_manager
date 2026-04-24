<?php 
include "config.php"; // Database connection file include karein

$message = ""; // Error ya success message dikhane ke liye

if (isset($_POST['register'])) {
    // Data ko clean karna taake security bani rahe
    $name     = mysqli_real_escape_string($conn, $_POST['uName']);
    $email    = mysqli_real_escape_string($conn, $_POST['uEmail']);
    $password = $_POST['uPassword']; // Password hash karne ke liye real_escape zaroori nahi

    // 1. Password hashing (Security ke liye)
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // 2. Check karna ke email pehle se to maujood nahi
    $checkEmail = $conn->query("SELECT email FROM users WHERE email = '$email'");
    
    if ($checkEmail->num_rows > 0) {
        $message = "<div class='alert alert-danger'>Email already exists!</div>";
    } else {
        // 3. Database mein insert karna
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
        
        if ($conn->query($sql)) {
            $message = "<div class='alert alert-success'>Registration Successful! <a href='login.php'>Login here</a></div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EC+ | Register</title>
    <link href="assets/css/mainCSS/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/mainCSS/font-awesome.css" rel="stylesheet">
    <link href="assets/css/mainCSS/animate.css" rel="stylesheet">
    <link href="assets/css/mainCSS/style.css" rel="stylesheet">
</head>

<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <h1 class="logo-name">EC+</h1>
            <h3>Register to Ecommerce</h3>
            <p>Create account to see it in action.</p>
            
            <?php echo $message; ?>

            <form class="m-t" role="form" method="POST" action="register.php">
                <div class="form-group">
                    <input type="text" name="uName" class="form-control" placeholder="Name" required>
                </div>
                <div class="form-group">
                    <input type="email" name="uEmail" class="form-control" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="password" name="uPassword" class="form-control" placeholder="Password" required>
                </div>
                <div class="form-group text-left">
                    <div class="checkbox i-checks">
                        <label> <input type="checkbox" required><i></i> Agree the terms and policy </label>
                    </div>
                </div>
                <button type="submit" name="register" class="btn btn-primary block full-width m-b">Register</button>

                <p class="text-muted text-center"><small>Already have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="login.php">Login</a>
            </form>
        </div>
    </div>

    <script src="assets/js/mainScript/jquery-3.1.1.min.js"></script>
    <script src="assets/js/mainScript/bootstrap.js"></script>
</body>
</html>