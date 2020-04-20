<?php

class Register {

   private $login;
   private $password;
   private $password2;
   private $time;
   private $id;
   public $result;

   private $emailSubject;
   private $emailContent;

   public function __construct($data) {

      $this->login = htmlspecialchars($data['username']);
      $this->password = md5(htmlspecialchars($data['password']));
      $this->password2 = md5(htmlspecialchars($data['password2']));

   }

   public function createUser() {

      global $mysqli;

      if($this->checkPasswords($this->password, $this->password2) && $this->isUsrnmFree($this->login)) {
         
         $this->time  = date("d.m.Y H:i:s");

         $mysqli->query("INSERT INTO users VALUES ('', '', '$this->login', '$this->password', '$this->time', '')");
         $this->id = $mysqli->insert_id;
         $this->result = 'Pomyślnie zarejestrowano użytkownika';
         $this->sendEmail($this->login, $this->id);

      }

   }

   private function checkPasswords($pass1, $pass2) { // sprawdzenie czy wpisane hasła sa jednakowe

      if ($pass1 == $pass2) {
         return true;
      } else {
         $this->result = 'Oba hasła muszą być identyczne';
      }

   }

   private function isUsrnmFree($username) { // sprawdzenie czy wpisana nazwa użytkownika/adres email nie ejst zajęta

      global $mysqli;

      $result = $mysqli->query("SELECT * from users WHERE email='$username'");
      $row = $result->fetch_array(MYSQLI_ASSOC);
      $userExist = $result->num_rows;

      if($userExist == 0) {
         return true;
      } else {
         $this->result = 'Ten adres email już istnieje w naszej bazie danych';
      }

   }

   private function sendEmail($email, $id) { // wysłanie emaila z linkeim weryfikującym adres

      $this->emailSubject = 'Potwierdź swoją rejestrację w serwisie'; // Esytuj tę linijkę dostosowując ją do swoich potrzeb
      $this->emailContent = 'Kliknij w poniższy link aby potwierdzić swoją rejestrację w serwisie' . "\r\n" . 'http://localhost:3000/index.php?verify_id='.$id; // Esytuj tę linijkę dostosowując ją do swoich potrzeb
      mail($email, $this->emailSubject, $this->emailContent, 'From: Mój serwis <biuro@motolux.cba.pl>' . "\r\n" . 'Content-Type: text/plain; charset=utf-8' . "\r\n"); // Esytuj tę linijkę dostosowując ją do swoich potrzeb

   }

}

?>