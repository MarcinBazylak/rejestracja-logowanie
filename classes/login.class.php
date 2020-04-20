<?php

class Login {

   public $result;

   private $login;
   private $password;
   private $userId;
   private $time;
   private $userExist;
   private $row;

   public function __construct($data) {

      $this->login = htmlspecialchars($data['username']);
      $this->password = md5(htmlspecialchars($data['password']));
      $this->getData();

   }

   public function grantAccess() {

      if($this->userExist() && $this->isActive()) {
         $_SESSION['logged'] = 1;
         $_SESSION['user_id'] = $this->userId;
         $_SESSION['email'] = $this->login;
         $this->time  = date("d.m.Y H:i:s");
         $this->result = "Pomyślnie zalogowano";
         global $mysqli;
         $mysqli->query("UPDATE users SET last_login='$this->time' WHERE id='$this->userId'");
      }
      return $result;
   }

   private function userExist() {

      if($this->userExist > 0) {
         $this->user_id = $this->row['id'];
         return true;
      } else {
         $this->result = "Błędny login lub hasło";
      }

   }

   private function isActive() {

      if($this->row['active'] == 1) {
         return true;
      } else {
         $this->result = "Konto nieaktywne";
      }

   }

   private function getData() {

      global $mysqli;
      $result = $mysqli->query("SELECT * from users WHERE email='$this->login' && password='$this->password'");
      $this->row = $result->fetch_array(MYSQLI_ASSOC);
      $this->userExist = $result->num_rows;      

   }

}

?>