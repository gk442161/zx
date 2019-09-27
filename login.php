 <?php
 //echo('doctor');
    include 'php/mysql_login.php';

    $conn=new mysqli($hostname,$username,$password,$database);
    if($conn->connect_error) die($conn->connect_error);




if(isset($_POST['username']) &&  isset($_POST["password"]))
{
    $username=get_post($conn,'username');

    $pass=get_post($conn,'password');
    $hashed_pass=md5($pass);
  
    //USERNAME ALREADY PRESENT OR NOT
     $sql="SELECT * FROM main_login WHERE username='$username'";
     $result=mysqli_query($conn,$sql);
  if(!$result)   {
      echo"querry failed";
  }else{
     if(mysqli_num_rows($result)>0){
                $row=mysqli_fetch_assoc($result);

                if($row['username']==$username){
                 $match_password=$row['password'];
                 $match_profession=$row['profession'];
                 $email=$row['email'];
                        if( $match_password==$hashed_pass) 
                        {
                         session_start();
                         $_SESSION['username']=$username;
                         $_SESSION['email']=$email;
                         $_SESSION['id']=$row['id'];
                        
                        echo( $match_profession==='1' ? 'doctor':'patient');
                    }
              else{echo'password_invalid';}          
         } }        
        }

} 

$result->free();
$conn->close();