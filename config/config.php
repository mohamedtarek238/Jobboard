<?php

try{
    $host="localhost";
    $dbname="jobboard";
    $username= "root";
    $password= "";
    
    $conn= new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
    // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
}catch(PDOException $e){
    echo $e->getMessage();
};

// if($conn == true){
//     echo " connected succefully";
// }else{
//     echo"something wrong";

// }


?>