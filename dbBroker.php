<?php

    $host = "localhost:3307";
    $db = "automobiliphp";
    $username = "root";
    $password = "";

    $conn = new mysqli($host, $username, $password, $db);

    if($conn->connect_errno){
        exit("Konekcija nije uspostavljena: " . $conn->connect_errno);
    }
?>