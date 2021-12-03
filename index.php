<?php
session_start();
require_once("private/ctrls/switchpagecontroller.php");
$switchpagecontroler = new SwichPageControler();
$switchpagecontroler->SwitchPage();
?>