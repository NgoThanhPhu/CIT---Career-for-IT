<?php
require_once "connection.php";
session_start();

$dir = "images/uploads/";
$file = $dir . basename($_FILES["fileToUpload"]["name"]);

if ($_SERVER['REQUEST_METHOD']=="POST") {
  #files
  
  // receive all input values from the form
  $TieuDe = $_POST['TieuDe'];
  $DiaChi = $_POST['Diachi'];
  $YeuCau = $_POST['YeuCau'];
  $ThoiGian = $_POST['Thoigian'];
  $MieuTa = $_POST['MieuTa'];


  $user_check_query = "SELECT * FROM citj WHERE TieuDe='$TieuDe' LIMIT 1";
  $result = mysqli_query($conn, $user_check_query);
  $check = mysqli_fetch_assoc($result);
  
  if ($check) {
    if ($check['TieuDe'] === $TieuDe) {
        header("location: post-job.php?Error=Tiêu đề công việc bị trùng");
    }
  }else{
    $query = "INSERT INTO citj (TieuDe, MieuTa, DiaChi, CapDo, ThoiGian, YeuCau) 
              VALUES('$TieuDe', '$$MieuTa', '$DiaChi', 'Nhân viên', '$ThoiGian', '$YeuCau')";
    mysqli_query($conn, $query);

    #uploadimg
    $checkimg = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($checkimg == false) {
      header("post-job.php?Error=Upload image failure");
    }else {
      if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],$file)) {
        echo "Uploaded";
      }else{
        echo "failure";
      }
    }

    header('location: job-listings.php');
}
}
?>