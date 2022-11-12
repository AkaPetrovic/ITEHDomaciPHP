<?php
require "../dbBroker.php";
require "../model/automobil.php";

if (isset($_POST['id']) && isset($_POST['proizvodjac_id']) && isset($_POST['model']) && isset($_POST['godiste'])) {
    $result = Automobil::update($_POST['id'], $_POST['proizvodjac_id'], $_POST['model'], $_POST['godiste'], $conn);
    if ($result) {
        echo 'Success';
    } else {
        echo 'Failed';
    }
}