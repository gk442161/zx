<?php
    include 'mysql_login.php';
 $conn=new mysqli($hostname,$username,$password,$database);
if($conn->connect_error) die($conn->connect_error);
if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST["password"]))
{   $username=get_post($conn,'username');
    $email=get_post($conn,'email');
    $pass=get_post($conn,'password');
    $hashed_pass=md5($pass);
    echo $hashed_pass.$username.$email;
    //USERNAME ALREADY PRESENT OR NOT
    $result=$conn->query("SELECT username FROM main_login WHERE username='$username'");
    $match=mysqli_fetch_assoc($result)['username'];
    printf("\n");
    echo"$match";
    if($match==$username)
    {
        printf("Sorry username already exists");
    }
    else{//IF NOT THEN ENTER NEW ENTERY
        $result=$conn->query("INSERT INTO main_login(username,password,email) VALUES ('$username','$hashed_pass','$email')");
        if(!$result){
        printf("Error haaa: %s\n", $conn->sqlstate);
                     }
        else{
         $result=$conn->query("SELECT id FROM main_login WHERE username='$username' AND password='$hashed_pass'");
         $id=mysqli_fetch_assoc($result)['id'];
         session_start();
         $_SESSION['username']=$username;
         $_SESSION['email']=$email;
         $_SESSION['id']=$id;
         echo"<br>HURRAY!";
        }
        }}
?>