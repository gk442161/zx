
<?php

    include 'php/mysql_login.php';

    $conn=new mysqli($hostname,$username,$password,$database);
    if($conn->connect_error) die($conn->connect_error);

$username = $_POST['username'];
$password = $_POST['password'];

if(isset($_POST['username']) &&  isset($_POST["password"]))
{
    $username=get_post($conn,'username');

    $pass=get_post($conn,'password');
    $hashed_pass=md5($pass);
  
    //USERNAME ALREADY PRESENT OR NOT
    $result=$conn->query("SELECT username FROM main_login WHERE username='$username'");
    $match_username=mysqli_fetch_assoc($result)['username'];
    $match_password=mysqli_fetch_assoc($result)['password'];
    $match_profession=mysqli_fetch_assoc($result)['profession'];
    $email=mysqli_fetch_assoc($result)['email'];
    printf("\n");
    
    if($match_username==$username &&  $match_password==$hashed_pass) 
    {
        echo '1'+$match_profession ;
        session_start();
        $_SESSION['username']=$match_username;
        $_SESSION['email']=$email;
        $_SESSION['id']=mysqli_fetch_assoc($result)['id'];
    }
    else{//IF NOT THEN ENTER NEW ENTERY
        echo 0;
        } 

    }