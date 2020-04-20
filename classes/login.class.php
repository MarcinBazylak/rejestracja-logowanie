<?php

class Login {

   private $login;
   private $password;
   private $userId;
   private $time;
   private $userExist;
   public $result;

   public function __construct($data) {

      $this->login = htmlspecialchars($data['username']);
      $this->password = md5(htmlspecialchars($data['password']));

   }

   public function grantAccess() {

      if($this->userExist()) {
         global $mysqli;
         $_SESSION['logged'] = 1;
         $_SESSION['user_id'] = $this->userId;
         $_SESSION['email'] = $this->login;
         $this->time  = date("d.m.Y H:i:s");
         $this->result = "Pomyślnie zalogowano";
         $mysqli->query("UPDATE users SET last_login='$this->time' WHERE id='$this->userId'");
      }
      return $result;
   }

   private function userExist() {
      
      global $mysqli;

      $result = $mysqli->query("SELECT * from users WHERE email='$this->login' && password='$this->password'");
      $row = $result->fetch_array(MYSQLI_ASSOC);
      $this->userExist = $result->num_rows;

      if($this->userExist > 0) {
         $this->user_id = $row['id'];
         return true;
      } else {
         $this->result = "Błędny login lub hasło";
      }

   }

}

?>