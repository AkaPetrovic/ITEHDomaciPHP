<?php
require "../dbBroker.php";
require "../model/automobil.php";

if (isset($_POST['id']) && isset($_POST['proizvodjaci']) && isset($_POST['model']) && isset($_POST['godiste'])) {
    $result = Automobil::add($_POST['id'], $_POST['proizvodjaci'], $_POST['model'], $_POST['godiste'], $conn);
    if ($result) {
        echo 'Success';
    } else {
        echo 'Failed';
    }
}