<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
    	

if (isset($_POST['teacher_name']) &&
    isset($_POST['username']) &&
    isset($_POST['pass'])     &&
    isset($_POST['teacher_address'])  &&
    isset($_POST['teacher_dob']) )
    {

    include '../../DB_connection.php';
    include "../data/teacher.php";

    $teacher_name = $_POST['teacher_name'];
    $uname = $_POST['username'];
    $pass = $_POST['pass'];
    $teacher_address = $_POST['teacher_address'];
    $teacher_dob = $_POST['teacher_dob'];
   

    $data = 'uname='.$uname.'&teacher_name='.$teacher_name.'teacher_dob='.'&teacher_address='.$teacher_address;

    if (empty($teacher_name)) {
		$em  = "Teacher name is required";
		header("Location: ../teacher-add.php?error=$em&$data");
		exit;
	}else if (empty($uname)) {
		$em  = "Username is required";
		header("Location: ../teacher-add.php?error=$em&$data");
		exit;
	}else if (!unameIsUnique($uname, $conn)) {
		$em  = "Username is taken! try another";
		header("Location: ../teacher-add.php?error=$em&$data");
		exit;
	}else if (empty($pass)) {
		$em  = "Password is required";
		header("Location: ../teacher-add.php?error=$em&$data");
		exit;
	}else if (empty($teacher_address)) {
        $em  = "Address is required";
        header("Location: ../teacher-add.php?error=$em&$data");
        exit;
    }else if (empty($teacher_dob)) {
        $em  = "Date of birth is required";
        header("Location: ../teacher-add.php?error=$em&$data");
        exit;
    }else {
        // hashing the password
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $sql  = "INSERT INTO
                 teachers(username, password, teacher_name, teacher_address , teacher_dob)
                 VALUES(?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$uname, $pass, $teacher_name, $teacher_address,  $teacher_dob]);
        $sm = "New teacher registered successfully";
        header("Location: ../teacher-add.php?success=$sm");
        exit;
	}
    
  }else {
  	$em = "An error occurred";
    header("Location: ../teacher-add.php?error=$em");
    exit;
  }

  }else {
    header("Location: ../../logout.php");
    exit;
  } 
}else {
	header("Location: ../../logout.php");
	exit;
} 