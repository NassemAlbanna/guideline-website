<?php
	
	require_once('../connect.php');

	if (isset($_GET['id'])) {
		$idPost = $_GET['id'];
		$sql    = "DELETE FROM Posts WHERE id=$idPost";
		mysqli_query($connect,$sql);
		header("Location:../mainBlog.php");
	}

?>