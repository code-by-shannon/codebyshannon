<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars(trim($_POST["name"]));
    $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $comment = htmlspecialchars(trim($_POST["comment"]));

    $to      = "build@codebyshannon.com"; // Change to your email
    $subject = "New inquiry from $name";
    $message = "Name: $name\nEmail: $email\n\nMessage:\n$comment";

    $headers = "From: $name <$email>";

    if (mail($to, $subject, $message, $headers)) {
        header("Location: thankyou.html");
        exit;
    } else {
        echo "Oops, something went wrong. Try again later.";
    }
} else {
    echo "You shouldn’t be here.";
}
?>
