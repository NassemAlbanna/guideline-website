<?php
  session_start();

function sessionUser(){
 	// if(!isset($_SESSION['User'])){
  //     header("Location:login.php");
  // 	}
	if(!isset($_SESSION['id'])){
      header("Location:login.php");
  	}
 }
  
function sessionAdmin(){
 	if(!isset($_SESSION['Admin'])){
      header("Location:../login.php");
  	}
 }

function sessionPost(){

	if(!isset($_GET['id']) || !isset($_SESSION['id']) ){
		backHome();
	}
 }

function sessionProfile(){
	if(!isset($_GET['id'])){
		backHome();
	}
}

function sessionLoging(){
	if (isset($_SESSION['Admin']) || isset($_SESSION['User'])) {
		header('Location:logout.php');
	}
}

function backHome(){

	if (isset($_SESSION['Admin'])) {
	  header("Location:Dashboard/dashboard.php");

	}elseif (isset($_SESSION['User'])) {
		  header("Location:mainBlog.php");

	}else{
		  header("Location:login.php");
	}
}

?>