<!DOCTYPE html>
<html>

<head>
    <title>
        <?php
        if ($_SESSION['user_type'] == 'Admin') {
            echo 'Admin Dashboard';
        }
        if ($_SESSION['user_type'] == 'Teacher') {
            echo 'Teacher Dashboard';
        }
        if ($_SESSION['user_type'] == 'Student') {
            echo 'Student Dashboard';
        }
        ?>
    </title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- bootstrap 5 cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&family=Google+Sans+Code:ital,wght@0,300..800;1,300..800&family=Google+Sans+Flex:opsz,wght@6..144,1..1000&family=Google+Sans:ital,opsz,wght@0,17..18,400..700;1,17..18,400..700&family=Londrina+Shadow&family=Unkempt:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.html">
                <object data="../font-image/grey.svg" type="" width="80"></object>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                    <li class="nav-item">
                        <?php
                        if ($_SESSION['user_type'] == 'Admin') {
                            echo '<button type="button" name="btn-admin" class="nav-link bg-transparent border-0">Blog+</button>';
                        }
                        if ($_SESSION['user_type'] == 'Teacher') {
                            echo '<button type="button" name="btn-teacher" class="nav-link bg-transparent border-0">Find Students\' Result</button>';
                        }
                        if ($_SESSION['user_type'] == 'Student') {
                            echo '<button type="button" name="btn-student" class="nav-link bg-transparent border-0">Learning</button>';
                        }
                        ?>
                    </li>
                    <li class="nav-item">
                        <?php
                        if ($_SESSION['user_type'] == 'Admin') {
                            echo '<button type="button" name="btn-admin" class="nav-link bg-transparent border-0">Profile</button>';
                        }
                        if ($_SESSION['user_type'] == 'Teacher') {
                            echo '<button type="button" name="btn-teacher" class="nav-link bg-transparent border-0">Meet Teachers</button>';
                        }
                        if ($_SESSION['user_type'] == 'Student') {
                            echo '<button type="button" name="btn-student" class="nav-link bg-transparent border-0">Find Community</button>';
                        }
                        ?>
                    </li>
                    <li class="nav-item ms-lg-1"><a class="btn btn-gold rounded-pill px-4 mt-2 mt-lg-0" href="../includes/logout.php">Sign Out</a></li>
                </ul>
            </div>
        </div>
    </nav>