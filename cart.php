<?php

session_start();

$message = '';

if (isset($_POST['btnAction'])) {

    switch ($_POST['btnAction']) {

        case 'add':
            
            if (is_numeric(openssl_decrypt($_POST['id'],code,key))) {
                $id = openssl_decrypt($_POST['id'],code,key);
                $message.= "Ok id <br>";
            } else {    $message.= "Error.. id incorrecto <br>"; }

                if (is_string(openssl_decrypt($_POST['name'],code,key))) {
                    $name = openssl_decrypt($_POST['name'],code,key);
                    $message.= "Ok, nombre <br> ";
                } else {     $message.= "Ups... algo pasa con el nombre <br>"; break; }

                if (is_numeric(openssl_decrypt($_POST['quantity'],code,key))) {
                    $quantity = openssl_decrypt($_POST['quantity'],code,key);
                    $message.= 'Ok, cantidad es : '.$quantity."<br>";
                } else {    $message.= "Ups... algo pasa con la cantidad <br>"; break; }

                if (is_numeric(openssl_decrypt($_POST['price'],code,key))) {
                    $price = openssl_decrypt($_POST['price'],code,key);
                    $message.= 'Ok, el precio es : '.$price."<br>";
                } else {    $message.= "Ups... algo pasa con el precio <br>"; break; }

            if ( !isset($_SESSION['cart'])) {
                $product = array(
                    'id' => $id,
                    'name' => $name,
                    'quantity' => $quantity,
                    'price' => $price
                );

                $_SESSION['cart'][0] =  $product;
                $message = "Producto agregado al carro.";
                
            } else {

                $productId = array_column($_SESSION['cart'], 'id');

                if(in_array($id, $productId)) {
                    echo "<script> alert('El producto ya ha sido seleccionado') </script>";
                    
                } else {

                    $productNumber = count($_SESSION['cart']);
                    $product = array(
                        'id' => $id,
                        'name' => $name,
                        'quantity' => $quantity,
                        'price' => $price
                    );

                    $_SESSION['cart'][$productNumber] =  $product;
                    $message = "Producto agregado al carro.";
                }
            }

            //$message = print_r($_SESSION, true);
            $message = "Producto agregado al carro.";

        break;

        case 'delete':
            if (is_numeric(openssl_decrypt($_POST['id'],code,key))) {
                $id = openssl_decrypt($_POST['id'],code,key);
                
                foreach ($_SESSION['cart'] as $index => $product) {
                    if ($product['id'] == $id) {
                        unset($_SESSION['cart'][$index]);

                        echo "<script> alert('Elemento borrado.') </script>";
                    }
                }

            } else {    $message.= "Error.. id incorrecto <br>"; }

            break;
    }
}
?> 