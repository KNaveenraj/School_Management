<?php 
session_start();
include '../DB_connection.php';
    	

if (isset($_POST['fname']) &&
    isset($_POST['lname']) &&
    isset($_POST['username']) &&
    isset($_POST['pass'])&&
    isset($_POST['c_pass']) )
    {

    

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = $_POST['username'];
    $pass = $_POST['pass'];
    $c_pass = $_POST['c_pass'];
  


    $data = 'uname='.$uname.'&fname='.$fname.'&lname='.$lname.'&pass='.$pass.'&c_pass='.$c_pass;

    if (empty($fname)) {
		$em  = "First name is required";
		header("Location: ../admin-add.php?error=$em&$data");
		exit;
	}else if (empty($lname)) {
		$em  = "Last name is required";
		header("Location: ../admin-add.php?error=$em&$data");
		exit;
	}else if (empty($uname)) {
		$em  = "Username is required";
		header("Location: ../admin-add.php?error=$em&$data");
		exit;
	}
    else if (empty($pass)) {
		$em  = "Password is required";
		header("Location: ../admin-add.php?error=$em&$data");
		exit;
    }
    else if (empty($c_pass)) {
      $em  = "Confirm Password is required";
      header("Location: ../admin-add.php?error=$em&$data");
      exit;
	
    }else {
      if($pass===$c_pass){
        // hashing the password
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $sql  = "INSERT INTO
                 admin(username, password, fname, lname)
                 VALUES(?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$uname, $pass, $fname, $lname]);
        $sm = "Admin Registered Successfully";
        header("Location: ../admin-add.php?success=$sm");
        exit;
      }
      else{
        $em = "Password do not match";
        header("Location: ../admin-add.php?error=$em");
        exit;
      }
	}
    
  }else {
  	$em = "An error occurred";
    header("Location: ../admin-add.php?error=$em");
    exit;
  }

