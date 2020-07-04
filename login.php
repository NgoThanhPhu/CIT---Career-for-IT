<?php
  require_once "connection.php";
  session_start();
  if($_SERVER['REQUEST_METHOD']=="POST") {

      if(empty($_POST['luser']) || empty($_POST['lpass'])) {
          header("location: loginsignup.php?LError=Please enter username or password");
      }else{
        $inputUsername = $_POST['luser'];
        $inputPassword = $_POST['lpass'];

        $sql1 = "SELECT * FROM cituser WHERE Uname='".$inputUsername."'AND Upass='".$inputPassword."'";
        $query1 = mysqli_query($conn,$sql1);

        $sql2 = "SELECT * FROM cite WHERE Ename='".$inputUsername."'AND Epass='".$inputPassword."'";
        $query2 = mysqli_query($conn,$sql2);

        $sql3 = "SELECT * FROM citgod WHERE Gname='".$inputUsername."'AND Gpass='".$inputPassword."'";
        $query3 = mysqli_query($conn,$sql3);

        if(mysqli_fetch_assoc($query1)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['Username'] = $inputUsername;
            $_SESSION['Usertype'] = "Sinh vien";
            header("location: index.php?'".$_SESSION['Usertype']."'");

        }elseif(mysqli_fetch_assoc($query2)){
            $_SESSION['loggedin'] = true;
            $_SESSION['Username'] = $inputUsername;
            $_SESSION['Usertype'] = "Doanh Nghiep";
            header("location: index.php?Type=DoanhNghiep");
        }elseif(mysqli_fetch_assoc($query3)){
            $_SESSION['loggedin'] = true;
            $_SESSION['Username'] = $inputUsername;
            $_SESSION['Usertype'] = "GOD";
            header("location: index.php?Type=GOD");
        }else{
            header("location: loginsignup.php?LError=Wrong username or password");
        }
      }
  }else{
      echo"This login machine didnt working";
  }
?>