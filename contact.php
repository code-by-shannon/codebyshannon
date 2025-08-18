<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nameRaw  = trim($_POST["name"]);
    $emailRaw = trim($_POST["email"]);
    $comment  = htmlspecialchars(trim($_POST["comment"]), ENT_QUOTES, 'UTF-8'); // keep encoded

    // Basic validation / cleanup
    $name  = htmlspecialchars($nameRaw, ENT_QUOTES, 'UTF-8');
    $email = filter_var($emailRaw, FILTER_VALIDATE_EMAIL) ? $emailRaw : '';

    // Prevent header injection (no CRLF in headers)
    $nameForHeader  = preg_replace("/[\r\n]+/", " ", htmlspecialchars_decode($name, ENT_QUOTES));
    $emailForHeader = preg_replace("/[\r\n]+/", "", $email);

    if (!$emailForHeader) {
        exit("Invalid email.");
    }

    $to = "build@codebyshannon.com";

    // Decode for human-facing parts (subject/body), since they're not HTML
    $nameHuman    = htmlspecialchars_decode($name, ENT_QUOTES);
    $commentHuman = htmlspecialchars_decode($comment, ENT_QUOTES);

    $subject = "New inquiry from $nameHuman";
    $message = "Name: $nameHuman\nEmail: $emailForHeader\n\nMessage:\n$commentHuman";

    // Headers (UTF-8 + safe From/Reply-To)
    $headers  = "From: $nameForHeader <$emailForHeader>\r\n";
    $headers .= "Reply-To: $emailForHeader\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($to, $subject, $message, $headers)) {
        header("Location: thankyou.html");
        exit;
    } else {
        echo "Oops, something went wrong. Try again later.";
    }
} else {
    echo "You shouldn’t be here.";
}

