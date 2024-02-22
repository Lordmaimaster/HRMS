<!DOCTYPE html>
<html>
<head>
    <meta lang="en" />
    <link rel="stylesheet" href="styles/styles.css" />
    <?php
    include 'controller\databaseController.php';
    session_start();
    ?>
    <title>Ar-Rifqi Sdn Bhd Human Resource System</title>
</head>
<body>
    <h1>Ar-Rifqi Sdn Bhd Human Resource System</h1>
    <form method="post">
        <label for="email">Please enter your email</label><br />
        <input type="text" name="email" value="" /><br /><br />
        <input type="submit" name="btn" value="submit" />
    </form>
    <?php
    if (isset($_POST['btn'])) {
        if (strcmp($_POST['btn'], "submit") == 0) {
            verifyUserExist();
        }
    }
    function verifyUserExist()
    {
        if (is_null($_POST['email']) || $_POST['email'] === "") {
            echo '<script>alert("Please Enter a Username");</script>';
        } else {
            $conn = connectDB();
            $sql = $conn->prepare("SELECT * FROM staff WHERE email=?");
            $sql->bind_param("s", $_POST['email']);
            $sql->execute();
            $result = $sql->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                    if ($_POST['email'] == $row['email']) {
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                        $msg = '<html>
                                <head>
                                </head>
                                <body>
                                    Click on this <a href="localhost/ARSB_HRS/passwordReset.php?id= '. $row['id'] .'">link</a> to reset your password
                                </body>
                                </html>';
                        mail($row['email'], "Password Reset", $msg, $headers);
                        echo '<script>alert("Instructions has been sent to your email");</script>';
                    } else
                        echo '<script>alert("Username Not in Database");</script>';
            }
            $sql->close();
            $conn->close();
        }
    }
    function forgotPassword()
    {
        header('Location:forgotPassword.php');
        exit();
    }
    ?>
</body>
</html>