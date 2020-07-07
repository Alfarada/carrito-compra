<?php

$message = '';

if (isset($_POST['btnAction'])) {

    switch ($_POST['btnAction']) {
        case 'add':
            
            if (is_numeric(openssl_decrypt($_POST['id'],code,key))) {
                $id = openssl_decrypt($_POST['id'],code,key);
                $message.= "Ok id <br>";
            } else {
                $message.= "Error.. id incorrecto <br>";
            }

            if (is_string(openssl_decrypt($_POST['name'],code,key))) {
                $name = openssl_decrypt($_POST['id'],code,key);
                $message.= 'Ok, nombre :'.$name."<br>";
            } else {
                $message.= "Ups... algo pasa con el nombre <br>"; break;
            }

            if (is_numeric(openssl_decrypt($_POST['quantity'],code,key))) {
                $quantity = openssl_decrypt($_POST['quantity'],code,key);
                $message.= 'Ok, cantidad es : '.$quantity."<br>";
            } else {
                $message.= "Ups... algo pasa con la cantidad <br>"; break;
            }

            if (is_numeric(openssl_decrypt($_POST['price'],code,key))) {
                $price = openssl_decrypt($_POST['price'],code,key);
                $message.= 'Ok, el precio es : '.$price."<br>";
            } else {
                $message.= "Ups... algo pasa con el precio <br>"; break;
            }

            break;
    }
}
?> 