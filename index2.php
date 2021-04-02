<!DOCTYPE html>
<html>
<head>
<link rel="icon" style="width:15px; height=15px; background-color: #76FEFF; color: #76FEFF;"/>

<style>
input {
color: #76FEFF;
}

body {
background-color: #76FEFF;
}

.file1 {
text-decoration: none;
color: #76FEFF;
}

.main1 {
text-decoration:none;
color: #76FEFF;
background-color: white;
border: 1px solid white;
border-radius: 5px 5px;
padding: 5px;
font-weight:bold;
width:100px;
}

.main2 {
color: white;
margin-top:-15px;
}

.main3 {
text-decoration:none;
color: #76FEFF;
background-color: white;
border: 1px solid white;
border-radius: 5px 5px;
padding: 5px;
font-weight:bold;
width:100px;
}

.main4 {
color: white;
width: 140px;
}

.main5 {
color: white;
margin-top:-15px;
margin-bottom:1px;
}
.main6 {
color: white;
margin-top:15px;
width:600px;
overflow-wrap: break-word;
}
.main7 {
margin-bottom:1px;
}

.text1 {
color: #76FEFF;
width: 538px;
height: 29px;
margin-top:-15px;
overflow-wrap: break-word;
}

textarea {
color: black;
}
form {
line-height: 1.4;
}

.a1 {
line-height: 1.4;
width: 561px;
height: 357px;
overflow-y: auto;
overflow-x: hidden;
background-color: white;
overflow-wrap: break-word;
color: #76FEFF;
}

.a1 p {
height:0.001%;
margin-bottom:-15px;
}
.nameslist {
margin-bottom:15px;
}
</style>
<script>
function imgError(image) {
image.onerror = "";
image.src = "../noimage.jpg";
image.style="background-color: #848587;";
image.width="40px";
image.height="40px";
return true;
}
</script>
</head>
<body onload="a00000()">

<?php

include("func.php");


$size = 0;

$files = glob('uploads/*.*');
usort($files, function($a, $b) {
return filemtime($a) < filemtime($b);
});
$idx=0;

$files = array_reverse($files, true);

if(is_dir("uploads")) {
foreach($files as $file) {
if($idx==count($files)-1) break;
$filesize = filesize($file);
$size+=$filesize;
$idx++;
}
$idx=0;
if($size>5000000) {
foreach($files as $file) {
if($idx==count($files)-1) break;
unlink($file);
$idx++;
}
}
}


$size = 0;

$files = glob('dpic/*.*');
usort($files, function($a, $b) {
return filemtime($a) < filemtime($b);
});
$idx=0;

$files = array_reverse($files, true);

if(is_dir("dpic")) {
foreach($files as $file) {
if($idx==count($files)-1) break;
$filesize = filesize($file);
$size+=$filesize;
$idx++;
}
$idx=0;
if($size>5000000) {
foreach($files as $file) {
if($idx==count($files)-1) break;
unlink($file);
$idx++;
}
}
}

include("../data.php");

class Password extends Dobj{
var $content;
}

class Msg extends Dobj{
var $text;
}

class Inimene extends Dobj{
var $name;
var $time;
var $dpic;
}

class Picture extends Dobj{
var $name;
var $time;
}

$myd=new Data();

$myd->loadobjecttables();


$itime2=$myd->gettime();
$itime2=date( 'd.m.Y H:i:s', strtotime( '+3 hour' , strtotime($itime2) ) );

if(!is_dir("uploads")) {
mkdir("uploads", 0777);
}

if(!is_dir("dpic")) {
mkdir("dpic", 0777);
}

$files1 = scandir("uploads");

if(count($files1)>270) {
rrmdir("uploads");
mkdir("uploads", 0777);
}



$msg=new Msg();
$name1 = strip_tags($_POST['text0']);

if($name1!="") {
$name1=substr($name1,0, 646);
}

$addline=true;

$tabls=$myd->dtables;

$time=null;
$tidx=-1;
$nooutput=false;
$oput="";

$pwd1="";

if($tabls!=null) {
for($i=0; $i<count($tabls); $i++) {
$oc=$tabls[$i][0]->getNameOfClass();
if ($oc=="Password") {
$pwd1=$tabls[$i][0]->content;
}
}
}

$pwdactive=0;
if($pwd1!="") {

if($pwd1!=$_GET['code']) exit(0);

} else {
$pwdactive=1;
}


if($tabls!=null&&(count($tabls)>1)&&$pwdactive==1||$pwdactive==0&&$tabls!=null) {


$foundtime=false;
for($i=0; $i<count($tabls); $i++) {
$oc=$tabls[$i][0]->getNameOfClass();
if ($oc=="Inimene") {
$times1=array();
for($ii=0; $ii<count($tabls[$i]); $ii++) {
$times1[]=$tabls[$i][$ii]->time;
}
$latestt=max(array_map('strtotime', $times1));
$time=date('d.m.Y H:i:s', $latestt);
$foundtime=true;
}
}
if($foundtime) {
$dtimenow = new DateTime($itime2);
$dtime = new DateTime($time);
$diff = $dtimenow->getTimestamp() - $dtime->getTimestamp();
if($diff<1) {
$nooutput=true;
}
}
if(!$foundtime) {
$time=$itime2;
}
} else {
$time=$itime2;
}


$pic_uploaded=false;

$newpic1=null;

if(isset($_POST["submit"])&&$_FILES["fileToUpload"]['error']==0&&$nooutput==false) {
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if (file_exists($target_file)) {
$uploadOk = 0;
}
if ($_FILES["fileToUpload"]["size"] > 5000000) {
$uploadOk = 0;
}
if($imageFileType=="php") {
$uploadOk = 0;
}
$time1212=time();

if ($uploadOk == 0) {
} else {
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], str_replace('.', $time1212.'.', $target_file))) {
$pic_uploaded=true;
} else {
}
}


$newpic=null;
$tabls0=null;
if($pic_uploaded==true) {
$tabls0=$myd->dtables;
$picstidx=-1;
if($tabls0!=null) {
for($i=0; $i<count($tabls0); $i++) {
$oc0=$tabls0[$i][0]->getNameOfClass();
if ($oc0=="Picture") {
$picstidx=$i;
}
}
if($picstidx==-1) {
$picstidx=count($tabls0);
$tabls0[]=array();
}
} else {
$tabls0=array();
$tabls0[]=array();
$picstidx=0;
}

$newpic=new Picture();
$newpic->name=basename(str_replace('.', $time1212.'.', $_FILES["fileToUpload"]["name"]));
$newpic->time=$itime2;
$newpic1=$newpic;
$tabls0[$picstidx][]=$newpic;
$myd->dtables=$tabls0;
$myd->saveobjecttable("Picture");
}

}

$url = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$url .= $_SERVER['SERVER_NAME'];
$url .= $_SERVER['REQUEST_URI'];
$info = parse_url($url);
$info["path"]=dirname($info["path"]);

$new_url = $info["scheme"]."://".$info["host"];
//if(!empty($info["query"])) $new_url .= "?".$info["query"];
//$new_url=substr($new_url,0,-1);
//if(!empty($_SERVER["SERVER_PORT"])) $new_url .=":".$_SERVER["SERVER_PORT"];
//if(!empty($info["fragment"])) $new_url .= "#".$info["fragment"];

$new_url = str_replace(' ', '', $new_url);

echo "<a class='main1' href='".$new_url."'>Avalehele</a><p></p>";

function strip($var) {
$allowed = '<font>';
return strip_tags($var, $allowed);
}

function closetags ( $html )
{
preg_match_all ( "#<([a-z]+)( .*)?(?!/)>#iU", $html, $result );
$openedtags = $result[1];

preg_match_all ( "#</([a-z]+)>#iU", $html, $result );
$closedtags = $result[1];
$len_opened = count ( $openedtags );

if( count ( $closedtags ) == $len_opened )
{
return $html;
}
$openedtags = array_reverse ( $openedtags );

for( $i = 0; $i < $len_opened; $i++ )
{
if ( !in_array ( $openedtags[$i], $closedtags ) )
{
$html .= "</" . $openedtags[$i] . ">";
}
else
{
unset ( $closedtags[array_search ( $openedtags[$i],
$closedtags)] );
}
}
return $html;
}



$ind=array();
$itidx=-1;
if($tabls!=null) {
for($i=0; $i<count($tabls); $i++) {
$oc=$tabls[$i][0]->getNameOfClass();
if ($oc=="Inimene") {
$ind=$tabls[$i];
$itidx=$i;
}
}
}

if($ind!=null) {
if(count($ind)>2499) {
echo "Topic full(2500).";
exit(0);
}
}

$itime=$_POST['itime'];

if($itime==""||$itime==null) {
$itime=$myd->gettime();
$itime=date( 'd.m.Y H:i:s', strtotime( '+3 hour' , strtotime($itime) ) );
$time=$itime;
}

if($nooutput==false) {

$currenti=null;
$iexists=false;

for($i=0; $i<count($ind); $i++) {
if($ind[$i]->time==$itime) {
$currenti=$ind[$i];
}
}

for($i=0; $i<count($ind); $i++) {
if($ind[$i]->name==$name1) {
$iexists=true;
}
}


if(count($ind)>0) {
if($name1!=""&&$currenti==null&&$iexists==false) {
$curi=new Inimene();
$curi->name=$name1;
$curi->time=$itime;
$ind[]=$curi;
$tabls[$itidx]=$ind;
$myd->dtables=$tabls;
$myd->saveobjecttable("Inimene");
$currenti=$curi;
} if($name1!=""&&$currenti==null&&$iexists==true) {
$name1="";
$addline=false;
$nooutput=true;
} else if($name1!=""&&$currenti->name!=""&&$name1!=$currenti->name&&$iexists==false)
{
$currenti->name=$name1;
$currenti->time=$itime2;
$itime=$itime2;
$myd->dtables=$tabls;
$myd->saveobjecttable("Inimene");

} else if($name1!=""&&$currenti->name!=""&&$name1!=$currenti->name&&$iexists==true)
{
$name1=$currenti->name;
$addline=false;
$nooutput=true;
} else if($name1!=""&&$currenti->name!=""&&$name1==$currenti->name)
{
$currenti->time=$itime2;
$itime=$itime2;
$myd->dtables=$tabls;
$myd->saveobjecttable("Inimene");
} else {
$addline=false;
}

} else {
if($name1!=""&&$iexists==false&&$currenti!=null) {
$curi=new Inimene();
$curi->name=$name1;
$curi->time=$itime2;
$itime=$itime2;
$ind12=array();
$ind12[]=$curi;
$tabls[]=$ind12;
$myd->dtables=$tabls;
$myd->saveobjecttables();
$currenti=$curi;

} if($name1!=""&&$iexists==false&&$currenti==null) {
$curi=new Inimene();
$curi->name=$name1;
$curi->time=$itime2;
$itime=$curi->time;
$ind12=array();
$ind12[]=$curi;
$tabls[]=$ind12;
$myd->dtables=$tabls;
$myd->saveobjecttables();
$currenti=$curi;
}
else if($name1!=""&&$iexists==true) {
$name1="";
$addline=false;
$nooutput=true;
} else {
$addline=false;
$nooutput=true;
}
}

$pic_uploaded2=false;


if(isset($_POST["submit"])&&$_FILES["fileToUpload2"]['error']==0) {
$target_dir = "dpic/";
$target_file = $target_dir . basename($_FILES["fileToUpload2"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if (file_exists($target_file)) {
$uploadOk = 0;
}
if ($_FILES["fileToUpload2"]["size"] > 5000000) {
$uploadOk = 0;
}
if($imageFileType=="php"||!($imageFileType=="jpg"||$imageFileType=="png"||$imageFileType=="gif"||$imageFileType=="jpeg")) {
$uploadOk = 0;
}
$time1212=time();
if ($uploadOk == 0) {
} else {
if (move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], str_replace('.', $time1212.'.', $target_file))) {
chmod(str_replace('.', $time1212.'.', $target_file), 0744);
$pic_uploaded2=true;
} else {
}
}

$newpic2=null;
$tabls0=null;
if($pic_uploaded2==true) {
$tabls0=$myd->dtables;
$picstidx=-1;
if($tabls0!=null) {
for($i=0; $i<count($tabls0); $i++) {
$oc0=$tabls0[$i][0]->getNameOfClass();
if ($oc0=="Picture") {
$picstidx=$i;
}
}
if($picstidx==-1) {
$picstidx=count($tabls0);
$tabls0[]=array();
}
} else {
$tabls0=array();
$tabls0[]=array();
$picstidx=0;
}

$newpic2=new Picture();
$newpic2->name=basename(str_replace('.', $time1212.'.', $_FILES["fileToUpload2"]["name"]));
$newpic2->time=$itime2;
$tabls0[$picstidx][]=$newpic2;
$myd->dtables=$tabls0;
$myd->saveobjecttable("Picture");
$currenti->dpic=$newpic2->name;

$tabls0=$myd->dtables;
$itidx2=-1;
if($tabls0!=null) {
for($i=0; $i<count($tabls0); $i++) {
$oc0=$tabls0[$i][0]->getNameOfClass();
if ($oc0=="Inimene") {
$itidx2=$i;
}
}
}

for($i=0; $i<count($tabls0[$itidx2]); $i++) {
if($tabls0[$itidx2][$i]->name==$currenti->name&&$tabls0[$itidx2][$i]->time==$currenti->time) {
$myd->dtables=$tabls0;
$myd->saveobjecttable("Inimene");
}
}


}

}


$msg1=strip($_POST['text1']);
$msg1 = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $msg1);
$msg12=$msg1;

if($currenti->dpic!=""||$currenti->dpic!=null) {
$msg->text=$itime2." ".$name1." <img src='dpic/".$currenti->dpic."' onerror='imgError(this);' style='width: 50px;' > : ".$msg1;
} else {
$msg->text=$itime2." ".$name1." : ".$msg1;
}
$msg->text=substr($msg->text,0, 216345);
$msg->text=closetags($msg->text);
$texists=false;
$msgtidx=0;

$t1=$myd->dtables;


for($i=0; $i<count($t1);$i++) {
if($t1[$i][0]->getNameOfClass()=="Msg") {
$msgtidx=$i;
$texists=true;
if(count($t1[$i])>165) {
$arr12 = array_slice($t1[$i], -165);
$t1[$i]=$arr12;
$myd->dtables=$t1;
$myd->saveobjecttable("Msg");
break;
}
break;
}
}
$tabls=$myd->dtables;


if(!empty($_POST['text1'])&&$addline==true) {
if (strlen(trim($msg1)) != 0&&$pic_uploaded==true) {
if($texists==false) {
$aone=array();
$ftype = strtolower(pathinfo("uploads/".$newpic1->name,PATHINFO_EXTENSION));
if($ftype=="jpg"||$ftype=="png"||$ftype=="jpeg"||$ftype=="gif") {

$imgsize = getimagesize("uploads/".$newpic1->name);
$width=$imgsize[0];
$height=$imgsize[1];
if($width>450) {
//$multip=$width/250;
$width=450;
//$height=$height/$multip;
}
$msg->text.="<p></p><img src='uploads/".$newpic1->name."' onerror='imgError(this);' style='width: ".$width."px;' >";
} else {
$msg->text.="<p></p><a class='file1' href='uploads/".$newpic1->name."'>File: ".$newpic1->name."</a>";
}
$aone[]=$msg;
$tabls[]=$aone;
$myd->dtables=$tabls;
$myd->saveobjecttable("Msg");
} else {
$ftype = strtolower(pathinfo("uploads/".$newpic1->name,PATHINFO_EXTENSION));
if($ftype=="jpg"||$ftype=="png"||$ftype=="jpeg"||$ftype=="gif") {
$imgsize = getimagesize("uploads/".$newpic1->name);
$width=$imgsize[0];
$height=$imgsize[1];
if($width>450) {
//$multip=$width/250;
$width=450;
//$height=$height/$multip;
}
$msg->text.="<p></p><img src='uploads/".$newpic1->name."' onerror='imgError(this);' style='width: ".$width."px;'/>";
} else {
$msg->text.="<p></p><a class='file1' href='uploads/".$newpic1->name."'>File: ".$newpic1->name."</a>";
}

$tabls[$msgtidx][]=$msg;
$myd->dtables=$tabls;
$myd->saveobjecttable("Msg");
}
} else if (strlen(trim($msg1)) != 0&&$pic_uploaded==false) {
if($texists==false) {
$aone=array();
$aone[]=$msg;
$tabls[]=$aone;
$myd->dtables=$tabls;
$myd->saveobjecttable("Msg");
} else {
$tabls[$msgtidx][]=$msg;
$myd->dtables=$tabls;
$myd->saveobjecttable("Msg");
}
}
$t2=$myd->query("get text from Msg;");
for($i=0; $i<count($t2);$i++) {
$oput.=$t2[$i]."<p></p>";
}
} else {
if($texists==true) {
$t2=$myd->query("get text from Msg;");
for($i=0; $i<count($t2);$i++) {
$oput.=$t2[$i]."<p></p>";
}
}
}

}

?>
<div class="a1" spellcheck="false">
<?php echo $oput;
?>
</div>
<p></p>
<form method="POST" enctype="multipart/form-data">
<input name="itime" id="itime" type="hidden" value="<?php echo $itime; ?>"/>
<p class="main2">Nimi: <input name="text0" id="text0" type="text"
style="width: 114px;" value="<?php echo $name1; ?>"> </p>
<p class="main2">Sõnum:</p>
<textarea class="text1" name="text1" id="text1" type="text">
<?php
if($nooutput==true) {
echo $msg12;
}
?>
</textarea>
<p></p>
<p class="main5">Pilt või muud tüüpi fail (kuni 5 mb'd):</p>
<input type="file" class="main4" name="fileToUpload" id="fileToUpload"/>
<p></p>
<p></p>
<p></p>
<p class="main5">Mini pilt (kuni 5 mb'd):</p>
<input type="file" class="main4" name="fileToUpload2" id="fileToUpload2"/>

<input type="submit" name="submit" class="main3" value="Saada"/>
</form>

<p></p>
<p class="main2">Aktiivsed:</p>
<div class="main2" id="ilist">
</div>
<script>

function nl2br (str, is_xhtml) {
if (typeof str === 'undefined' || str === null) {
return '';
}
var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />'
: '<br>';
return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' +
breakTag + '$2');
}

if (!String.prototype.unescapeHTML) {
String.prototype.unescapeHTML = function() {
return this.replace(/&[#\w]+;/g, function (s) {
var entityMap = {
"&amp;": "&",
"&lt;": "<",
"&gt;": ">",
'&quot;': '"',
'&#39;': "'",
'&#x2F;': "/",
'&nbsp;': " "
};

return entityMap[s];
});
};
}

var prevr="";
var r0="";

function renewing() {
var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == XMLHttpRequest.DONE) {
if (xmlhttp.status == 200) {
xmlhttp.responseText=nl2br(xmlhttp.responseText);
var a111=xmlhttp.responseText;
r0=a111;
a111=a111.unescapeHTML();
document.getElementsByClassName("a1")[0].innerHTML = a111;
}
else if (xmlhttp.status == 400) {
alert('Error 400');
}
else {
alert('Not 200 returned');
}
}
};
var d765=new Date();
xmlhttp.open("GET", "renewing.php?d="+d765, false);
xmlhttp.setRequestHeader('Cache-Control', 'no-cache');
xmlhttp.send();
if(prevr!=r0) {
a00000();
}
prevr=r0;

}

function renewingilist() {
var xmlhttp = new XMLHttpRequest();

xmlhttp.onreadystatechange = function() {
if (xmlhttp.readyState == XMLHttpRequest.DONE) {
if (xmlhttp.status == 200) {
document.getElementById("ilist").innerHTML = xmlhttp.responseText;
}
else if (xmlhttp.status == 400) {
alert('Error 400');
}
else {
alert('Not 200 returned');
}
}
};
var d765=new Date();
xmlhttp.open("GET", "ilist.php?d="+d765, false);
xmlhttp.setRequestHeader('Cache-Control', 'no-cache');
xmlhttp.send();
}


function a00000() {
var textarea = document.getElementsByClassName("a1")[0];
textarea.scrollTop = 50000000;
}

setInterval(function(){
renewing();
}, 1578);

setInterval(function(){
renewingilist();
}, 3953);


setInterval(function(){

var namearea = document.getElementById("text0");
var isFocused = (document.activeElement === namearea);
if(isFocused) {
} else {
document.getElementById('text1').focus();
}
}, 6871);

</script>
</body>

</html> 