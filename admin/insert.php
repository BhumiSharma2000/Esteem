<?php
	include "connection.php";	
	session_start();
	if(!isset($_SESSION['log']))
	{
		header("location:index.php");
	}
	else
	{	
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
        $desi = $_POST['desi'];
        $junior = $_POST['junior'];
        $senior = $_POST['senior'];
		$address = $_POST['address'];	
		$passx = $_POST['pass1'];
		$pass1=md5($passx);
		$passy = $_POST['pass2'];
		$pass2=md5($passy);
		$dob = $_POST['dob'];
        $join = $_POST['join'];
		$gender = $_POST['gender'];
		$user_type = $_POST['user_type'];
		$file = $_FILES['image']['tmp_name'];
		$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
		$image_name = addslashes($_FILES['image']['name']);
		move_uploaded_file($_FILES["image"]["tmp_name"],"../photos/default.png" . $_FILES["image"]["name"]);
        $location="../photos/default.png" . $_FILES["image"]["name"];
        if(!$_FILES['image']['name'])
        {
            $location="../photos/default.png";
        }
		$query2="SELECT * FROM `tbl_login` WHERE email_id='$email'";
		$abc=mysqli_query($con,$query2);
		$xyz=mysqli_num_rows($abc);
		$query3="SELECT * FROM `tbl_login` WHERE  phone_no='$phone'";
		$abc1=mysqli_query($con,$query3);
		$xyz1=mysqli_num_rows($abc1);
		if($xyz==0 AND $xyz1==0)
		{	
            $query = "INSERT INTO tbl_login(login_id,email_id,phone_no,password,status,type,active) VALUES('','$email','$phone','$pass1','0','$user_type','1')";
            $result = mysqli_query($con,$query);
            $rowsql = mysqli_query($con,"SELECT MAX(login_id) AS max FROM tbl_login");	
            $row = mysqli_fetch_array($rowsql);
            $id = $row['max'];
            $sql = "INSERT INTO `tbl_detail`(`login_id`, `name`, `dob`, `gender`, `address`, `profile_pic`, `designation`, `no_of_members_under`, `total_seniors`, `joining_date`, `created_on`, `updated_on`) VALUES ('$id','$name','$dob','$gender','$address','$location','$desi','$junior','$senior','$join','','')";
            var_dump($sql);
			if(!mysqli_query($con,$sql))
			{
				echo "Not inserted...";
			}
			else
			{
				echo "inserted successfully....";
				header("location:addstaff.php?flag=1");
			}
		}
		else
		{
			header("location:addstaff.php?xyz=1");	
		}
	}
?>