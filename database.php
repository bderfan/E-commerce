<?php

function db_connection(){
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'login_page';

    $connection = mysqli_connect($hostname, $username, $password, $database);
    #$Database_error = mysqli_connect_error($Connection);
    
    if(!$connection){
        die('Database Error: '.mysqli_connect_error($connection));
    }
    
    return $connection;
}
   




?>