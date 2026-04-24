<?php
session_start(); // Purane session ko pehchanne ke liye start karna lazmi hai
session_unset(); // Saare session variables ko khali karne ke liye
session_destroy(); // Session ko mukammal khatam karne ke liye

// Session khatam karne ke baad user ko login page par bhej dein
header("Location: login.php");
exit();
?>