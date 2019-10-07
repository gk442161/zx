<?php
include '../baga/php/mysql_login.php';

$conn=new mysqli($hostname,$username,$password,$database);
if($conn->connect_error) die($conn->connect_error);

$doctor_id=mysqli_fetch_assoc(mysqli_query($conn,"select D_account_no from doctor_detail where username='doctor1'"))['D_account_no'];//.$_SESSION['username'].
$result=mysqli_fetch_assoc(mysqli_query($conn,"select patients from appointment where doctor_id=$doctor_id"))['patients'];
$object=json_decode($result);


//setting the time-zone
date_default_timezone_set('Asia/Kolkata');

$j=0;
//if doctor want to start the appointment
if (true) {//isset($_POST['status'])

    if (true) { //$_POST['status']=='start'
        $bt=strtotime('18:00');//$_POST['start_time']
        $et=strtotime('22:00');//$_POST['end_time']
        if($bt>strtotime(date('H:i',time()))){
            //don't run anything
                echo "going_good";
            }
        else{
            echo "else_part";
            if ($bt<=strtotime(date('H:i',time())) and strtotime(date('H:i',time()))<=$et) {
                     // start eliminating the events
                     echo "if_part";
                while($j<sizeof($object)){
                    echo "while_part";
                    if (strtotime($object[$j]->slot_time)<=strtotime(date('H:i',time())) and strtotime(date('H:i',time()))<$et) {
                        //check the status of appointment
                        //whether the patient has made his checking done or not
                        echo "if_part";
                        if ($object[$j]->status=='not_done'&& (strtotime($object[$j]->slot_time)+900)>strtotime(date('H:i',time()))) {
                            //do-nothing
                            echo "do_nothing";
                            }
                        elseif ($object[$j]->status=='not_done'&& (strtotime($object[$j]->slot_time)+900)<=strtotime(date('H:i',time()))) {
                            //increase the time of every slot by 15min
                            echo "else_if1";
                            for ($i=(sizeof($object)-1); $i >=$j ; $i--) { 
                                echo "start";
                                $new_time=date('H:i',strtotime($object[$i]->slot_time.'+15 min'));
                                if (strtotime($new_time)>$et) {
                                    echo "updating_date";
                                    if (strtotime($object[$i]->slot_date)!=strtotime(date('d-m-Y',time()).'+1 days')) {
                                        $new_date=date('d-m-Y',strtotime($object[$i]->slot_date.'+1 days'));
                                        $sql="update appointment set patients= JSON_SET(patients, '$[$i].slot_time','".date('H:i',$bt)."','$[$i].slot_date','$new_date') where doctor_id =$doctor_id";
                                        $result=mysqli_query($conn,$sql);
                                        echo mysqli_error($conn);
                                    }
                                    else{
                                        $sql="update appointment set patients = JSON_SET(patients, '$[$i].slot_time','$new_time') where doctor_id =$doctor_id";
                                        $result=mysqli_query($conn,$sql);
                                        echo mysqli_error($conn);
                                    }
                                }
                                else{
                                    echo "just_updated_time";
                                $sql="update appointment set patients = JSON_SET(patients, '$[$i].slot_time', '$new_time') where doctor_id =$doctor_id";
                                $result=mysqli_query($conn,$sql);
                                echo mysqli_error($conn);
                                }
                                }
                                
                            }
                        elseif ($object[$j]->status=='done') {
                                 echo "elseif2_done";
                            }
                    }
                    $j=$j+1;
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
?>