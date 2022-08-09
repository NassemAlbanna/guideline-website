<?php

	if (isset($_GET['id']) && isset($_GET['ty'])) {
		require_once ('../connect.php');

		$id   = $_GET['id'];
		$type = $_GET['ty'];

		if ($type == 'Ac') {
			$sql = "UPDATE user SET status='Active' WHERE id='$id'";
			mysqli_query($connect,$sql);
		}elseif($type == 'In'){
			$sql = "UPDATE user SET status='Inactive' WHERE id='$id'";
			mysqli_query($connect,$sql);
		}
		header("Location:dashboard.php");
	}

?>