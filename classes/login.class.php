<?php

class Login {

   private $login;
   private $password;
   private $time;
   public $result;

   public function __construct($data) {

      $this->login = htmlspecialchars($data['username']);
      $this->password = md5(htmlspecialchars($data['password']));

   }

   public function grantAccess() {

      global $mysqli;

      $result = $mysqli->query("SELECT * from users WHERE email='$this->login'");
      $row = $result->fetch_array(MYSQLI_ASSOC);
      $userExist = $result->num_rows;

      if($userExist > 0) {
         if($this->password == $row['password']) {
            $_SESSION['logged'] = 1;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $this->time  = date("d.m.Y H:i:s");
            $this->result = "Pomyślnie zalogowano";
            $mysqli->query("UPDATE users SET last_login='$this->time' WHERE id='$row[id]'");
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