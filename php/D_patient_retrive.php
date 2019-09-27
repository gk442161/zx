<?php
    include 'mysql_login.php';

    $conn=new mysqli($hostname,$username,$password,$database);
if($conn->connect_error) die($conn->connect_error);

$sql="SELECT JSON_PRETTY(account_no) as json FROM doctor_detail
        WHERE id=1";//.$_SESSION['id']."";
$result=mysqli_query($conn,$sql);

if(!$result){
    echo mysqli_error($conn);
}
else{
    $row=mysqli_fetch_assoc($result);
    //
    $accounts=explode(',',str_replace(['[',']'],'',$row['json']));//$acc_no;

            //FOR NAME
    if(isset($_POST['fetch_name'])){
                foreach($accounts as $value){
                $sql2="SELECT CONCAT(name->>'$.firstname','  ',name->>'$.lastname') as fullname,phone_number FROM patient_detail WHERE account_no=$value";
                $result_2=mysqli_query($conn,$sql2);
                $patient_name=mysqli_fetch_assoc($result_2);
                echo"<div class='column'>
                <div class='card'><img src='image/cardimage.jpg' alt='Avatar' style='width:85%'>
                  <div class='container'>
                    <h4><b>".$patient_name['fullname']."</b></h4> 
                    <p>".$patient_name['phone_number']."</p> 
                    <p id='card_id' style='display:none'>$value</p>
                  </div>
                </div>
                </div>   ";
            }
        }else{if(isset($_POST['card_id']))
                echo "this will fetch card_detail_";
            }

    
    
}
?>
 
