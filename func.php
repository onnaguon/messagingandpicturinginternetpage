<?php
function rrmdir($dir) {
$files = array_diff(scandir($dir), array('.','..'));
foreach ($files as $file) {
(is_dir("$dir/$file")) ? rrmdir("$dir/$file") : unlink("$dir/$file");
}
return rmdir($dir);
}
?> 