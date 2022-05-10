<?php
session_start();
$_SESSION['tzname'] = $_POST['tzname'];
$_SESSION['tzoffset'] = $_POST['tzoffset'];
$_SESSION['tzdst'] = $_POST['tzdst'];
?>