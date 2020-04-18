<html lang="pl">
<head>
<?php
session_start();
include 'includes/db.php';

include 'classes/login.class.php';
include 'classes/register.class.php';
include 'classes/password-reminder.class.php';

if($_POST['login-btn']) {
   $loginAttempt = new Login($_POST);
   $loginAttempt->grantAccess();
   echo '
   <script>
   window.onload = function(){
   document.getElementById("alert").innerText = "'.$loginAttempt->result.'";
   };
   </script>';
}

if($_POST['register-btn']) {
   $register = new Register($_POST);
   $register->createUser();
   echo '
   <script>
   window.onload = function(){
   document.getElementById("alert").innerText = "'.$register->result.'";
   var labelLogin = document.getElementById("login-label");
   var labelRegister = document.getElementById("register-label");
   var fieldLogin = document.getElementById("login");
   var fieldRegister = document.getElementById("register");
   fieldLogin.style.display = "none";
   fieldRegister.style.display = "block";
   labelLogin.style.backgroundColor = "#ffe4c4"
   labelRegister.style.backgroundColor = "white"
   };
   </script>
';
}
?>
   <meta charset="UTF-8">
   <link rel="stylesheet" href="style.css">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Logowanie</title>
</head>
<body>

   <div class="top">
   <label id="login-label" class="topLabel loginLabel">Logowanie</label><label id="register-label" class="topLabel registerLabel">Rejestracja</label>
      <div class="wrapper">
      <div id="alert"></div>
         <form action="index.php" method="post">
            <fieldset id="login">
               <input type="email" name="username" placeholder="Adres email" maxlength="50" required><br>
               <input type="password" name="password" placeholder="Hasło" maxlength="16" required><br>
               <input type="submit" name="login-btn" value="Zaloguj"><br>
               <label id="lost-password">Zapomniałem hasła :(</label>
            </fieldset>
         </form>
         <form action="index.php" method="post">
            <fieldset id="register">
               <input type="email" name="username" id="username" placeholder="Adres email" maxlength="50" required value="<?php echo $_POST['username'] ?? ""  ?>"><br>
               <input type="password" name="password" placeholder="Hasło" maxlength="16" required><br>
               <input type="password" name="password2" placeholder="Powtórz Hasło" maxlength="16" required><br>
               <input type="submit" name="register-btn" value="Zarejestruj"><br>
            </fieldset>
         </form>
         <form action="index.php" method="post">
            <fieldset id="password-reminder">
               <input type="email" name="username" placeholder="Adres email" maxlength="50" required><br>
               <input type="submit" name="password-btn" value="Zresetuj hasło"><br>
            </fieldset>
         </form>
      </div>
   </div>

   <script src="js/script.js"></script>

</body>
</html>