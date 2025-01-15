<?php
	include "connection.php";
    include "admin_navbar.php";
    $res=mysqli_query($db,"SELECT * FROM category");
	$res1=mysqli_query($db,"SELECT * FROM authors");
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
            font-size: 24px;
            color: #333;
            font-weight: bold;
        }
        .form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form select{
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="edit-profile-container">
        <div class="form">
            <div class="form-container edit-form-container add-book-form">
                <div class="form-btn">
                    <span onclick="login()" style="width: 100%;">Add Book</span>
                </div>
                <form action="" id="loginform" method="post" enctype='multipart/form-data'>
                    <input type="text" placeholder="Book Name" name="bookname" required>
                    <select class="form-control" name="author" required="">
                        <option value="">Select Author</option>
                        <?php while($row1=mysqli_fetch_array($res1)):;?>
                            <option value="<?php echo $row1[0];?>"><?php echo $row1[1];?></option>
                        <?php endwhile;?>
                    </select><br>
                    <select class="form-control" name="category" required="">
                        <option value="">Select Category</option>
                        <?php while($row=mysqli_fetch_array($res)):;?>
                            <option value="<?php echo $row[0];?>"><?php echo $row[1];?></option>
                        <?php endwhile;?>
                    </select><br>
                    <input type="text" placeholder="ISBN" name="ISBN" required>
                    <input type="text" placeholder="Price" name="price" required>
                    <input type="text" placeholder="Quantity" name="quantity" required>
                    <select class="form-control" name="status" required="">
                        <option value="">Select Status</option>
                        <option value="Available">Available</option>
                        <option value="Not Available">Not Available</option>
                        <option value="Upcoming">Upcoming</option>
                    </select><br>
                    <div class="label">
                        <label for="pic">Upload picture of the book : </label>
                    </div>
                    <input type="file" name="file" class="file" required>
                    <button type="submit" class="btn" name="submit">Add</button>
                </form>
            </div>
        </div>
    </div>
    <?php
		if(isset($_POST['submit']))
		{
            move_uploaded_file($_FILES['file']['tmp_name'],"../images/".$_FILES['file']['name']);
            $pic = $_FILES['file']['name'];
			mysqli_query($db,"INSERT INTO books VALUES('','$pic','$_POST[bookname]','$_POST[author]','$_POST[category]','$_POST[ISBN]','$_POST[price]','$_POST[quantity]','$_POST[status]') ;");
			?>
			<script type="text/javascript">				
				alert("Book added successfully.");
                window.location = "manage_books.php";
			</script>
			<?php
		}

	?>
</body>
</html>