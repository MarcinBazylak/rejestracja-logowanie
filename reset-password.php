<?php
session_start();

include 'includes/db.php';
include 'classes/reset-password.class.php';

if($_POST['reset']) {
   if ($_SESSION['logged'] == 1) {
      echo '<div class="alert">Jesteś zalogowany jako ' . $_SESSION['email'] . '<br><a href="index.php?logout=1">Wyloguj się</a></div>';
   } else {
      $resetPass = new ResetPassword($_POST);
      $resetPass->resetPassword();
      echo '
      <script>
      window.onload = function(){
      document.getElementById("alert").innerHTML = "'.$resetPass->result.'";
      document.getElementById("reset-pass").innerText = "";
      };
      </script>';
   }
}

?>

<html lang="pl">
<head>
   <meta charset="UTF-8">
   <link rel="stylesheet" href="style.css">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Reset Password</title>
</head>
<body>
<div class="top">
   <label class="topLabel loginLabel">Resetowanie hasła</label>
   <div class="wrapper">
   <?php
   if ($_SESSION['logged'] == 1) {
      echo '
      <div class="alert">Jesteś zalogowany jako ' . $_SESSION['email'] . '<br><a href="index.php?logout=1">Wyloguj się</a></div>';
   } else {
      echo'   <div id="alert" class="alert"></div>
      <form action="reset-password.php" method="post">
         <fieldset id="reset-pass">
            <input type="hidden" name="user-id" value="' . htmlspecialchars($_GET['id']) . '">
            <input type="email" name="username" placeholder="Podaj Adres Email" maxlength="50" required autocomplete="off"><br>
            <input type="password" name="password" placeholder="Nowe Hasło" maxlength="16" required autocomplete="new-password"><br>
            <input type="password" name="password2" placeholder="Powtórz Nowe Hasło" maxlength="16" required autocomplete="new-password"><br>
            <input type="submit" name="reset" value="Zapisz nowe hasło"><br>
         </fieldset>
      </form>';
   }
   ?>

   </div>
</body>
</html>