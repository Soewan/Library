<?php
	include "connection.php";
    include "student_navbar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
	<div class="profile">
	<div class="profile-container">
        <h2 class="co-title">My Profile</h2>
        <div class="profile-small-container">
        <?php
			$q = mysqli_query($db, "SELECT * FROM student WHERE studentid='{$_SESSION['studentid']}';");
			$row = mysqli_fetch_assoc($q);

            echo "<div class='select-img'>
                 <a href='" . htmlspecialchars($row['studentpic']) . "'><img class='profile-page-img' src='" . htmlspecialchars($row['studentpic']) . "'></a>
            </div>";
			
            echo "<b>";
			echo "<table class='profile-table table-bordered'>";
			echo "<tr>"; 
			echo "<td><b> Student ID: </b></td>";
			echo "<td>" . htmlspecialchars($row['studentid']) . "</td>";
			echo "</tr>";

            echo "<tr>";
			echo "<td><b> User Name: </b></td>";
			echo "<td>" . htmlspecialchars($row['student_username']) . "</td>";
			echo "</tr>";

			echo "<tr>";
			echo "<td><b> Full Name: </b></td>";
			echo "<td>" . htmlspecialchars($row['FullName']) . "</td>";
			echo "</tr>";

			echo "<tr>";
			echo "<td><b> Email: </b></td>";
			echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
			echo "</tr>";

			echo "<tr>";
			echo "<td><b> Password: </b></td>";
			echo "<td>" . htmlspecialchars($row['Password']) . "</td>";
			echo "</tr>";

			echo "<tr>";
			echo "<td><b> Phone Number: </b></td>";
			echo "<td>" . htmlspecialchars($row['PhoneNumber']) . "</td>";
			echo "</tr>";

			echo "</table>";
            echo "</b>";
        ?>
        </div>
    </div>
	</div>
	<?php
		if (isset($_POST['profileimg'])) {
            $uploadDir = "images/";
            $filePath = $uploadDir . basename($_FILES['file']['name']);
            
            if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
                $pic = basename($_FILES['file']['name']);
                $_SESSION['pic'] = $filePath;

                $q1 = "UPDATE student SET studentpic='$filePath' WHERE studentid='{$_SESSION['studentid']}';";
				if (mysqli_query($db, $q1)) {
                    echo "<script>alert('Profile picture is updated successfully.'); window.location='profile.php';</script>";
                } else {
                    echo "<script>alert('Error updating profile picture in the database.');</script>";
                }
            } else {
                echo "<script>alert('Error uploading the file.');</script>";
            }
		}
	?>
</body>
</html>
