<?php
include "connection.php";
include "index_navbar.php";

// Fetch categories
$res = mysqli_query($db, "SELECT * FROM category");
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Library Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body> 
    <div class="all-books">
        <div class="search-bar">
            <form action="" method="POST">
                <select name="category" class="select-category">
                    <option value="selectcat">Select Category</option>
                    <?php 
                    while ($row = mysqli_fetch_array($res)) {
                        echo "<option value='{$row['categoryid']}'>{$row['categoryname']}</option>";
                    }
                    ?>
                </select>
                <input type="search" name="search" placeholder="Search by Book Name">
                <button type="submit" name="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>

        <div class="small-container">
            <?php
            if (isset($_POST['submit'])) {
                $category = $_POST['category'];
                $search = mysqli_real_escape_string($db, $_POST['search']);

                // Define base query
                $query = "SELECT books.bookid, books.bookpic, books.bookname, category.categoryname, authors.authorname, books.ISBN, books.price, quantity, status
                          FROM books
                          JOIN category ON category.categoryid = books.categoryid
                          JOIN authors ON authors.authorid = books.authorid";

                // Build condition based on inputs
                $conditions = [];
                if ($category != "selectcat") {
                    $conditions[] = "books.categoryid = '$category'";
                }
                if (!empty($search)) {
                    $conditions[] = "books.bookname LIKE '%$search%'";
                }

                // Append conditions to query if any exist
                if (!empty($conditions)) {
                    $query .= " WHERE " . implode(" AND ", $conditions);
                }

                $result = mysqli_query($db, $query);

                // Display books
                if (mysqli_num_rows($result) > 0) {  
                    echo "<center><h1><b>Available Books</b></h1></center><br>";                  
                    echo "<div class='row'>";                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="card">
                            <img src="images/<?php echo $row['bookpic']; ?>" alt="Book Image">
                            <div class="card-body">
                                <h4><?php echo $row['bookname']; ?></h4>
                                <p>Price: <?php echo $row['price']; ?> MMK</p>
                                <div class="sub-card">
                                    <p><b>Category:</b> <?php echo $row['categoryname']; ?></p>
                                    <p><b>Author:</b> <?php echo $row['authorname']; ?></p>
                                    <p><b>ISBN:</b> <?php echo $row['ISBN']; ?></p>
                                    <p><b>Quantity:</b> <?php echo $row['quantity']; ?></p>
                                    <p><b>Status:</b> <?php echo $row['status']; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    echo "</div>";
                } else {
                    echo "<p>Sorry! No books found. Try searching again.</p>";
                }
            } else {
                // Default view: Display all books
                echo "<h2 class='all-books-title'>All Books</h2>";
                $res = mysqli_query($db, "SELECT books.bookid, books.bookpic, books.bookname, category.categoryname, authors.authorname, books.ISBN, books.price, quantity, status
                                          FROM books
                                          JOIN category ON category.categoryid = books.categoryid
                                          JOIN authors ON authors.authorid = books.authorid;");
                echo "<div class='row'>";
                while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                    <div class="card">
                        <img src="images/<?php echo $row['bookpic']; ?>" alt="Book Image">
                        <div class="card-body">
                            <h4><?php echo $row['bookname']; ?></h4>
                            <p>Price: <?php echo $row['price']; ?> MMK</p>
                            <div class="sub-card">
                                <p><b>Category:</b> <?php echo $row['categoryname']; ?></p>
                                <p><b>Author:</b> <?php echo $row['authorname']; ?></p>
                                <p><b>ISBN:</b> <?php echo $row['ISBN']; ?></p>
                                <p><b>Quantity:</b> <?php echo $row['quantity']; ?></p>
                                <p><b>Status:</b> <?php echo $row['status']; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                echo "</div>";
            }
            ?>
        </div>
    </div>

    <?php include "footer.php"; ?>
</body>
</html>
