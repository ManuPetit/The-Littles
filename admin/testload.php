<?php		//test upload
	require_once('inclusion/configuration.php');
	$page_titre ="test upload";
	include('inclusion/entete.php');
	
//If you have received a submission.
if (isset($_POST['submitted'])){
	$goodtogo = true;
	//Check for a blank submission.
	try {
	if ($_FILES['image']['size'] == 0){
	$goodtogo = false;
	throw new exception ("Sorry, you must upload an image.");
	}
} catch (exception $e) {
echo $e->getmessage();
}
//Check for the file size.
try {
if ($_FILES['image']['size'] > 500000){
$goodtogo = false;
//Echo an error message.
throw new exception ("Sorry, the file is too big at approx: ". intval ($_FILES['image']['size'] / 1000) . "KB");
}
} catch (exception $e) {
echo $e->getmessage();
}
//Ensure that you have a valid mime type.
$allowedmimes = array ("image/jpeg","image/pjpeg");
try {
if (!in_array ($_FILES['image']['type'],$allowedmimes)){
$goodtogo = false;
throw new exception ("Sorry, the file must be of type .jpg. Yours is: " . $_FILES['image']['type'] . "");
}
} catch (exception $e) {
echo $e->getmessage ();
}
//If you have a valid submission, move it, then show it.
if ($goodtogo){
try {
if (!move_uploaded_file ($_FILES['image']['tmp_name'],"../images/". $_FILES['image']['name'].".jpg")){
$goodtogo = false;
throw new exception ("There was an error moving the file.");
}
} catch (exception $e) {
echo $e->getmessage ();
}
}
if ($goodtogo){
//Display the new image.
?>
<img src="../images/<?php echo $_FILES['image']['name'] . ".jpg"; ?>" alt="" title="" />
<?php
}
?>
<br />
<a href="testload.php">Try Again</a>
<?php
}
//Only show the form if there is no submission.
if (!isset($_POST['submitted'])){
?>
<form action="testload.php" method="post" enctype="multipart/form-data">
  <p>Example:</p>
  Image Upload (.jpg only, 500KB Max):<br /><input type="file" name="image" />
  <br />
  <input type="submit" value="Submit" style="margin-top: 10px" />
  <input type="hidden" name="submitted" value="TRUE" />
</form>
<?php
}
include('inclusion/pied.php');
?>
