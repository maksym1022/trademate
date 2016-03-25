<?php  ob_start(); session_start();
if(!isset($_SESSION['a_id'])){
	echo "<script>window.location.href='index.php';</script>";
}
?>