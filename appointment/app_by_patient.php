<?php
include '../baga/php/mysql_login.php';

$conn=new mysqli($hostname,$username,$password,$database);
if($conn->connect_error) die($conn->connect_error);
session_start();
$_SESSION['username']='sita_gita_pat';

$d_account_no=mysqli_fetch_assoc(mysqli_query($conn,"select D_account_no from doctor_detail where username='".$_POST['D_username']."'"))['D_account_no'];
$p_account_no=mysqli_fetch_assoc(mysqli_query($conn,"select P_account_no from patient_detail where username='".$_SESSION['username']."'"))['P_account_no'];
echo $d_account_no."   ".$p_account_no;

$slot_time='{"1":"11:00","2":"11:15","3":"11:30","4":"11:45","5":"12:00"}';
$slot_time=json_decode($slot_time);

$slot_selected=$slot_time->{$_POST['slot_id']};
echo $slot_selected;



if(isset($_POST['add'])){
    $date=date('d-m-Y',strtotime(date('d-m-Y',time())));//add +1 days

    echo "add";
    $sql="select doctor_id ,patients from appointment where doctor_id=$d_account_no";
    if(mysqli_fetch_assoc(mysqli_query($conn,$sql))['doctor_id']==null){
        $sql1="INSERT INTO appointment(doctor_id, patients) VALUES ($d_account_no,json_array(json_object('slot_id',".$_POST['slot_id'].",'p_account_no',$p_account_no,'slot_time','$slot_selected','slot_date','$date','status','not_done')))";
    }
    else{
        if(mysqli_fetch_assoc(mysqli_query($conn,$sql))['patients']==null){
            $sql1="UPDATE appointment SET patients= (json_array(json_object('slot_id',".$_POST['slot_id'].",'p_account_no',$p_account_no,'slot_time','$slot_selected','slot_date','$date','status','not_done')) WHERE doctor_id=$d_account_no";
        }
            else{
                $sql1="UPDATE `appointment` SET patients=json_array_append(patients,'$',json_object('slot_id',".$_POST['slot_id'].",'p_account_no',$p_account_no,'slot_time','$slot_selected','slot_date','$date','status','not_done')) WHERE doctor_id=$d_account_no";
            }
    }
    $result=mysqli_query($conn,$sql1);
    echo mysqli_error($conn);


}
if (isset($_POST['remove'])) {
    echo "remove";
    $count=0;
 
    $arg=mysqli_fetch_assoc(mysqli_query($conn,"select patients->>'$[*].slot_id' as slot_id from appointment where doctor_id=$d_account_no"))['slot_id'];
    $arg=json_decode($arg);
    foreach($arg as $values){
        if ($values==$_POST['slot_id']) {
            $sql1="UPDATE appointment SET patients=json_remove(patients,'$[$count]') where doctor_id=$d_account_no ";
            $result=mysqli_query($conn,$sql1);
            echo mysqli_error($conn);
           
        }
        $count++;
    }

    
}

//sorting the json_data
$sql2="select patients from appointment where doctor_id=$d_account_no";
$result2=mysqli_fetch_assoc(mysqli_query($conn,$sql2))['patients'];
$object=json_decode($result2);

usort($object, function ($a, $b) {
return $a->slot_id > $b->slot_id;
    });

$object=json_encode($object);
mysqli_query($conn,"UPDATE appointment set patients='$object' where doctor_id=$d_account_no");
echo mysqli_error($conn);

// $sql="select patients from appointment where doctor_id=$d_account_no";
// $result=mysqli_fetch_assoc(mysqli_query($conn,$sql))['patients'];
// $object=json_decode($result);

// usort($object, function ($a, $b) {
//     return $a->slot_id > $b->slot_id;
// });

// $object=json_encode($object);
// mysqli_query($conn,"UPDATE appointment set patients='$object' where doctor_id=$doctor_id");
// echo mysqli_error($conn);
//if($_POST[''])
//$sql="INSERT INTO `appointment`(`doctor_id`, `patients`) VALUES (2,json_array(json_object('id',1,'p_account_no',9)))";


