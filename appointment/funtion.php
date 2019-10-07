<?php
include '../baga/php/mysql_login.php';

$conn=new mysqli($hostname,$username,$password,$database);
if($conn->connect_error) die($conn->connect_error);

$doctor_id=mysqli_fetch_assoc(mysqli_query($conn,"select D_account_no from doctor_detail where username='doctor1'"))['D_account_no'];//.$_SESSION['username'].
$result=mysqli_fetch_assoc(mysqli_query($conn,"select patients from appointment where doctor_id=$doctor_id"))['patients'];
$object=json_decode($result);

//sorted array 
usort($object, function ($a, $b) {
    return $a->slot_id > $b->slot_id;
});

//setting the time-zone
date_default_timezone_set('Asia/Kolkata');


//if doctor want to start the appointment
if (isset($_POST['status'])) {

    if ($_POST['status']=='start') {
        $bt=strtotime($_POST['start_time']);
        $et=strtotime($_POST['end_time']);
        if($bt>time()){
            //don't run anything
                echo "going_good";
            }
        else{
            if ($bt<=strtotime(date('H:i',time())) and strtotime(date('H:i',time()))!=$et) {
                     // start eliminating the events
                while($j<sizeof($object)){
                    if (strtotime($object[$j]->slot_time)<=strtotime(date('H:i',time())) and strtotime(date('H:i',time()))<$et) {
                        //check the status of appointment
                        //whether the patient has made his checking done or not
                        if ($appointment_list[$j]->status=='not_done'&& (strtotime($appointment_list[$j]->slot_time)+900)>time()) {
                            //do-nothing
                            }
                        elseif ($appointment_list[$j]->status=='not_done'&& (strtotime($appointment_list[$j]->time)+900)<=time()) {
                            //increase the time of every slot by 15min
                            for ($i=(sizeof($object)-1); $i >$j ; $i--) { 

                                $sql="update appointment set patients = JSON_SET(patients, '$[$i].slote_time', ADDTIME(patients->>'$[$i].slote_time','0:15') where doctor_id =$doctor_id";
                                $result=mysqli_query($conn,$sql);
                                echo mysqli_error($conn);
                                }
                            }
                        elseif ($appointment_list[$j]->status=='done') {
                                 $j=$j+1;
                            }
                    }
                  }
    
                // elseif (strtotime($appointment_list[$j]->time)>time() and time()<$et) {
                //          //do nothing
                //      }
                
              }
            elseif(strtotime(date('H:i',time()))>=$et){
                        //end the process
                        echo "process-ended";
                }
        }

    }
}
// }

// function timing_manage($appointment_list,$end_time,$base_time)
// {   $j=0;
//     //$length_of_list=count($appointment_list);
//     $bt=strtotime($base_time);
//     $et=strtotime($end_time);
    
//     if($bt>time()){
//         //don't run anything

//         }
//     else{
//         if ($bt<=time()and time()!=$et) {
//                  // start eliminating the events
//             while($j<12){
//                 if (strtotime($appointment_list[$j]->time)<=time() and time()<$et) {
//                     //check the status of appointment
//                     //whether the patient has made his checking done or not
//                     if ($appointment_list[$j]->status=='not-done'&& (strtotime($appointment_list[$j]->time)+900)>time()) {
//                         //do-nothing
//                         }
//                     elseif ($appointment_list[$j]->status=='not-done'&& (strtotime($appointment_list[$j]->time)+900)<=time()) {
//                         //increase the time of every slot by 15min
//                         for ($i=11; $i >$j ; $i--) { 
//                              $sql="update appointment set patients = JSON_SET(patients, '$[".$index."].slote_time', ADDTIME(patients->>'$[".$index."].slote_time','0:15:0') where username ='".$_SESSION['username']."'";
//                              $result=mysqli_query($conn,$sql);
//                              echo mysqli_error($conn);
//                             }
//                         }
//                     elseif ($appointment_list[$j]->status=='done') {
//                              $j=$j+1;
//                         }
//                 }
//               }

//             // elseif (strtotime($appointment_list[$j]->time)>time() and time()<$et) {
//             //          //do nothing
//             //      }
            
//           }
//         elseif(time()>=$et){
//                     //end the process
//             }
//     }
// }
        

   
            
// function new_appointment_time($index)
//  {   
//      $sql="update appointment set patients = JSON_SET(patients, '$[".$index."].slote_time', ADDTIME(patients->>'$[".$index."].slote_time','0:15:0') where username ='".$_SESSION['username']."'";
//      $result=mysqli_query($conn,$sql);
//      echo mysqli_error($conn);
//     }   


  
 


 //INSERT INTO `appointment`(`doctor_id`, `patients`) VALUES (2,json_array(json_object('id',1,'p_account_no',9)))

 //UPDATE `appointment` SET patients=json_set(patients,'$[0].slote_time',CURRENT_TIME) WHERE doctor_id=2
?>