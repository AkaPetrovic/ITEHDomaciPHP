<?php
require "../dbBroker.php";
require "../model/automobil.php";

if (isset($_POST['id'])){
    $result = Automobil::deleteById($_POST['id'], $conn);
    if($result){
        echo 'Success';
    }else{
        echo 'Failed';
    }
}