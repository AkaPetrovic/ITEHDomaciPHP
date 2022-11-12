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
     
        public static function add($id, $proizvodjac_id, $model, $godiste, mysqli $conn)
        {
            $q = "INSERT INTO automobil(id, proizvodjac_id, model, godiste) values('$id', '$proizvodjac_id', '$model', '$godiste')";
            return $conn->query($q);
        }

        public static function update($id, $proizvodjac_id, $model, $godiste, mysqli $conn)
        {
            $q = "UPDATE automobil SET proizvodjac_id='$proizvodjac_id', model='$model', godiste='$godiste' WHERE id='$id'";
            return $conn->query($q);
        }
     }
?>