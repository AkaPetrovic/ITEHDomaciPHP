<?php
   class Proizvodjac{
        public $id;
        public $naziv;

        public function __construct($id = null, $naziv = null){
            $this->id = $id;
            $this->naziv = $naziv;
        }

        public static function getAll(mysqli $conn)
         {
             $q = "SELECT * FROM proizvodjac";
             return $conn->query($q);
         }
   }
?>