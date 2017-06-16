<?php 
include('db.php');

if(isset($_GET['id'])) 
{
// if id is set then get the file with the id from database


$id    = $_GET['id'];
$rows=$db->select('upload',"id='$id'");

$size=$rows[0]['filesize'];
$type=$rows[0]['filetype'];
$name=$rows[0]['filename'];
$content=$rows[0]['filecontent'];

header("Content-length: $size");
header("Content-type: $type");

if (isset($_GET['download'])) {header("Content-Disposition: attachment;filename=$name");}
echo $content;

exit;
}

?>