<?php

include '../baga/php/mysql_login.php';

$conn=new mysqli($hostname,$username,$password,$database);
if($conn->connect_error) die($conn->connect_error);
date_default_timezone_set('Asia/Kolkata');

        $bt=strtotime('09-10-2019');//$_POST['start_time']
        //$et=strtotime($_POST['end_time']);//
        if($bt>strtotime(date('d-m-Y',time()))){
            //don't run anything
            $date=date('H:i',strtotime(date('H:i',time()).'+15 min,+1 days'));
                echo "going_good".$date;
            }
           else{

               echo "going_after".date('d-m-Y',time());
           } 

// $doctor_id=mysqli_fetch_assoc(mysqli_query($conn,"select D_account_no from doctor_detail where username='doctor1'"))['D_account_no'];//".$_SESSION['username']."
// $sql="select patients from appointment where doctor_id=$doctor_id";
// $result=mysqli_fetch_assoc(mysqli_query($conn,$sql))['patients'];
// $object=json_decode($result);

// usort($object, function ($a, $b) {
//     return $a->slot_id > $b->slot_id;
// });

// $object=json_encode($object);
// mysqli_query($conn,"UPDATE appointment set patients='$object' where doctor_id=$doctor_id");
// echo mysqli_error($conn);
