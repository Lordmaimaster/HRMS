<?php require __DIR__ . "/../../inc/header.php" ?>
<?php require __DIR__ . "/../../config/sessionTimeout.php"; ?>
<?php require __DIR__ . "/../../config/session.php"; ?>
<?php
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if (isset($_REQUEST["POST"])){
    $date = $_POST['date'];
    $dest_from = $_POST['destination_from'];
    $dest_to = $_POST['destination_to'];
}
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	Name: <?php echo $_SESSION['name']; ?>
	<br /><br />
	Date: <input type="date" id="date" name="date" />
	<br /><br />
	From: <textarea rows="2" cols="20" id="destination_from" name="destination_from"></textarea>
	<br /><br />
	To: <textarea rows="2" cols="20" id="destination_to" name="destination_to"></textarea>
	<br /><br />
	Reason: <textarea rows="5" cols="50" id="reason" name="reason"></textarea>
	<br /><br />
	KM Travelled: <input type="text" id="km" name="km" />
	<br /><br />
	Vehicle: 
	<input type="radio" id="vehicle1" name="vehicle" value="1">Car (Company)
	<input type="radio" id="vehicle2" name="vehicle" value="2">Car (Personal)
	<input type="radio" id="vehicle3" name="vehicle" value="3">Motorcycle
	<br /><br />
	Fee: <input type="text" id="fee" name="fee" />
	<br /><br />
	Petrol: <input type="text" id="petrol" name="petrol" />
	<br /><br />
	Toll: <input type="text" id="toll" name="toll" />
	<br /><br />
	Parking: <input type="text" id="parking" name="parking" />
	<br /><br />
	Meal: <input type="text" id="meal" name="meal" />
	<br /><br />
	Entertainment: <input type="text" id="entertainment" name="entertainment" />
	<br /><br />
	Other: <input type="text" id="other" name="other" />
	<br /><br />
</form>
<?php require __DIR__ . "/../../inc/footer.php" ?>