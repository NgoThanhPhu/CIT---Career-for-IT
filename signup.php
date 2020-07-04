<?php
require_once "connection.php";
session_start();
// REGISTER USER
if ($_SERVER['REQUEST_METHOD']=="POST") {
  // receive all input values from the form
  $Fullname = $_POST['Sfullname'];
  $MSSV = $_POST['MSSV'];
  $Khoa = $_POST['Khoa'];
  $Nganh = $_POST['Nganh'];
  $username = $_POST['Sname'];
  $password_1 = $_POST['Spass1'];
  $password_2 = $_POST['Spass2'];


  if ($password_1 != $password_2) {
	header("location: loginsignup.php?SError=Password not matched");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM cituser WHERE Uname='$username' LIMIT 1";
  $result = mysqli_query($conn, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['Uname'] === $username) {
        header("location: loginsignup.php?SError=Email Existed");
    }
  }else{
    $password = $password_1;

    $query = "INSERT INTO cituser (Ten, MSSV, Khoa, Nganh, Uname, Upass) 
            VALUES('$Fullname', '$MSSV', '$Khoa', '$Nganh', '$username', '$password')";
    mysqli_query($conn, $query);
    $_SESSION['User'] = $Fullname;
    header('location: loginsignup.php?Success=Wellcome');
}
}
?>