<?php


include("db/connect.php");
echo 'TEST_UPDATE_PARTIE'; 
$niveau = 1 ; 

/* The call */
$sql = "BEGIN \"21400692\".highscoretous(:niveau, :res);END;";

/* Parse connection and sql */
$foo = oci_parse($dbConn, $sql);

/* Binding Parameters */
oci_bind_by_name($foo, ':niveau', $niveau) ;
oci_bind_by_name($foo, ':res',$out_var);

/* Execute */
$res = oci_execute($foo);
echo $res ; 
/* Get the output on the screen */
//print_r($res, true);


   // Create database procedure...
   // Call database procedure...
 /*  $in_var = 10;
   $s = oci_parse($c, "begin proc1(:bind1, :bind2); end;");
   oci_bind_by_name($s, ":bind1", $in_var);
   oci_bind_by_name($s, ":bind2", $out_var, 32); // 32 is the return length
   oci_execute($s, OCI_DEFAULT);
   echo "Procedure returned value: " . $out_var;*/
?>

