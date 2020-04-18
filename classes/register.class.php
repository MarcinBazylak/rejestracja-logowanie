<?php

class Register {

   private $login;
   private $password;
   private $password2;
   private $time;
   public $result;


   public function __construct($data) {

      $this->login = htmlspecialchars($data['username']);
      $this->password = md5(htmlspecialchars($data['password']));
      $this->password2 = md5(htmlspecialchars($data['password2']));

   }

   public function createUser() {

      global $link;

      if($this->checkPasswords($this->password, $this->password2) && $this->isUsrnmFree($this->login)) {
         
         $this->time  = date("d.m.Y H:i:s");

         $query = "INSERT INTO users VALUES ('', '$this->login', '$this->password', '$this->time')";
         $go = mysqli_query($link, $query);
         $this->result = 'Pomyślnie zarejestrowano użytkownika';

      }

   }

   private function checkPasswords($pass1, $pass2) {

      if ($pass1 == $pass2) {
         return true;
      } else {
         $this->result = 'Oba hasła muszą być identyczne';
      }

   }

   private function isUsrnmFree($username) {

      global $link;

      $query = mysqli_query($link, "SELECT * from users WHERE email='$username'");
      $userExist = mysqli_num_rows($query);

      if($userExist == 0) {
         return true;
      } else {
         $this->result = 'Ten adres email już istnieje w naszej bazie danych';
      }

   }

}

?>