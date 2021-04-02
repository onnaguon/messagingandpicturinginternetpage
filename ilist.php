<?php

include("../data.php");

class Msg extends Dobj{
var $text;
}

class Inimene extends Dobj{
var $name;
var $time;
var $dpic;
}


$myd=new Data();

$myd->loadobjecttables();
$texists=false;
$t1=$myd->dtables;

$ilist=array();

$itidx=-1;
for($i=0; $i<count($t1);$i++) {
if($t1[$i][0]->getNameOfClass()=="Inimene") {
$texists=true;
$itidx=$i;
break;
}
}

$newi=array();

if($itidx>-1) {
for($i=0; $i<count($t1[$itidx]);$i++) {
$date12=date("d.m.Y H:i:s", strtotime($t1[$itidx][$i]->time));
$dtime = new DateTime($date12);

$datenow=date( 'd.m.Y H:i:s', strtotime( '+3 hour' , strtotime("now") ));
$dtimenow = new DateTime($datenow);

$diff = $dtimenow->getTimestamp() - $dtime->getTimestamp();
if($diff<60*15) {
$newi[]=$t1[$itidx][$i];
} else {
}
}
if(count($newi)==0) {
unset($t1[$itidx]);
unlink("Inimene.dat");
} else {
$t1[$itidx]=$newi;
$myd->dtables=$t1;
$myd->saveobjecttable("Inimene");
}
}

if($texists==true) {
$t2=$myd->query("get name from Inimene;");
for($i=0; $i<count($t2);$i++) {
$ilist[]=$t2[$i];
}
} else {

}

$result = array_unique($ilist);
$List = implode(', ', $result);
if(substr($List,strlen($List)-2, 2)==", ") {
$List=substr($List, 0, strlen($List)-2);
}
echo $List;

?> 