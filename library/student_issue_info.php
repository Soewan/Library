<?php
include "connection.php";
include "student_navbar.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure session variables are set
if (!isset($_SESSION['studentid']) || !isset($_SESSION['login_student_username'])) {
    echo "Please log in to view issued books.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="request-table">
        <div class="request-container book-container">
            <h2 class="request-title student-info-title" style="padding-top: 50px;">List of Issued Books</h2>

            <?php
            $studentid = $_SESSION['studentid'];
            $expired_status = '<p style="color:yellow; background-color:red;">EXPIRED</p>';

            // Query to fetch issued books
            $query = "SELECT books.bookid, books.bookname, books.ISBN, books.bookpic, books.price,
                             issueinfo.issuedate, issueinfo.returndate, issueinfo.approve, issueinfo.fine,
                             authors.authorname, category.categoryname
                      FROM issueinfo
                      JOIN books ON issueinfo.bookid = books.bookid
                      JOIN student ON student.studentid = issueinfo.studentid
                      JOIN authors ON authors.authorid = books.authorid
                      JOIN category ON category.categoryid = books.categoryid
                      WHERE student.studentid = '$studentid' 
                      AND (issueinfo.approve = 'yes' OR issueinfo.approve = '$expired_status')
                      ORDER BY issueinfo.returndate ASC";

            $result = mysqli_query($db, $query);

            if (!$result) {
                echo "Error: " . mysqli_error($db);
            } elseif (mysqli_num_rows($result) == 0) {
                echo "There's no issued books.";
            } else {
                // Update fine and status for expired books
                while ($row = mysqli_fetch_assoc($result)) {
                    $d = strtotime($row['returndate']);
                    $c = strtotime(date("Y-m-d"));
                    $diff = $c - $d;

                    if ($diff > 0) {
                        $day = floor($diff / (60 * 60 * 24));
                        $fine = $day * 10;

                        $update_query = "UPDATE issueinfo 
                                         SET approve = '$expired_status', fine = $fine 
                                         WHERE `returndate` = '{$row['returndate']}' 
                                         AND approve = 'yes' 
                                         LIMIT 1";
                        mysqli_query($db, $update_query);
                    }
                }

                // Reset pointer for table display
                mysqli_data_seek($result, 0);

                // Display table of issued books
                echo "<table class='rtable'>";
                echo "<tr style='background-color: #040720;'>
                        <th>Books</th>
                        <th>Author Name</th>
                        <th>Category Name</th>
                        <th>ISBN</th>
                        <th>Issue Date</th>
                        <th>Return Date</th>
                        <th>Approve Status</th>
                        <th>Fine</th>
                      </tr>";

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>
                                <div class='table-info'>
                                    <img src='images/{$row['bookpic']}' alt='Book Image'>
                                    <div>
                                        <p>{$row['bookname']}</p>
                                        <small>Price: {$row['price']} Tk.</small>
                                    </div>
                                </div>
                            </td>
                            <td>{$row['authorname']}</td>
                            <td>{$row['categoryname']}</td>
                            <td>{$row['ISBN']}</td>
                            <td>{$row['issuedate']}</td>
                            <td>{$row['returndate']}</td>
                            <td>{$row['approve']}</td>
                            <td>{$row['fine']}</td>
                          </tr>";
                }
                echo "</table>";
            }
            ?>
        </div>
    </div>
</body>
</html>
