<?php
    include 'mysql_login.php';

    $conn=new mysqli($hostname,$username,$password,$database);
if($conn->connect_error) die($conn->connect_error);

$status=array(1=>'insertion_error',2=>'success');

$firstname=mysqli_real_escape_string($conn,$_POST['firstname']);
$lastname=mysqli_real_escape_string($conn,$_POST['lastname']);
$email=mysqli_real_escape_string($conn,$_POST['email']); //
$username=mysqli_real_escape_string($conn,$_POST['username']);
$phone_number=mysqli_real_escape_string($conn,$_POST['phone_number']);
$password='welcome';//mysqli_real_escape_string($conn,$_POST['password']);
$dob=mysqli_real_escape_string($conn,$_POST['dob']);
$gender=mysqli_real_escape_string($conn,$_POST['gender']);
$blood_group=mysqli_real_escape_string($conn,$_POST['blood_group']);
$weight=mysqli_real_escape_string($conn,$_POST['weight']);
$height=mysqli_real_escape_string($conn,$_POST['height']);
$bmi=mysqli_real_escape_string($conn,$_POST['bmi']);
$residental_detail=mysqli_real_escape_string($conn,$_POST['residental_detail']);
$medical_background=mysqli_real_escape_string($conn,$_POST['medical_background']);

$name=Array('firstname'=>$firstname,'lastname'=>$lastname);
$hased_password=md5($password);
$id='';
$row= array();
//SQL QUERIES
$sql_insert_in_mainlogin="INSERT INTO main_login(username,password,email,profession) values('$username','$hased_password','$email',0)";
$sql_fetch_id="SELECT id FROM main_login WHERE username='$username'";



//EXECUTING


$result=mysqli_query($conn,$sql_insert_in_mainlogin);
if (!$result) {
    echo "querry1 failed ".mysqli_error($conn);
} else {
    $result2=mysqli_query($conn,$sql_fetch_id);
    if(!$result2){echo "querry2 failed ".mysqli_error($conn);}
        else{
            $row=mysqli_fetch_assoc($result2);
            $id=$row['id'];
            
            $sql_insert_in_patientDetail="INSERT INTO patient_detail(`username`,`email`,`id`,`phone_number`,`name`) values('$username','$email',$id,$phone_number ,JSON_OBJECT('firstname','".$name['firstname']."','lastname','".$name['lastname']."'))";

            $result3=mysqli_query($conn,$sql_insert_in_patientDetail);
            if (!$result3) {echo "querry3 failed ".mysqli_error($conn);}
            else{
                $sql_insert_mainDetail="UPDATE patient_detail SET cradential_detail=JSON_OBJECT(
                    'dob','$dob',
                            'gender','$gender',
                            'blood_group','$blood_group',
                            'weight',$weight,
                            'height',$height,
                            'bmi',$bmi,
                            'medical_background','$medical_background',
                            'residental_detail','$residental_detail'

                ) where id=$id and username='$username'";
                $result4=mysqli_query($conn,$sql_insert_mainDetail);
                if (!$result4) {echo "querry4 failed ".mysqli_error($conn);}
                else{
                    echo $status[2];
                }

            }
        }
}



?>