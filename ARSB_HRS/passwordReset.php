<!DOCTYPE html>
<html>
<head>
    <meta lang="en" />
    <link rel="stylesheet" href="styles/styles.css" />
    <?php
    include 'controller\databaseController.php';
    $passErr = $cPassErr = "";
    $error1 = $error2 = TRUE;
    ?>
    <style>
        .error {
            color: #FF0000;
        }
    </style>
    <title>Ar-Rifqi Sdn Bhd Human Resource System</title>
</head>
<body>
    <?php $id = $_GET['id']; ?>
    <form method="post">
        <label for="newPassword">New Password</label><br />
        <input type="password" name="newPassword" />
        <span class="error">* <?php echo $passErr; ?></span><br />
        <label for="cPassword">Confirm Password</label><br />
        <input type="password" name="cPassword" />
        <span class="error">* <?php echo $cPassErr; ?></span>
        <br /><br />
        <input type="submit" name="submit" value="Submit" />
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (empty($_POST['newPassword'])){
            $passErr = "Cannot be empty";
            $error1 = true;
        }
        else {
            $error1 = false;
        }
        if (empty($_POST['cPassword'])){
            $cPassErr = "Cannot be empty";
            $error2 = true;
            if(strcmp($_POST['newPassword'],$_POST['cPassword']) === 0){
                $cPassErr = "Passwords must be the same";
                $error2 = true;
            }
            else {
                $error2 = false;
            }
        }else {
            $error2 = false;
        }
        if(!$error1 && !$error2){
            passwordReset($id, $_POST['cPassword']);
            header("Refresh:0; url=index.php");
            exit();
        }
    }
    ?>
</body>
</html>