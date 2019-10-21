<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database="medic_hub";

//For sanitisation
function get_post($connection, $var){
  return $connection->real_escape_string($_POST[$var]);
}

function insert_data($connection,$sql)
{
 return $result = $connection->query($sql);
}
?>