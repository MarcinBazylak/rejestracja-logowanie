<?php

   class ResetPassword {

      private $id;
      private $email;
      private $password1;
      private $password2;
      public $result;

      public function __construct ($data) {

         $this->id = htmlspecialchars($data['user-id']);
         $this->email = htmlspecialchars($data['username']);
         $this->password1 = md5(htmlspecialchars($data['password']));
         $this->password2 = md5(htmlspecialchars($data['password2']));

      }

      public function resetPassword() {

         if($this->checkPasswords($this->password1, $this->password2) && $this->checkEmailMatchId($this->id, $this->email)) {

            global $mysqli;

            $mysqli->query("UPDATE users SET password='$this->password1' WHERE id='$this->id'");
            $this->result = 'Hasło zostało pomyślnie zmienione<br><a href=\"index.php\">Wróć na stronę logowania</a>';
         }

         return $this->result;

      }

      private function checkPasswords($pass1, $pass2) { // sprawdzenie czy wpisane hasła są jednakowe

         if($pass1 == $pass2) {
            return true;
         } else {
            $this->result = 'Hasła muszą być jednakowe<br><a href=\"reset-password.php?id='. $this->id .'\">Powrót</a>';
         }

      }

      private function checkEmailMatchId($id, $email) { //sprawdzenie czy wpisany email zgadza się z user ID

         global $mysqli;

         $result = $mysqli->query("SELECT * from users WHERE id='$this->id'");
         $row = $result->fetch_array(MYSQLI_ASSOC);
         $userExist = $result->num_rows;

         if($userExist > 0) {
            if($row['id'] == $this->id && $row['email'] == $this->email) {
               return true;
            } else {
               $this->result = 'Dane, które wprowadziłeś są nieprawidłowe<br><a href=\"reset-password.php?id='. $this->id .'\">Powrót</a>';
            }
         } else {
            $this->result = 'Użytkownik o takim identyfikatorze nie istnieje<br><a href=\"reset-password.php?id='. $this->id .'\">Powrót</a>';
         }

      }

   }

?>