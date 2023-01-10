<?php
include("../config.php");
include('vendor/autoload.php');

global $error,
$msg,
$phone;
global $error_email,
$error_name,
$error_phone,
$error_pass;

if (isset($_REQUEST['reg'])) {
    if (isset($_REQUEST['name'],
        $_REQUEST['email'],
        $_REQUEST['phone'],
        $_REQUEST['pass'],
        $_REQUEST['utype'])) {
        $name  = stripslashes($_REQUEST['name']);
        $email = stripslashes($_REQUEST['email']);
        $pass = stripslashes($_REQUEST['pass']);
        $utype = $_REQUEST['utype'];

        if (($_FILES['uimage']['name'] != '')) {
            $uName = $_FILES['uimage']['name'];
            $fileTmpName = $_FILES['uimage']['tmp_name'];
            $fileSize = $_FILES['uimage']['size'];
            $fileError = $_FILES['uimage']['error'];
            $fileType = $_FILES['uimage']['type'];

            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));
            $allowed = array('jpg', 'jpeg', 'png', 'pdf');
            if (in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 1000000) {
                        $fileNameNew = uniqid('', true).".".$fileActualExt;
                        $fileDestination = 'uploads/'.$fileNameNew;
                    } else {
                        echo "Your file is too big!";
                    }
                } else {
                    echo "There was an error uploading your file!";
                }
            } else {
                echo "You cannot upload files of this type!";
            }
        }



        // verification du numero de telephone
        $phoneNumberUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $phoneNumberObject = $phoneNumberUtil->parse($_REQUEST['phone'], 'FR');
        try {
            // verifier si numero est valide avec libphonenumber
            if (!$phoneNumberUtil->isValidNumber($phoneNumberObject)) {
                $phonei = $phoneNumberUtil->format($phoneNumberObject, \libphonenumber\PhoneNumberFormat::E164);
            } else {
                $error_phone = "<p class='alert alert-warning'>Ur phone is not valid</p> ";
            }
        } catch (\libphonenumber\NumberParseException $e) {
            var_dump($e);
        }

        // verification du mot de passe avec caracteres speciaux
        $pattern = '/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%+]{4,12}$/';
        if (!preg_match($pattern, $pass)) {
            $error_pass = "<p class='alert alert-warning'>Ur password is not valid</p> ";
        }

        // verification de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_email = "<p class='alert alert-warning'>Ur email is not valid</p> ";
        }

        // verification du mail en BDD
        $query = "SELECT * FROM user where uemail='$email'";
        $res=mysqli_query($con, $query);
        $num=mysqli_num_rows($res);

        if ($num == 1) {
            $error = "<p class='alert alert-warning'>Email Id already Exist</p> ";
        } else {
            if (!empty($name) && !empty($email) && !empty($phonei) && !empty($pass)) {
                // criptage du mot de passe
                $options = [
                    'cost' => 12,
                ];
                $pass_h =  password_hash($pass, PASSWORD_BCRYPT, $options);

                $sql="INSERT INTO user (uname,uemail,uphone,upass,utype,uimage) VALUES ('$name','$email','$phonei','$pass_h','$utype', '$uimage')";
                $result=mysqli_query($con, $sql);

                if (empty($uimage)) {
                    move_uploaded_file($temp_name1, "admin/user/$uimage");
                }

                if ($result) {
                    $msg = "<p class='alert alert-success'>Register Successfully, please check Ur email</p> ";

                    // envoi de l'email
                    $from = "test@localhost";
                    $to = $email;
                    $subject = "Registration Successful";
                    $message = "your registration is successful";
                    $headers = "De :" . $from;
                    if (mail($to, $subject, $message, $headers)) {
                        $error = "<p class='alert alert-warning'>Register Successfully</p> ";
                    }
                } else {
                    $error = "<p class='alert alert-warning'>Register Not Successfully</p> ";
                }
            } else {
                $error = "<p class='alert alert-warning'>Please Fill all the fields</p>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("include/head.php");?>
    <title></title>
</head>

<body>
    <div id="page-wrapper">
        <div class="row">
            <?php include("include/header.php");?>
            <div class="banner-full-row page-banner" style="background-image:url('images/breadcromb.jpg');">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h2 class="page-name float-left text-white text-uppercase mt-1 mb-0">
                                <b>Register</b>
                            </h2>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="breadcrumb" class="float-left float-md-right">
                                <ol class="breadcrumb bg-transparent m-0 p-0">
                                    <li class="breadcrumb-item text-white"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Register</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-wrappers login-body full-row bg-gray">
                <div class="login-wrapper">
                    <div class="container">
                        <div class="loginbox">
                            <div class="login-right">
                                <div class="login-right-wrap">
                                    <h1>Register</h1>
                                    <p class="account-subtitle">Access to our dashboard</p>
                                    <?php echo $error; ?><?php echo $msg; ?>
                                    <!-- Form -->
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control"
                                                required-patern="^[A-Za-z '-]+$" placeholder="Your Name*">
                                            <?= $error_name ?>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control"
                                                placeholder="Your Email*">
                                            <?= $error_email ?>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="phone" class="form-control"
                                                placeholder="Your Phone*" maxlength="10">
                                                <?= $error_phone ?>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="pass" class="form-control"
                                                placeholder="Your Password*">
                                            <?= $error_pass ?>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="utype" value="user"
                                                    checked>User
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="utype"
                                                    value="agent">Agent
                                            </label>
                                        </div>
                                        <div class="form-check-inline disabled">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="utype"
                                                    value="builder">Builder
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label"><b>User Image</b></label>
                                            <input class="form-control" name="uimage" type="file">
                                        </div>
                                        <button class="btn btn-primary" name="reg" value="Register"
                                            type="submit">Register</button>
                                    </form>
                                    <div class="login-or">
                                        <span class="or-line"></span>
                                        <span class="span-or">or</span>
                                    </div>
                                    <div class="social-login">
                                        <span>Register with</span>
                                        <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
                                        <a href="#" class="google"><i class="fab fa-google"></i></a>
                                        <a href="#" class="facebook"><i class="fab fa-twitter"></i></a>
                                        <a href="#" class="google"><i class="fab fa-instagram"></i></a>
                                    </div>
                                    <div class="text-center dont-have">Already have an account?
                                        <a href="login.php">Login</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include("include/footer.php");?>
        </div>
    </div>
</body>

</html>