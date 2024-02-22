<?php require __DIR__ . "/../../inc/header.php"; ?>
<?php
$url = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$url .= $_SERVER['SERVER_NAME'];
$url .= htmlspecialchars($_SERVER['REQUEST_URI']);
$url = dirname($url, 2);
?>
<?php require __DIR__ . "/../../config/session.php"; ?>
<?php require __DIR__ . "/../../config/sessionTimeout.php"; ?>
<?php
if (isset($_SESSION['ID'])) {
    $ID = $_SESSION['ID'];
    if (isset($_SESSION['name'])) {
    } else {
        echo "<script>alert('Please login first');</script>";
        header("Refresh:0; url=" . $url);
        exit();
    }
} else {
    echo "<script>alert('Please login first');</script>";
    header("Refresh:0; url=" . $url);
    exit();
}
?>
<form method="post">
    <table>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Date</th>
            <th>From</th>
            <th>To</th>
            <th>Reason</th>
            <th>KM Travelled</th>
            <th>Vehicle</th>
            <th>Fee</th>
            <th>Petrol</th>
            <th>Tol</th>
            <th>Parking</th>
            <th>Meal</th>
            <th>Entertainment</th>
            <th>Other</th>
            <th>Total</th>
        </tr>
        <?php listClaims($ID); ?>
    </table>
    <input type="submit" name="btn" id="btn" value="Add" />
    <input type="submit" name="btn" id="btn" value="Edit" />
    <input type="submit" name="btn" id="btn" value="Delete" onclick="return confirm('Are you sure you want to delete?')" />
</form>
<form method="post">
    <input type="submit" name="logout" id="logout" value="Logout" />
</form>
<?php 
if(isset($_POST['btn'])){
    if(strcmp($_POST['btn'],"Add") == 0 ){
        header("Refresh:0; url=add.php");
        exit();
    }
    if(strcmp($_POST['btn'],"Edit") == 0 ){
        if(isset($_POST['claim'])){
            header("Refresh:0 url=edit.php");
            exit();
        } else {
            echo "<script>alert('Please choose a record');</script>";
            header("Refresh:0");
        }
    }
    if(strcmp($_POST['btn'],"Delete") == 0 ){
        if (isset($_POST['claim'])) {
            $claim = $_POST['claim'];
            deleteClaims($claim);
            header("Refresh:0");
        } else {
            echo "<script>alert('Please choose a record');</script>";
            header("Refresh:0");
        }
    }
}
?>
<?php require __DIR__ . "/../../inc/footer.php"; ?>
