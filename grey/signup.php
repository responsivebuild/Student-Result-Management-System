<?php require 'includes/register.php';  ?>

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
        <div class="container-fluid bg-black rounded-4 px-5 pb-5 pt-4">

            <!-- LOGO -->
            <div class="mb-1 px-2">
                <a href="index.php"><img src="img/grey.svg" type="image/svg+xml" width="100" height="" class="mb-4"></a>
            </div>

            <!-- FORM -> CAROUSEL -> SLIDES -->
            <form action="" method="post" novalidate>
                <div class="carousel slide" id="myCarousel">
                    <div class="carousel-inner">
                        <!-- slide A => firstname, lastname -->
                        <div class="carousel-item active" data-step="1">
                            <div class="row">
                                <!-- caption -->
                                <div class="col-12 col-md-6 px-4">
                                    <h1 class="mb-4">Create a Grey Account</h1>
                                    Enter your name
                                </div>


                                <!-- form -->
                                <div class="col-12 col-md-6 px-4">
                                    <!-- Firstname -->
                                    <div class="mb-4">
                                        <fieldset class="myFieldset" id="FirstNameGroup">
                                            <input type="name" class="text-white form-control form-control-lg" id="Firstname" name="Firstname" placeholder="" required minlength="2" maxlength="100" autocomplete="name">
                                            <legend for="Firstname">First name</legend>
                                        </fieldset>
                                        <div class="error-text" id="firstNameError" role="alert">
                                            <span class="error-icon">!</span>
                                            <span id="firstNameErrorMessage">Enter first name</span>
                                        </div>
                                    </div>


                                    <!-- Lastname -->
                                    <div class="mb-4">
                                        <fieldset class="myFieldset" id="LastNameGroup">
                                            <input type="name" class="text-white form-control form-control-lg" id="Lastname" name="Lastname" placeholder="" required minlength="2" maxlength="100" autocomplete="Lastname">
                                            <legend for="Lastname">Last name</legend>
                                        </fieldset>
                                        <div class="error-text" id="lastNameError" role="alert">
                                            <span class="error-icon">!</span>
                                            <span id="lastNameErrorMessage">Enter last name</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- slide B => month, day, year, gender -->
                        <div class="carousel-item" data-step="2">
                            <div class="row">

                                <!-- caption -->
                                <div class="col-12 col-md-6">
                                    <h1 class="mb-4">Basic information</h1>
                                    Enter your birthday and gender
                                </div>

                                <!-- form -->
                                <div class="col-12 col-md-6">
                                    <!-- month, day, year -->
                                    <div class="row g-3 mb-3">
                                        <!-- Month -->
                                        <div class="col-5">
                                            <fieldset class="fff" id="monthGroup">
                                                <select class="text-white form-select form-select-lg" name="month" id="month" required>
                                                    <option selected disabled hidden></option>
                                                    <option value="January">January</option>
                                                    <option value="February">February</option>
                                                    <option value="March">March</option>
                                                    <option value="April">April</option>
                                                    <option value="May">May</option>
                                                    <option value="June">June</option>
                                                    <option value="July">July</option>
                                                    <option value="August">August</option>
                                                    <option value="September">September</option>
                                                    <option value="October">October</option>
                                                    <option value="November">November</option>
                                                    <option value="December">December</option>
                                                </select>
                                                <legend for="month">Month</legend>
                                            </fieldset>
                                        </div>

                                        <!-- Day -->
                                        <div class="col-3">
                                            <fieldset class="fff" id="dayGroup">
                                                <input type="text" class="text-white form-control form-control-lg" id="day" name="day" placeholder="" required minlength="1" maxlength="2" autocomplete="bday-day" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                <legend for="day">Day</legend>
                                            </fieldset>
                                        </div>

                                        <!-- Year -->
                                        <div class="col-4">
                                            <fieldset class="fff" id="yearGroup">
                                                <input type="text" class="text-white form-control form-control-lg" id="year" name="year" placeholder="" required minlength="4" maxlength="4" autocomplete="bday-year" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                <legend for="year">Year</legend>
                                            </fieldset>
                                        </div>
                                    </div>

                                    <!-- gender -->
                                    <div class="row mb-5">
                                        <div class="col-12">
                                            <div>
                                                <fieldset class="fff" id="genderGroup">
                                                    <select class="text-white form-select form-select-lg" name="gender" id="gender">
                                                        <option selected disabled hidden></option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                    <legend for="gender">Gender</legend>
                                                </fieldset>
                                                <div class="error-text">
                                                    <span class="error-icon">!</span> Please select your gender
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- slide C => email -->
                        <div class="carousel-item" data-step="3">
                            <div class="row">

                                <!-- caption -->
                                <div class="col-12 col-md-6">
                                    <h1 class="mb-4">Set up an email address</h1>
                                    Enter your prefered email address to set up your profile
                                </div>

                                <!-- form -->
                                <div class="col-12 col-md-6">

                                    <!-- Email -->
                                    <div>
                                        <fieldset class="myFieldset" id="emailGroup">
                                            <input type="email" class="text-white form-control form-control-lg" id="email" name="email" placeholder="" required pattern="[^@]+@[^@]+\.[a-zA-Z]{2,}" autocomplete="email">
                                            <legend for="email">Email</legend>
                                        </fieldset>
                                        <div class="error-text" id="emailError" role="alert">
                                            <span class="error-icon">!</span>
                                            <span id="emailErrorMessage">Enter your preferred email address</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- slide D => phone -->
                        <div class="carousel-item" data-step="4">
                            <div class="row g-5">

                                <!-- caption -->
                                <div class="col-12 col-md-6">
                                    <h1 class="mb-4">Contact informaton</h1>
                                    Enter your mobile number
                                </div>

                                <!-- form -->
                                <div class="col-12 col-md-6">

                                    <!-- Phone -->
                                    <div>
                                        <fieldset class="myFieldset" id="phoneGroup">
                                            <input type="text" class="text-white form-control form-control-lg" id="phone" name="phone" placeholder="" required maxlength="11" autocomplete="tel" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                            <legend for="phone">Phone</legend>
                                        </fieldset>
                                        <div class="error-text">
                                            <span class="error-icon">!</span> Enter your phone number
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- slide E => Password, confirmPassword -->
                        <div class="carousel-item" data-step="5">
                            <div class="row g-5">

                                <!-- caption -->
                                <div class="col-12 col-md-6">
                                    <h1 class="mb-4">Create a strong password</h1>
                                    Create a strong password with a mix of letters, numbers and symbols
                                </div>

                                <!-- form -->
                                <div class="col-12 col-md-6">

                                    <!-- Password -->
                                    <div class="mb-4">
                                        <fieldset class="myFieldset" id="passwordGroup">
                                            <input type="password" class="text-white form-control form-control-lg" id="password" name="password" placeholder="" minlength="8" maxlength="50" required>
                                            <legend for="password">Password</legend>
                                        </fieldset>
                                        <div class="error-text">
                                            <span class="error-icon">!</span> Enter a password
                                        </div>
                                    </div>

                                    <!-- Confirm password -->
                                    <div class="mb-4">
                                        <fieldset class="myFieldset" id="confirmPasswordGroup">
                                            <input type="password" class="text-white form-control form-control-lg" id="confirmPassword" name="confirmPassword" placeholder="" minlength="8" maxlength="50" required>
                                            <legend for="confirmPassword">Confirm Password</legend>
                                        </fieldset>
                                        <div class="error-text">
                                            <span class="error-icon">!</span> Confirm your password
                                        </div>
                                    </div>

                                    <!-- Checkbox Component -->
                                    <fieldset class="form-check ms-1">
                                        <input class="form-check-input bg-transparent" type="checkbox" id="showPasswordToggle">
                                        <label class="form-check-label" for="showPasswordToggle">Show password</label>
                                    </fieldset>
                                </div>
                            </div>
                        </div>

                        <!-- slide F => assign_role -->
                        <div class="carousel-item" data-step="6">
                            <div class="row">

                                <!-- caption -->
                                <div class="col-12 col-md-6">
                                    <h1 class="mb-4">Role is identity</h1>
                                    Let's keep things organized now
                                </div>

                                <!-- form: student/teacher -->
                                <div class="col-12 col-md-6">
                                    <div>
                                        <fieldset class="fff" id="user_typeGroup">
                                            <select class="text-white form-select form-select-lg" name="user_type" id="user_type" required>
                                                <option selected disabled hidden></option>
                                                <option value="Admin">Admin</option>
                                                <option value="Teacher">Teacher</option>
                                                <option value="Student">Student</option>
                                            </select>
                                            <legend for="user_type">Category</legend>
                                        </fieldset>
                                        <div class="error-text">
                                            <span class="error-icon">!</span> Please select a role
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- error block -->
                <div class="row mt-3 d-flex" id="errGroup">
                    <div class="align-items-center px-4" id="err">
                        <?php
                        if (!empty($displayErrorToUser)) {
                            foreach ($displayErrorToUser as $serverError) {
                                echo "
                                <div class='error-text' style='display: flex'>
                                    <span class='error-icon'>!</span>" . $serverError .
                                    " </div>
                                ";
                            }
                        }
                        ?>
                    </div>
                </div>


                <!-- next -->
                <div class="row mt-5">
                    <div class="col-12 col-md-6"></div>
                    <div class="col-12 col-md-6">
                        <div class="d-flex align-items-center justify-content-between ms-2 me-2">
                            <p class="m-0 ps-2 fw-bold" style="color: #a8c7fa; font-size: 1rem;">Already have an acount? <a href="login.php" style="text-decoration: none;">Login</a></p>
                            <div>
                                <button type="button" class="btn" name="submit" value="1" style="background-color: #a8c7fa; color: #041e49; font-weight: 500; border-radius: 100px; padding: 8px 24px; font-size: 14px; cursor:pointer" id="nextButton">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

<script src="js/showPasswordToggle.js"></script>