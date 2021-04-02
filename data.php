<?php

class Dobj {
function getNameOfClass()
{
return static::class;
}
}

class Data {

var $dtables;

function gettime() {
return date("d.m.Y H:i:s");
}

function loadobjecttables() {
$dtables = array();
foreach (glob("*.dat") as $file) {
$path_parts = pathinfo($file);
if(!class_exists($path_parts['filename'])) {
continue;
}
$file1 = file_get_contents($file, true);
$dtables[] = unserialize($file1);
}
$this->dtables=$dtables;
}

function deleteotable($otabname) {
if (file_exists($otabname.".dat")) {
unlink($otabname.".dat");
}
$this->loadobjecttables();
}

function insertobject($obj) {
$this->loadobjecttables();
$oclass=$obj->getNameOfClass();
$tabls=$this->dtables;
$oarridx=-1;
for($i=0; $i<count($tabls); $i++) {
if($tabls[$i][0]->getNameOfClass()==$oclass) {
$oarridx=$i;
}
}
if($oarridx==-1) return false;
$tabls[$oarridx][]=$obj;
unlink($oclass.".dat");
$b=serialize($tabls[$oarridx]);
$fh = fopen($oclass.".dat", "a");
fwrite($fh, $b);
fclose($fh);
chmod($oclass.".dat", 0700);
}


function saveobjecttables() {
$tabls=$this->dtables;
for($i=0; $i<count($tabls); $i++) {
$oc=$tabls[$i][0]->getNameOfClass();
if (file_exists($oc.".dat")) {
unlink($oc.".dat");
}
$b=serialize($tabls[$i]);
$fh = fopen($oc.".dat", "a");
fwrite($fh, $b);
fclose($fh);
chmod($oc.".dat", 0700);
}
return true;
}

function saveobjecttable($objcl) {
$tabls=$this->dtables;
$obclindex=-1;
for($i=0; $i<count($tabls); $i++) {
if($tabls[$i][0]->getNameOfClass()==$objcl) {
$obclindex=$i;
break;
}
}
if (file_exists($objcl.".dat")) {
unlink($objcl.".dat");
}
$b=serialize($tabls[$obclindex]);
$fh = fopen($objcl.".dat", "a");
fwrite($fh, $b);
fclose($fh);
chmod($objcl.".dat", 0700);
return true;
}

function makearrayunique($array){
$duplicate_keys = array();
$tmp = array();

foreach ($array as $key => $val){
if (is_object($val))
$val = (array)$val;

if (!in_array($val, $tmp))
$tmp[] = $val;
else $duplicate_keys[] = $key;
}

foreach ($duplicate_keys as $key)
unset($array[$key]);
return $array;
}

function deleteduplicates() {
$ob=$this->dtables;
for($i=0; $i<count($ob); $i++) {
$o12=$this->makearrayunique($ob[$i]);
$ob[$i]=$o12;
}
$this->saveobjecttables();
}

function deleteduplicatescl($objcl) {
$ob=$this->dtables;
$obclindex=-1;
for($i=0; $i<count($ob); $i++) {
if($ob[$i][0]->getNameOfClass()==$objcl) {
$obclindex=$i;
break;
}
}
$o12=$this->makearrayunique($ob[$obclindex]);
$ob[$obclindex]=$o12;
$this->dtables=$ob;
$this->saveobjecttable($objcl);
}



function objectClassestoarray($objectA,
$objectB) {
$new_object = array();

foreach($objectA as $property => $value) {
$new_object[$property]=$value;
}

foreach($objectB as $property => $value) {
$new_object[$property]=$value;
}

return $new_object;
}


function query($query) {
$this->loadobjecttables();
$ovars=array();
$objects=$this->dtables;
for($i=0; $i<count($objects); $i++) {
$ovars[]=array_keys(get_object_vars($objects[$i][0]));
}
$mches=array();
$results=null;
$exitf=false;

for($i=0; $i<count($objects); $i++) {
if($exitf) break;
for($j=0; $j<count($ovars); $j++) {
if($exitf) break;
if(!class_exists($objects[$i][0]->getNameOfClass())) continue;
if(preg_match("/^get \* from ".$objects[$i][0]->getNameOfClass().";$/",$query)) {
$objectsList = [];
foreach ($objects[$i] as $obj) {
$objectsList[] = (array)$obj;
}
return $objectsList;
$exitf=true;
}
}
}

for($i=0; $i<count($objects); $i++) {
if($exitf) break;
for($j=0; $j<count($ovars); $j++) {
if($exitf) break;
if(!class_exists($objects[$i][0]->getNameOfClass())) continue;
if(preg_match("/^get ".$ovars[$i][$j]." from ".$objects[$i][0]->getNameOfClass().";$/",$query)) {
return array_column($objects[$i], $ovars[$i][$j]);
$exitf=true;
}
}
}

$outp=array();
for($i=0; $i<count($objects); $i++) {
if($exitf) break;
for($j=0; $j<count($ovars[$i]); $j++) {
if($exitf) break;
for($k=0; $k<count($objects); $k++) {
if($exitf) break;
for($l=0; $l<count($ovars[$k]); $l++) {
if($exitf) break;
if(!class_exists($objects[$i][0]->getNameOfClass())) continue;
if(!class_exists($objects[$k][0]->getNameOfClass())) continue;

if(preg_match("/^get \* from ".$objects[$i][0]->getNameOfClass()." join ".$objects[$k][0]->getNameOfClass().
" on \(".$objects[$i][0]->getNameOfClass()."\.".$ovars[$i][$j]."\=".$objects[$k][0]->getNameOfClass().
"\.".$ovars[$k][$l]."\);$/",$query)) {
for($ii=0; $ii<count($objects[$i]); $ii++) {
for($ii2=0; $ii2<count($objects[$k]);$ii2++) {
if($objects[$i][$ii]->{$ovars[$i][$j]}==$objects[$k][$ii2]->{$ovars[$k][$l]}) {
$oobj = $this->objectClassestoarray($objects[$i][$ii], $objects[$k][$ii2]);
$outp[]=$oobj;
}
}
}
$exitf=true;
}
}
}
}
}

for($k=0; $k<count($objects); $k++) {
if($exitf) break;
for($l=0; $l<count($ovars[$k]); $l++) {
if($exitf) break;
for($l2=0; $l2<count($ovars[$k]); $l2++) {
if($exitf) break;
if(!class_exists($objects[$k][0]->getNameOfClass()))
continue;

if(preg_match("/^get \* from ".$objects[$k][0]->getNameOfClass()." where ".$ovars[$k][$l]."\=(.*) and ".$ovars[$k][$l2]."\=(.*);$/",$query, $matches)) {
for($ii2=0;
$ii2<count($objects[$k]); $ii2++) {

if($objects[$k][$ii2]->{$ovars[$k][$l]}==$matches[1]&&$objects[$k][$ii2]->{$ovars[$k][$l2]}==$matches[2]) {

$oobj = (array)$objects[$k][$ii2];

$outp[]=$oobj;
}
}
$exitf=true;
}
}
}
}


for($k=0; $k<count($objects); $k++) {
if($exitf) break;
for($l=0; $l<count($ovars[$k]); $l++) {
if($exitf) break;
if(!class_exists($objects[$k][0]->getNameOfClass())) continue;
if(preg_match("/^get \* from ".$objects[$k][0]->getNameOfClass()." where ".$ovars[$k][$l]."\=(.*);$/",$query, $matches)) {
for($ii2=0; $ii2<count($objects[$k]); $ii2++) {
if($objects[$k][$ii2]->{$ovars[$k][$l]}==$matches[1]) {
$oobj = (array)$objects[$k][$ii2];
$outp[]=$oobj;
}
}
$exitf=true;
}
}
}

if(count($outp)>0) {
return $outp;
}


return $mches;
}

}

?> 