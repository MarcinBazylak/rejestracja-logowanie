<?php

class PasswordReminder {

   private $email;
   private $emailSubject;
   private $emailContent;
   private $userId;

   public function __construct ($data) {

      $this->email = htmlspecialchars($data['username']);

   }

   private function emailExist () {

      global $mysqli;
      $result = $mysqli->query("SELECT * from users WHERE email='$this->email'");
      $row = $result->fetch_array(MYSQLI_ASSOC);
      $userExist = $result->num_rows;

      if($userExist > 0) {
         $this->userId = $row['id'];
         $this->result = 'Wysłano link resetujący hasło';
         return true;
      } else {
         $this->result = 'Adres nie został odnaleziony';
      }

   }

   public function sendEmail() {

      if($this->emailExist()) {

         $this->emailSubject = 'Zresetuj swoje hsło w serwisie'; // Esytuj tę linijkę dostosowując ją do swoich potrzeb
         $this->emailContent = 'Aby zresetować hasło w serwisie, przejdź pod poniższy adres:' . "\r\n\r\n" . 'http://localhost:3000/reset-password.php?id=' . $this->userId;
         mail($this->email, $this->emailSubject, $this->emailContent, 'From: Mój serwis <biuro@motolux.cba.pl>' . "\r\n" . 'Content-Type: text/plain; charset=utf-8' . "\r\n"); // Esytuj tą linijkę dostosowując ją do swoich potrzeb

      } else {
         return $this->result;
      }
      
   }
  
}

?>