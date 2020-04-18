<?php

class Login {

   private $login;
   private $password;
   public $result;

   public function __construct($data) {

      $this->login = htmlspecialchars($data['username']);
      $this->password = md5(htmlspecialchars($data['password']));

   }

   public function grantAccess() {

      global $link;

      $query = mysqli_query($link, "SELECT * from users WHERE email='$this->login'");
      $result = mysqli_fetch_array($query);
      $userExist = mysqli_num_rows($query);

      if($userExist > 0) {
         if($this->password == $result['password']) {
            $_SESSION['logged'] = 1;
            $this->result = "Pomyślnie zalogowano";
         } else {
            $this->result = "Nieprawidłowe hasło";
         }
      } else {
         $this->result = "Użytkownik nie został rozpoznany";
      }
      return $result;
   }

}

?>