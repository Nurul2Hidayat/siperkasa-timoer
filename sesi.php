<?php
session_start();
if(!isset($_SESSION['simrsig']) || $_SESSION['simrsig'] == '') {
header("location:index.php");
}
?>