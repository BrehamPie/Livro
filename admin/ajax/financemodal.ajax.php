<?php
require '../includes/functions.inc.php';
$type = $_POST['ttype'];
$amnt = $_POST['tamnt'];
$acnt = $_POST['tacnt'];
$date = $_POST['tdate'];
if($type=='expend') insertExpenditure($acnt,$amnt,$date);
else insertIncome($acnt,$amnt,$date);