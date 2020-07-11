<?php

$host = "mysql:dbname=".db_name.";host=".db_host;

try {
    $pdo = new PDO($host,db_user,db_pass, array( PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    //echo "<script> alert('Conectado...') </script>"; 
    
} catch (PDOException $e) {
    //echo "<script> alert('Error...') </script>";
}

?>