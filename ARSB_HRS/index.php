<?php require __DIR__ . "/inc/header.php"?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="email">Email</label><br />
            <input type="text" name="email" value="" /><br />
            <label for="password">Password</label><br />
            <input type="password" name="password" value="" /><br /><br />
            <input type="submit" name="btn" value="login" />
            <input type="submit" name="btn" value="forgot password" />
        </form>
        <?php
        if(isset($_POST['btn'])){
            if (strcmp($_POST['btn'], "login") == 0) {
                if (is_null($_POST['email']) || $_POST['email'] === "") {
                    echo '<script>alert("Please Enter an Email");</script>';
                } else if (is_null($_POST['password']) || $_POST['password'] === "") {
                    echo '<script>alert("Please Enter a Password");</script>';
                } else {
                    $conn = connectDB();
                    $sql = $conn->prepare("SELECT * FROM staff WHERE email=?");
                    $sql->bind_param("s", $_POST['email']);
                    $sql->execute();
                    $result = $sql->get_result();
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        if (password_verify($_POST['password'], $row['password'])) {
                            echo '<script>alert("Login Successfully");</script>';
                            $_SESSION['ID'] = $row['id'];
                            $_SESSION['name'] = $row['name'];
                            switch ($row['position']){
                                case 1:
                                case 2:
                                    header('Refresh:0; url=views/leaves/director/');
                                    $sql->close();
                                    $conn->close();
                                    exit();
                                case 3:
                                    header('Refresh:0; url=views/leaves/hr/');
                                    $sql->close();
                                    $conn->close();
                                    exit();
                                case 5:
                                case 6:
                                case 11:
                                    header('Refresh:0; url=views/leaves/management/');
                                    $sql->close();
                                    $conn->close();
                                    exit();
                                default:
                                    header('Refresh:0; url=views/leaves/');
                                    $sql->close();
                                    $conn->close();
                                    exit();
                            }
                        } else {
                            echo '<script>alert("Wrong email/password");</script>';
                            $sql->close();
                            $conn->close();
                            exit();
                        }
                    }
                    echo '<script>alert("Wrong email/password");</script>';
                    $sql->close();
                    $conn->close();
                    exit();
                }
            } else if (strcmp($_POST['btn'], "forgot password") == 0) {
                header('Location:forgotPassword.php');
                exit();
            }
        }
        ?>
<?php require __DIR__ . "/inc/footer.php" ?>