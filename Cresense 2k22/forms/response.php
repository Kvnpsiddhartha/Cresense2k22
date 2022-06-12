<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Response</title>
</head>
<body>

<?php
include '../DBHANDLER.php';
$db = new DBHANDLER();

$response = array();
$response['status']=false;
if(isset($_POST['fname']) and isset($_POST['email']) and isset($_POST['phone']) and isset($_POST['college']) and isset($_POST['ename'])){
$response['status']=$db->register($_POST['fname'],$_POST['email'],$_POST['phone'],$_POST['college'],$_POST['ename']);

}
;
if($response){
    echo '<div class="alert alert-success" role="alert">
  Registered Successfully
</div>';

}
else{
    echo '<div class="alert alert-danger" role="alert">
  Registration Failed
</div>';
}

?>
</body>
</html>