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

$errorReason = $errorFrom = $errorTo = $errorType = "";
$error1 = $error2 = $error3 = $error4 = true;

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (strcmp($_POST["btn"], "Submit") == 0) {
        $ID = $_SESSION['ID'];
        if (isset($_POST['reason'])) {
            if ($_POST['reason'] == null || $_POST['reason'] == "" || empty($_POST['reason'])) {
                $_POST['reason'] = "";
                $errorReason = "Need to write down a reason";
                $error1 = true;
            } else {
                $reason = test_input($_POST['reason']);
                if (preg_match("/^[a-zA-Z-' ]*$/", $reason))
                    $error1 = false;
                else {
                    $errorReason = "Only letters and whitespaces allowed";
                    $error1 = true;
                }
            }
        }
        if (isset($_POST['date_from'])) {
            if ($_POST['date_from'] === null || $_POST['date_from'] === "" || empty($_POST['date_from'])) {
                $_POST['date_from'] = "";
                $errorFrom = "Need to choose a start date";
                $error2 = true;
            } else {
                $date_from = $_POST['date_from'];
                $error2 = false;
            }
        }
        if (isset($_POST['date_to'])) {
            if ($_POST['date_to'] == null || $_POST['date_to'] == "") {
                $_POST['date_to'] = "";
                $errorTo = "Need to choose a end date";
                $error3 = true;
            } else {
                $date_to = $_POST['date_to'];
                $error3 = false;
            }
        }
        if (isset($_POST['type'])) {
            if ($_POST['type'] == null || $_POST['type'] == 0) {
                $_POST['type'] = 0;
                $errorType = "Need to choose the type of leave";
                $error4 = true;
            } else {
                if (is_numeric($_POST['type'])) {
                    $type = $_POST['type'];
                    $error4 = false;
                } else {
                    echo "<script>alert('There seems to be an error. Please try again later')";
                    $error4 = true;
                }
            }
        }
        if ($error1 || $error2 || $error3 || $error4)
            echo "<script>alert('Please fill in the specified errors')</script>";
        else {
            addLeave($ID, $reason, $date_from, $date_to, $type);
            header("Refresh:0; url=index.php");
            exit();
        }
    }
    if (strcmp($_POST["btn"], "Back") == 0){
        header("Refresh:0; url=index.php");
        exit();
    }
}
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    Name: <?php echo $_SESSION['name'] ?>
    <br /><br />
    Reason: <textarea name="reason" id="reason" rows="1" cols="100"></textarea>
    <span class="error">*<?php echo $errorReason ?></span>
    <br /><br />
    Date From: <input type="date" name="date_from" id="date_from" />
    <span class="error">*<?php echo $errorFrom ?></span>
    <br /><br />
    Date To: <input type="date" name="date_to" id="date_to" />
    <span class="error">*<?php echo $errorTo ?></span>
    <br /><br />
    Type of Leave:
    <select name="type" id="type">
        <option value="0"></option>
        <option value="1">Annual Leave</option>
        <option value="2">Medical Leave</option>
        <option value="3">Emergency Leave</option>
    </select>
    <span class="error">*<?php echo $errorType ?></span>
    <br /><br />
    <input type="submit" name="btn" id="btn" value="Submit" />
    <input type="submit" name="btn" id="btn" value="Back" />
</form>
<?php require __DIR__ . "/../../inc/footer.php" ?>