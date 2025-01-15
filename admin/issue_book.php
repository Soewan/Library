<?php
	include "connection.php";
    include "admin_navbar.php";
    $res1=mysqli_query($db,"SELECT * FROM authors");
	$res2=mysqli_query($db,"SELECT * FROM category");
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
    <style>
        .form-container {
            text-align: center;
        }
        .form-btn span {
            font-size: 22px;
            color: #333;
            font-weight: bold;
        }
        label {
            text-align: left;
            margin: 15px 0 5px;
            font-size: 14px;
            font-weight: 500;
            color: #333;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            background-color: #f9f9f9;
        }
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            background-color: #f9f9f9;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        b {
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="edit-profile-container">
        <?php
			
			$studentid=$_GET['ed'];
			$bookid=$_GET['ed1'];
			$q= "SELECT student.studentid,FullName,studentpic,issueinfo.bookid,books.bookname,ISBN,price,bookpic,issuedate,returndate,approve,authors.authorname,category.categoryname From issueinfo inner join student on issueinfo.studentid=student.studentid inner join books on issueinfo.bookid=books.bookid join authors on authors.authorid=books.authorid join category on category.categoryid=books.categoryid where student.studentid=$studentid and approve='' and issueinfo.bookid=$bookid";
			$res=mysqli_query($db,$q) or die(mysqli_error());		
			$row=mysqli_fetch_assoc($res);		
				$studentid=$row['studentid'];
				$studentpic=$row['studentpic'];
				$FullName=$row['FullName'];
				$bookid=$row['bookid'];
				$bookpic=$row['bookpic'];
				$bookname=$row['bookname'];
				$authorname=$row['authorname'];
				$categoryname=$row['categoryname'];
				$ISBN=$row['ISBN'];
				$price=$row['price'];
	    ?>
        <div class="form form-book">
            <div class="form-container edit-form-container issue-book-container edit-book-container">
                <div class="form-btn">
                    <span onclick="login()" style="width: 100%;">Issue Book</span>
                </div>
                <form action="" id="loginform" method="post" enctype="multipart/form-data">
                    <div class="label">
                        <?php echo "<img width='50px' height='50px' src='../images/".$studentpic."'>"?>
                    </div>
                    <div class="label">
                        <label for="studentid">Student ID : </label>
                        <b style="font-size: 13px;">
                        <?php
			                echo $studentid;
			            ?>
                    </b><br>
                    </div> 
                    <div class="label">
                        <label for="studentid">Full Name : </label>
                        <b style="font-size: 13px;">
                        <?php
			                echo $FullName;
			            ?>
                    </b><br>
                    </div> 
                    <div class="label" style="margin-top: 10px;">
                        <?php echo "<img width='50px' height='50px' src='../images/".$bookpic."'>"?>
                    </div>
                    <div class="label">
                        <label for="studentid">Book ID : </label>
                        <b style="font-size: 13px;">
                        <?php
			                echo $bookid;
			            ?>
                    </b><br>
                    </div> 
                    <div class="label">
                        <label for="studentid">Book Name : </label>
                        <b style="font-size: 13px;">
                        <?php
			                echo $bookname;
			            ?>
                    </b><br>
                    </div>
                    <div class="label">
                        <label for="studentid">Author Name : </label>
                        <b style="font-size: 13px;">
                        <?php
			                echo $authorname;
			            ?>
                    </b><br>
                    </div>
                    <div class="label">
                        <label for="studentid">Category Name : </label>
                        <b style="font-size: 13px;">
                        <?php
			                echo $categoryname;
			            ?>
                    </b><br>
                    </div>
                    <div class="label">
                        <label for="studentid">ISBN : </label>
                        <b style="font-size: 13px;">
                        <?php
			                echo $ISBN;
			            ?>
                    </b><br>
                    </div>
                    <div class="label">
                        <label for="studentid">Price : </label>
                        <b style="font-size: 13px;">
                        <?php
			                echo $price;
			            ?>
                    </b><br>
                    </div>
                    <select id="approve" name="approve">
                        <option value="">Approve</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                    <div class="label">
                        <label for="status">Issue Date : </label>
                    </div>
                    <input type="date"  name="issuedate">
                    <div class="label">
                        <label for="status">Return Date : </label>
                    </div>
                    <input type="date"  name="returndate">
                    <button type="submit" class="btn" name="submit" style="margin-top: 20px;">Issue</button> 
                </form>
            </div>
        </div>
    </div>
    <?php
        if(isset($_POST['submit']))
        {
            $dbInsertDate = date('Y-m-d H:i:s', strtotime($_POST['returndatetime']));
            mysqli_query($db,"INSERT into timer VALUES('$studentid','$bookid','$dbInsertDate');");
            $approve=$_POST['approve'];
            $issuedate=$_POST['issuedate'];
            $returndate=$_POST['returndate'];
            $q1="UPDATE issueinfo SET issuedate='$issuedate',returndate='$returndate',approve='$approve' where approve='' and bookid=$bookid and studentid=".$studentid.";";
            if(mysqli_query($db,$q1))
            {
                ?>
                <script type="text/javascript">
                    alert("Book issued successfully.");
                    window.location="request_info.php";
                </script>
                <?php
            }
        }
	?>
</body>
</html>