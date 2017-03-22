<?php 
 
$dbHost = "ntelline.cict.fr";
$dbHostPort="1522";
$dbServiceName = "etupre";
$usr = "21605127";
$pswd = "320323";
$dbConnStr = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)
        (HOST=".$dbHost.")(PORT=".$dbHostPort."))
        (CONNECT_DATA=(SERVICE_NAME=".$dbServiceName.")))";
 
if(!$dbConn = oci_connect($usr,$pswd,$dbConnStr)){
  $err = oci_error();
  trigger_error('Could not establish a connection: ' . $err['message'], E_USER_ERROR);
}

?>
