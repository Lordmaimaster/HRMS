<?php require __DIR__ . "/../../../inc/header.php" ?>
<?php
$url = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$url .= $_SERVER['SERVER_NAME'];
$url .= htmlspecialchars($_SERVER['REQUEST_URI']);
$url = dirname($url,3);
?>
<?php require __DIR__ . "/../../../config/sessionTimeout.php"; ?>
<?php require __DIR__ . "/../../../config/session.php"; ?>
<?php
if(isset($_SESSION['ID'])){
    $ID = $_SESSION['ID'];
    if (isset($_SESSION['name'])){
    } else {
        echo "<script>alert('Please login first');</script>";
        header("Refresh:0; url=".$url);
        exit();
    }
} else {
    echo "<script>alert('Please login first');</script>";
    header("Refresh:0; url=".$url);
    exit();
}
?>
<form method="post">
    <table>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Reason</th>
            <th>Date From</th>
            <th>Date To</th>
            <th>Type of Leave</th>
            <th>Approval</th>
        </tr>
        <?php listLeavesManager($ID); ?>
    </table>
    <input type="submit" name="btn" id="btn" value="Approve" />
    <input type="submit" name="btn" id="btn" value="Disapprove" />
    <input type="submit" name="btn" id="btn" value="Back" />
</form>
<?php
if(isset($_POST['btn'])){
    if(strcmp($_POST['btn'],"Approve") == 0){
        if (isset($_POST['leave'])) {
            $leave = $_POST['leave'];
            approveManager($leave);
            header("Refresh:0;");
            exit();
        } else {
            echo "<script>alert('Please choose a record');</script>";
            header("Refresh:0");
        }
    }
    if (strcmp($_POST['btn'], "Disapprove") == 0) {
        if (isset($_POST['leave'])) {
            $leave = $_POST['leave'];
            disapprove($leave);
            header("Refresh:0;");
            exit();
        } else {
            echo "<script>alert('Please choose a record');</script>";
            header("Refresh:0");
        }
    }
    if (strcmp($_POST['btn'], "Back") == 0){
        header("Refresh:0; url=index.php");
        exit();
    }
}
?>
<?php require __DIR__ . "/../../../inc/footer.php" ?>