<?php
$showError = "false";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "_dbConnect.php";
    $email = $_POST["loginEmail"];
    $pass = $_POST["loginPass"];

    $sql = "SELECT * FROM users WHERE user_email='$email'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    if ($numRows == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($pass, $row["user_pass"])) {
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["userEmail"] = $email;
            $_SESSION["userName"] = $row["user_name"];

            header("Location: /forum/index.php");
            exit();
        } else {
            echo $showError = "Invalid Credentials!";
        }
    } else {
        echo $showError = "Invalid Credentials!";
    }
    header("Location: /forum/index.php?error=$showError");
}