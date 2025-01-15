<?php
    session_start();
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>British University Library</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <a href="index.php"><img src="images/logo2.png" alt="Logo" style="margin-left:15px;"></a> 
                </div>
                <div class="title">
                    <a href="index.php"><h3>British University Library</h3></a>
                </div>
                <nav>
                    <ul id="menuitems">
                        <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                        <li><a href="index_books.php"><i class="fas fa-book"></i> Books</a></li>
                        <li><a href="admin/admin.php"><i class="fas fa-user-shield"></i> Admin</a></li>
                        <li><a href="student.php"><i class="fas fa-users"></i> Student</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <script>
        // Toggle dropdown menu
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close dropdown if clicked outside
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                const dropdowns = document.getElementsByClassName("dropdown-content");
                for (let i = 0; i < dropdowns.length; i++) {
                    const openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        };

        // Highlight active menu item
        const currentLocation = location.href;
        const menuItems = document.querySelectorAll('#menuitems a');
        for (let i = 0; i < menuItems.length; i++) {
            if (menuItems[i].href === currentLocation) {
                menuItems[i].className = "active";
            }
        }
    </script>
</body>
</html>
