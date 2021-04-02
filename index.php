<!DOCTYPE html>
<html>
<head>
<title>
☻☻☻☻☻☻☻☻░▒░▒▓██ Chat place ██▓▒░░☻☻☻☻☻☻☻☻
</title>
<link rel="icon" style="width:15px; height=15px; background-color: #76FEFF; color: #76FEFF;"/>
<style>
input {
color: #76FEFF;
}

body {
background-color: lightblue;
}

.main12 {
text-decoration:none;
color: #76FEFF;
font-weight: bold;
background-color: white;
border: 1px solid white;
border-radius: 10px 10px;
padding: 5px;
width: 400px;
font-weight:bold;
}
.main1 {
text-decoration:none;
color: white;
border-radius: 5px 5px;
padding: 5px;
font-weight:bold;
width:625px;
}

.main12 {
text-decoration:none;
color: #76FEFF;
border-radius: 5px 5px;
padding: 5px;
font-weight:bold;
vertical-align: middle;
width:825px;
margin-top: -3px;
}

.main2 {
color: white;
margin-top: -20px;

}

.main3 {
text-decoration:none;
color: #76FEFF;
font-weight: bold;
background-color: white;
border: 1px solid white;
border-radius: 5px 5px;
padding: 5px;
font-weight:bold;
width:100px;
display:block;

}

.w1 {
color: white;
}
.w2 {
color: white;
display:inline-block;
}
.pwd {
color: #76FEFF;
display:inline-block;
}

.w21 {
color: white;
display:block;
}

</style>
</head>
<body>
<h1 class="main12" style="line-height: 35px;">☻☻☻☻☻☻☻☻ Welcome ☻☻☻☻☻☻☻☻☻</h1>
<h1 class="main1">
</h1>

<?php

include("func.php");
include("data.php");

class Password extends Dobj{
var $content;
}


$dirs = array_filter(glob('*'), 'is_dir');

$cannotcreate=false;


if(count($dirs)>60) {
$cannotcreate=true;
}


if(!empty($_POST['rname'])&&($_POST['rname']!=" ")&&!empty($_POST['rname'])&$cannotcreate==false) {
$_POST['rname'] = strip_tags($_POST['rname']);
$_POST['rname'] = str_replace(' ', 'space21326', $_POST['rname']);
$_POST['rname'] = str_replace(',', 'comma21326', $_POST['rname']);
$_POST['rname'] = str_replace('?', 'q21326', $_POST['rname']);

mkdir($_POST['rname'], 0755);


if(!empty($_POST['password'])&&$_POST['password']!="") {
$myd=new Data();
$tabls=array();
$pwd1=new Password();
$pwd1->content=$_POST['password'];
$pwdt=array();
$pwdt[]=$pwd1;
$tabls[]=$pwdt;
$myd->dtables=$tabls;
$myd->saveobjecttable("Password");


$file = 'Password.dat';
$newfile = 'Password.dat';
if (!copy($file, $_POST['rname'].'/'.$newfile)) {
echo "Error\n";
}
chmod($_POST['rname'].'/'.$newfile, 0700);


unlink("Password.dat");
}


$file = 'index2.php';
$newfile = 'index.php';
if (!copy($file, $_POST['rname'].'/'.$newfile)) {
echo "Error\n";
}
chmod($_POST['rname'].'/'.$newfile, 0744);

$file = 'renewing.php';
$newfile = 'renewing.php';

if (!copy($file, $_POST['rname'].'/'.$newfile)) {
echo "Error\n";
}

chmod($_POST['rname'].'/'.$newfile, 0744);

$file = 'ilist.php';
$newfile = 'ilist.php';

if (!copy($file, $_POST['rname'].'/'.$newfile)) {
echo "Error\n";
}

chmod($_POST['rname'].'/'.$newfile, 0744);

$file = 'findlastmdate.php';
$newfile = 'findlastmdate.php';

if (!copy($file, $_POST['rname'].'/'.$newfile)) {
echo "Error\n";
}

chmod($_POST['rname'].'/'.$newfile, 0744);

$file = 'func.php';
$newfile = 'func.php';

if (!copy($file, $_POST['rname'].'/'.$newfile)) {
echo "Error\n";
}

chmod($_POST['rname'].'/'.$newfile, 0744);

}

$dirs = array_filter(glob('*'), 'is_dir');

if(count($dirs)>0) {
echo "<h2 class='main2'>Teemad</h2>";
}

$dirs = array_filter(glob('*'), 'is_dir');

foreach ($dirs as $file) {
$file2= str_replace('space21326', '&nbsp;', $file);
$file2= str_replace('comma21326', ',', $file2);
$file2= str_replace('q21326', '?', $file2);
if($file=="files") continue;

$dir1='//'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
$output = file_get_contents('http:'.$dir1.$file.'/findlastmdate.php');
if($output!="") {
$date12=date("d.m.Y H:i:s", strtotime($output));
$d_start = new DateTime($date12);
$currentdate = date('d.m.Y H:i:s', time());
$d_end = new DateTime($currentdate);
$diff = $d_start->diff($d_end);
$delete1=false;
if(!($diff->format('%d')<1000||$diff->format('%d')==1000&&$diff->format('%h')<1))
$delete1=true;
if($delete1) {
rrmdir('/'.$file);
continue;
}
}
echo '<a class="main12" href=\'http:'.$dir1.$file.'\'>'.$file2.'</a>';
echo "<p></p>";
$path_parts = pathinfo($file.'/Msg.dat');
if(!class_exists($path_parts['filename'])) {
continue;
}
}


?>
<p style="height:50px;"> </p>

<form method="POST">
<p class="w2">
Teema:
</p>
<input name="rname"/>
<p class="w21">
Parool(kui ei soovi parooli, jäta tühjaks):
</p>
<input class="pwd" name="password" type="password"/>
<p class="w">
</p>
<input type="submit" class="main3" value="Loo"/>
</form>
<p class="w1" style="color: #j3k4f8; font-weight: bold;">
Kui on lisatud parool, siis saab sellele ruumile ligi ainult nii, et aadressi lõpp on /index.php?code=Kood</p>
<p class="w1" style="color: #j3k4f8; font-weight: bold;">Tähelepanu: palun üritage olla viisakad..</p>
<p></p>
<p></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p class="w1"></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p class="w1" style="color: #j3k4f8; font-weight: bold;">
Owner's(Leonardo Da Robam) phone number: 372 6861327
</p>
</body>
</html> 