<?php //unused
//session_start();
//include '../dbh.php';
//
//$oldSubtype = $_POST['oldSubtype'];
//if (strpos($oldSubtype, '%20')) {
//    $oldSubtype = str_replace("%20", " ", $oldSubtype);
//}
//$newSubtype = $_POST['newSubtype'];
//$type = $_POST['type'];
//
//$currentSubtypes = array();
//
//$sql = "SELECT Subtype FROM subtypes"; //checks if new subtype already exists
//$result = mysqli_query($conn, $sql);
//while($row = mysqli_fetch_array($result)) {
//    array_push($currentSubtypes, $row['Subtype']);
//}
//
//if(in_array($newSubtype, $currentSubtypes) && $newSubtype !== $oldSubtype){
//    header("Location: ../editSubtype.php?error=exists");
//    exit();
//}
//
//$sql = "UPDATE `subtypes` SET `Subtype` = '".$newSubtype."', `Type` = '".$type."' WHERE `subtypes`.`Subtype` = '".$oldSubtype."';";
//$result = mysqli_query($conn, $sql);
//$sql = "UPDATE `inventory` SET `Subtype` = '".$newSubtype."' WHERE `Subtype` = '".$oldSubtype."';";
//$result = mysqli_query($conn, $sql);
//header("Location: ../editSubtype.php?success");
//exit();
?>