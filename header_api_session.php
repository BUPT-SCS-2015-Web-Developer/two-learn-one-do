<?php
//Environment settings
$iapp_id = ''; //Eg. iapp40000
$iapp_bupt_url = ''; //Eg. http://yiban.bupt.edu.cn/askforleave/leave.php

session_start();
if(isset($_SESSION['create_time']) and (time() - $_SESSION['create_time'] > 12*60*60))
    session_reset();
if(session_status() == PHP_SESSION_ACTIVE and $_SESSION['current_iapp'] != $iapp_id)
{
    session_reset();
    $_SESSION['current_iapp'] = $iapp_id;
    header("Location:".$iapp_bupt_url);
    exit;
}
if(!isset($_GET['verify_request']) and !isset($_SESSION['verify_request']))
{
    header("Location:http://f.yiban.cn/".$iapp_id);
    exit;
}
if(isset($_GET["verify_request"]))
{
    $_SESSION['create_time'] = time();
    $_SESSION['verify_request'] = $_GET['verify_request'];
    $_SESSION['yb_uid'] = $_GET['yb_uid'];
    header("Location:".$iapp_bupt_url);
    exit;
}
$_REQUEST['verify_request'] = $_SESSION['verify_request'];
$_REQUEST['yb_uid'] = $_SESSION['yb_uid'];
?>