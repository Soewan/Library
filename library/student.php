<?php
    include "connection.php";
    include "index_navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Library Management System</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
    .banner {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh; /* Full viewport height */
        background-color: #f0f0f0;
    }

    .form {
        width: 100%;
        max-width: 400px;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }
    </style>
</head>
<body>
    <div class="banner">
        <div class="form">
            <div class="form-container">
                <div class="form-btn">
                    <span onclick="login()">Login</span>
                    <span onclick="reg()">Register</span>
                    <hr id="indicator">
                </div>
                <!-- Login Form -->
                <form action="" id="loginform" method="post">
                    <input type="text" placeholder="User Name" name="student_username" required>
                    <input type="password" placeholder="Password" name="Password" id="Pass" required>
                    <span class='show-hide'><i style="margin-top:-7px;" class="fas fa-eye" id="eye"></i></span>
                    <button type="submit" class="btn" name="login">Login</button>
                </form>
                <!-- Register Form -->
                <form action="" id="regform" method="post" enctype="multipart/form-data">
                    <input type="text" placeholder="User Name" name="student_username" required>
                    <input type="text" placeholder="Full Name" name="FullName" required>
                    <input type="email" placeholder="Email" name="Email" required>
                    <input type="password" placeholder="Password" name="Password" id="Pass-reg" required>
                    <span class='show-hide-reg'><i style="margin-top:-5px;" class="fas fa-eye" id="eye-reg"></i></span>
                    <input type="text" name="PhoneNumber" placeholder="Phone Number" required>
                    <div class="label">
                        <label for="pic">Upload Picture:</label>
                    </div>
                    <input type="file" name="file" class="file" accept="image/png, image/jpeg, image/jpg">
                    <button type="submit" class="btn" name="register">Register</button>
                </form>
            </div>
        </div>
    </div>

    <?php
    // Handle Login
    if (isset($_POST['login'])) {
        $username = mysqli_real_escape_string($db, $_POST['student_username']);
        $password = mysqli_real_escape_string($db, $_POST['Password']);

        $res = mysqli_query($db, "SELECT * FROM `student` WHERE student_username='$username' AND password='$password'");
        $count = mysqli_num_rows($res);
        $row = mysqli_fetch_assoc($res);

        if ($count == 0) {
            echo "<script>alert('The username or password is incorrect.');</script>";
        } else {
            session_start();
            $_SESSION['login_student_username'] = $row['student_username'];
            $_SESSION['studentid'] = $row['studentid'];
            $_SESSION['pic'] = $row['studentpic'];
            echo "<script>window.location='student_dashboard.php';</script>";
        }
    }

    // Handle Registration
    if (isset($_POST['register'])) {
        $username = mysqli_real_escape_string($db, $_POST['student_username']);
        $fullname = mysqli_real_escape_string($db, $_POST['FullName']);
        $email = mysqli_real_escape_string($db, $_POST['Email']);
        $password = mysqli_real_escape_string($db, $_POST['Password']);
        $phone = mysqli_real_escape_string($db, $_POST['PhoneNumber']);

        $res = mysqli_query($db, "SELECT * FROM `student` WHERE student_username='$username'");
        if (mysqli_num_rows($res) > 0) {
            echo "<script>alert('This username is already registered.');</script>";
        } else {
            // Handle file upload
            $uploadDir = 'images/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $imgPath = 'user2.png'; // Default image
            if (!empty($_FILES["file"]["name"])) {
                $imgName = basename($_FILES["file"]["name"]);
                $imgPath = $uploadDir . $imgName;
                move_uploaded_file($_FILES["file"]["tmp_name"], $imgPath);
            }

            $query = "INSERT INTO `student` (student_username, FullName, Email, password, PhoneNumber, studentpic) 
                      VALUES ('$username', '$fullname', '$email', '$password', '$phone', '$imgPath')";
            mysqli_query($db, $query);

            echo "<script>alert('Registration successful.');</script>";
        }
    }
    ?>

    <script>
        var LoginForm = document.getElementById("loginform");
        var regform = document.getElementById("regform");
        var indicator = document.getElementById("indicator");

        function reg() {
            regform.style.transform = "translateX(-365px)";
            LoginForm.style.transform = "translateX(-400px)";
            indicator.style.transform = "translateX(150px)";
        }

        function login() {
            regform.style.transform = "translateX(0px)";
            LoginForm.style.transform = "translateX(0px)";
            indicator.style.transform = "translateX(0px)";
        }

        // Toggle password visibility
        document.getElementById("eye").addEventListener("click", function() {
            togglePasswordVisibility("Pass", this);
        });

        document.getElementById("eye-reg").addEventListener("click", function() {
            togglePasswordVisibility("Pass-reg", this);
        });

        function togglePasswordVisibility(fieldId, icon) {
            var field = document.getElementById(fieldId);
            if (field.type === "password") {
                field.type = "text";
                icon.classList.add("hide");
            } else {
                field.type = "password";
                icon.classList.remove("hide");
            }
        }
    </script>
</body>
</html>
