<!--

W katalogu głównym utwórz folder o nazwie 'includes', a w nim plik o nazwie 'db.php'
W pliku umieść następujący wpis w celu połączenia z bazą mysql:


$mysqli = new mysqli("server_address", "username", "password", "database");
$mysqli->set_charset("utf8");

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(4) NOT NULL,
  `active` int(1) NOT NULL DEFAULT 0,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(50) COLLATE utf8_bin NOT NULL,
  `created` date NOT NULL,
  `last_login` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;
--
-- koniec
--

-->

<?php
session_start();
if ($_GET['logout'] == 1) {
   unset($_SESSION['logged']);
   unset($_SESSION['email']);
   unset($_SESSION['user_id']);
}

include 'includes/db.php';
include 'classes/login.class.php';
include 'classes/activate.class.php';
include 'classes/register.class.php';
include 'classes/password-reminder.class.php';

if($_POST['login-btn']) {
   $loginAttempt = new Login($_POST);
   $loginAttempt->grantAccess();
   echo '
   <script>
   window.onload = function(){
   document.getElementById("alert").innerHTML = "'.$loginAttempt->result.'";
   };
   </script>';
}

if($_POST['register-btn']) {
   $register = new Register($_POST);
   $register->createUser();
   echo '
   <script>
   window.onload = function(){
   document.getElementById("alert").innerHTML = "'.$register->result.'";
   var labelLogin = document.getElementById("login-label");
   var labelRegister = document.getElementById("register-label");
   var fieldLogin = document.getElementById("login");
   var fieldRegister = document.getElementById("register");
   fieldLogin.style.display = "none";
   fieldRegister.style.display = "block";
   labelLogin.style.backgroundColor = "#ffe4c4"
   labelRegister.style.backgroundColor = "white"
   };
   </script>';
}

if($_POST['password-btn']) {
   $resetPassword = new PasswordReminder($_POST);
   $resetPassword->sendEmail();
   echo '
   <script>
   window.onload = function(){
   document.getElementById("alert").innerHTML = "'.$resetPassword->result.'";
   };
   </script>';
}

if(!empty($_GET['verify_id'])) {

$activate = new ActivateUser($_GET);
$activate->activate();
echo '
<script>
window.onload = function(){
document.getElementById("alert").innerHTML = "'.$activate->result.'";
};
</script>';

}

?>
<html lang="pl">
<head>
   <meta charset="UTF-8">
   <link rel="stylesheet" href="style.css">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Logowanie</title>
</head>
<body>
   <div class="top">
   <label id="login-label" class="topLabel loginLabel">Logowanie</label><label id="register-label" class="topLabel registerLabel">Rejestracja</label>
      <div class="wrapper">      
      <?php 
      if ($_SESSION['logged'] == 1) {
         echo '<div class="alert">Jesteś zalogowany jako ' . $_SESSION['email'] . '<br><a href="index.php?logout=1">Wyloguj się</a></div>';
      } else {
         echo'   <div id="alert" class="alert"></div>
         <form action="index.php" method="post">
            <fieldset id="login">
               <input type="email" name="username" placeholder="Adres email" maxlength="50" required autocomplete="username"><br>
               <input type="password" name="password" placeholder="Hasło" maxlength="16" required autocomplete="current-password"><br>
               <input type="submit" name="login-btn" value="Zaloguj"><br>
               <label id="lost-password">Zapomniałem hasła :(</label>
            </fieldset>
         </form>
         <form action="index.php" method="post">
            <fieldset id="register">
               <input type="email" name="username" id="username" placeholder="Adres email" maxlength="50" required value="' . $_POST['username'] . '" autocomplete="username"><br>
               <input type="password" name="password" placeholder="Hasło" maxlength="16" required autocomplete="new-password"><br>
               <input type="password" name="password2" placeholder="Powtórz Hasło" maxlength="16" required autocomplete="new-password"><br>
               <input type="submit" name="register-btn" value="Zarejestruj"><br>
            </fieldset>
         </form>
         <form action="index.php" method="post">
            <fieldset id="password-reminder">
               <input type="email" name="username" placeholder="Adres email" maxlength="50" required autocomplete="username"><br>
               <input type="submit" name="password-btn" value="Zresetuj hasło"><br>
            </fieldset>
         </form>';
      }
      ?>

      </div>
   </div>
   <script src="js/script.js"></script>
</body>
</html>
<?php $mysqli->close(); ?>