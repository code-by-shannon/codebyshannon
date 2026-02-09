<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // --- Input ---
    $nameRaw  = trim($_POST["name"] ?? '');
    $emailRaw = trim($_POST["email"] ?? '');
    $comment  = htmlspecialchars(trim($_POST["comment"] ?? ''), ENT_QUOTES, 'UTF-8'); // keep encoded for safety

    // --- Basic validation / cleanup ---
    $name  = htmlspecialchars($nameRaw, ENT_QUOTES, 'UTF-8');
    $email = filter_var($emailRaw, FILTER_VALIDATE_EMAIL) ? $emailRaw : '';

    // Prevent header injection (no CR/LF in header fields)
    $nameForHeader  = preg_replace("/[\r\n]+/", " ", htmlspecialchars_decode($name, ENT_QUOTES));
    $emailForHeader = preg_replace("/[\r\n]+/", "", $email);

    if (!$emailForHeader) {
        exit("Invalid email.");
    }

    // --- Recipient & sender setup ---
    $to        = "build@codebyshannon.com";           // where you receive the message
    $fromEmail = "build@codebyshannon.com";           // must be your domain (DKIM/SPF/DMARC alignment)
    $fromName  = "Code by Shannon";

    // --- Human-facing content (decode entities for the email body/subject) ---
    $nameHuman    = htmlspecialchars_decode($name, ENT_QUOTES);
    $commentHuman = htmlspecialchars_decode($comment, ENT_QUOTES);

    $subject = "New inquiry from $nameHuman";
    $message = "Name: $nameHuman\nEmail: $emailForHeader\n\nMessage:\n$commentHuman";

    // --- Headers (UTF-8, proper From/Reply-To) ---
    $headers  = "From: $fromName <{$fromEmail}>\r\n";
    $headers .= "Reply-To: $emailForHeader\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // --- Send (set envelope sender with -f for SPF alignment) ---
    if (mail($to, $subject, $message, $headers, "-f {$fromEmail}")) {
        header("Location: thankyou.html");
        exit;
    } else {
        echo "Oops, something went wrong. Try again later.";
    }
} else {
    echo "You shouldn’t be here.";
}
