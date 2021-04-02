<?php

include("../data.php");

class Msg extends Dobj{
var $text;
}

$myd=new Data();

$myd->loadobjecttables();
$texists=false;
$t1=$myd->dtables;
for($i=0; $i<count($t1);$i++) {
if($t1[$i][0]->getNameOfClass()=="Msg") {
$texists=true;
break;
}
}

if($texists==true) {
$t2=$myd->query("get text from Msg;");
for($i=0; $i<count($t2);$i++) {
echo $t2[$i]."<p></p>";
}
} else {

}
?>
