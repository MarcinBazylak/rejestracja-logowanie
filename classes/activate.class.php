<?php

class ActivateUser {

   public $result;
   
   private $userId;
   private $row;

   public function __construct($data) {

      $this->userId = htmlspecialchars($data['verify_id']);
      $this->getData($this->userId);

   }

   public function activate() {

      if($this->userExist() && $this->isInactive()) {
         global $mysqli;
         $this->result = "Pomyślnie aktywowano konto";
         $mysqli->query("UPDATE users SET active='1' WHERE id='$this->userId'");
      }

   }

   private function isInactive() {

      if($this->row['active'] == 0) {
         return true;
      } else {
         $this->result = 'To konto już jest aktywne';
      }

   }

   private function userExist() {

      if($this->userExist > 0) {
         return true;
      } else {
         $this->result = "Taki użytkownik nie istnieje";
      }

   }

   private function getData($id) {

      global $mysqli;
      $result = $mysqli->query("SELECT * from users WHERE id='$id'");
      $this->row = $result->fetch_array(MYSQLI_ASSOC);
      $this->userExist = $result->num_rows;
   }

}

?>