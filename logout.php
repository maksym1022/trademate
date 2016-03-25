<?php
session_start();
if(isset($_SESSION['a_id']))
{
	session_destroy();
	echo "<script>window.location.href='index.php'</script>";
}
?>