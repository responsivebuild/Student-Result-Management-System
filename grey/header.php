<?php require 'includes/authenticateLogin.php'; 
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Grey High Schools — Learn boldly. Lead confidently.">
    <title>Grey High Schools | Learn Boldly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>


    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?
    family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&
    family=Google+Sans+Code:ital,wght@0,300..800;1,300..800&
    family=Google+Sans+Flex:opsz,wght@6..144,1..1000&
    family=Google+Sans:ital,opsz,wght@0,17..18,400..700;1,17..18,400..700&
    family=Londrina+Shadow&family=Unkempt:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="style.css">
    <script src="js/triggerError.js" defer></script>
    <script src="js/showPasswordToggle.js" defer></script>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.html">
            <object data="font-image/grey.svg" type="" width="80"></object>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="nav-link" href="#about">Discover Grey</a></li>
                <li class="nav-item"><a class="nav-link" href="#learning">Learning</a></li>
                <li class="nav-item"><a class="nav-link" href="#community">Community</a></li>
                <?php
                if (!isset($_SESSION['user_id'])) :
                    ?>
                    <li class="nav-item ms-lg-3"><a class="btn btn-gold-big rounded-pill px-4 mt-2 mt-lg-0" href="login.php">Login</a></li>
                    <li class="nav-item ms-lg-3"><a class="btn btn-gold rounded-pill px-4 mt-2 mt-lg-0" href="signup.php">Sign up</a></li>
                <?php
                else :
                    ?>
                    <li class="nav-item"><a class="nav-link" href="<?php if ($_SESSION['user_type'] == 'Teacher') : echo 'controller/teacher.php'; elseif ($_SESSION['user_type'] == 'Student') : echo 'controller/student.php'; elseif ($_SESSION['user_type'] == 'Admin') : echo 'controller/admin.php'; else : echo 'includes/logout.php'; endif; ?>"><span style="color: #f4b640;" class="fw-bolder">Go To Dashboard</span></a></li>
                    <li class="nav-item ms-lg-3"><a class="btn btn-gold rounded-pill px-4 mt-2 mt-lg-0" href="includes/logout.php">Logout</a></li>
                <?php
                endif;
                ?>
            </ul>
        </div>
    </div>
</nav>