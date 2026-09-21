<?php require 'includes/authenticateLogin.php'; ?>


<!DOCTYPE html>
<html>
<head>
    <title>Grey Login Portal</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&family=Google+Sans+Code:ital,wght,MONO@0,300..800,1;1,300..800,1&family=Google+Sans+Flex:opsz,wght@6..144,1..1000&family=Google+Sans:ital,opsz,wght@0,17..18,400..700;1,17..18,400..700&family=Londrina+Shadow&family=Unkempt:wght@400;700&display=swap" rel="stylesheet">

    <script src="js/triggerError.js" defer></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="d-flex min-vh-100 align-items-center my-md rounded-4 p-4">
    <div class="container-fluid bg-black rounded-4 px-5 pt-5 pb-5">
        <!-- logo -->
        <a href="index.php"><img src="img/grey.svg" type="image/svg+xml" width="100" height="" class="mb-4"></a>
        

        <!-- login form -->
        <form action="" method="POST" novalidate>
            <div class="row">

                <!-- column 1: caption -->
                <div class="col-12 col-md-6">
                    <h1 class="mb-4">Sign in</h1>
                    View Academic report, stay ahead with feeds, connect with bright minds
                </div>




                <!-- column 2: email, password -->
                <div class="col-12 col-md-6">

                    <!-- Email -->
                    <div class="mb-4">
                        <fieldset class="myFieldset" id="">
                            <input type="email" class="text-white form-control form-control-lg" id="email" name="email" placeholder="" required pattern="[^@]+@[^@]+\.[a-zA-Z]{2,}" autocomplete="email">
                            <legend for="email">Email</legend>
                        </fieldset>
                    </div>


                    <!-- Password -->
                    <div class="mb-3">
                        <fieldset class="myFieldset" id="">
                            <input type="password" class="text-white form-control form-control-lg" id="password" name="password" placeholder="" minlength="8" maxlength="50" required>
                            <legend for="password">Password</legend>
                        </fieldset>
                    </div>


                    <!-- showPasswordcheckbox -->
                    <fieldset class="form-check mt-3">
                        <input class="form-check-input bg-transparent" type="checkbox" id="showPasswordToggle">
                        <label class="form-check-label" for="showPasswordToggle">Show password</label>
                    </fieldset>



                    <!-- error block -->
                    <div class="row mb-4 d-flex">
                        <div class="align-items-center px-4">
                            <?php
                            if(!empty($displayErrorToUser)) {
                                foreach($displayErrorToUser as $serverError) {
                                    echo "
                                        <div class='error-text' style='display: flex' role='alert'>
                                            <span class='error-icon'>!</span>" . htmlspecialchars($serverError, ENT_QUOTES, 'UTF-8') .
                                        " </div>
                                        ";
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <!-- login button -->
                    <div class="d-flex align-items-center mb-4  float-end">
                        <span class="fw-bold" style="color: #a8c7fa; font-size: 1rem;">Dont have an account?</span>
                        &nbsp;
                        <a class="text-decoration-none fw-bold" role="button" href="signup.php">Sign up</a>
                        &nbsp;
                        &nbsp;
                        <button type="submit" class="btn rounded-pill fw-medium" style="font-size: .9rem; padding: 8px 24px; cursor:pointer; background-color: #a8c7fa; color: #041e49;" name="submit">Login</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="js/showPasswordToggle.js"></script>
</body>
</html>
