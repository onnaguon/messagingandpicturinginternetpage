<?php

include("../data.php");

class Msg extends Dbobj{
var $text;
}

$myd=new Data();

$myd->loadobjecttables();
$texists=false;
$t1=$myd->dtables;

$mdates=array();

for($i=0; $i<count($t1);$i++) {
if($t1[$i][0]->getNameOfClass()=="Msg") {
$texists=true;
break;
}
}

if($texists==true) {
$t2=$mydb->query("get text from Msg;");
for($i=0; $i<count($t2);$i++) {
$date12=date("d.m.Y H:i:s", strtotime(substr($t2[$i], 0, 19)));
$d_start = new DateTime($date12);
$mdates[]=$d_start;
}
echo $mdates[count($mdates)-1]->format('d.m.Y H:i:s');;
} else {
echo "";
}

?> 