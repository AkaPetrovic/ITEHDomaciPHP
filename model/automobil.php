<?php
     class Automobil
     {
         public $id;
         public $proizvodjac_id;
         public $model;
         public $godiste;
     
         public function __construct($id = null, $proizvodjac_id = null, $model = null, $godiste = null)
         {
             $this->id = $id;
             $this->proizvodjac_id = $proizvodjac_id;
             $this->model = $model;
             $this->godiste = $godiste;
         }
     
         public static function getAll(mysqli $conn)
         {
             $q = "SELECT * FROM automobil";
             return $conn->query($q);
         }
         public static function deleteById($id, mysqli $conn)
         {
             $q = "DELETE FROM automobil WHERE id=$id";
             return $conn->query($q);
         }
     
         public static function add($proizvodjac_id, $model, $godiste, mysqli $conn)
         {
             $q = "INSERT INTO automobil(proizvodjac_id, model, godiste) values('$proizvodjac_id', '$model', '$godiste')";
             return $conn->query($q);
         }
     }
?>