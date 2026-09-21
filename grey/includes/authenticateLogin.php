<?php
// 1. start session
session_start();

// 2. connect database
include 'config.php';


// 3. Set the timezone to West Africa Time (WAT / Africa/Lagos) for logs
date_default_timezone_set('Africa/Lagos');


// 3. set log path
$logFile = __DIR__ . "/logs/activity.log";


// 4a. log error if database connection ✕
if (!$connection) :
    $event = "Gateway connection error: unable to reach the database during sign-in ❌";
    $timestamp = date('l jS, F Y h:i:s A');
    $status = "[$timestamp] —— [$event]" . PHP_EOL;
    file_put_contents($logFile, $status, FILE_APPEND | LOCK_EX) !== false;

// 4b. log error if database connection ✓
else :
    $event = "Opening gateway connection to database. User about to sign-in... ✓✅";
    $timestamp = date('l jS, F Y h:i:s A');
    $status = "[$timestamp] —— [$event]" . PHP_EOL;
    file_put_contents($logFile, $status, FILE_APPEND | LOCK_EX) !== false;

endif;




// dashboards
$redirect_Admin = 'controller/admin.php';
$redirect_Teacher = "controller/teacher.php";
$redirect_Student = 'controller/student.php';




// 5. empty variables to store input email, password
$loginEmail = $loginPass = "";

// 6. empty array to store error
$displayErrorToUser = [];


// 7. if user login
if(isset($_POST['submit'])) {
    
    // 7a. xss funtion
    function test_input(mixed $data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // 7b. validate email
    if(empty($_POST['email'])) {
        $displayErrorToUser[] = "Please enter your email";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $displayErrorToUser[] = "Email must be in this format—email@example.com";
    } else {
        $loginEmail = test_input($_POST['email']);
    }


    // 7c. check password
    if(empty($_POST['password'])) {
        $displayErrorToUser[] = "Please enter your password";
    } else {
        $loginPass = $_POST['password'];
    }

    // fetch all user information using loginEmail
    $select = "SELECT * FROM users WHERE email = ?";
    $result = $connection->prepare($select);
    $result->execute([$loginEmail]);
    $row = $result->fetch(PDO::FETCH_ASSOC);

    
    // 8a. if loginEmail NOT exist in database
    if(!$row) {

        $displayErrorToUser[] = "Invalid email or password. Try again!";

        $logMessage = "Failed login attempt for email: " . $loginEmail;
        $timestamp = date('l jS, F Y h:i:s A');
        $logStatus = "[$timestamp] [$logMessage]" . PHP_EOL;
        file_put_contents($logFile, $logStatus, FILE_APPEND | LOCK_EX) !== false;


      // 8b. if loginEmail exist, but password NOT verified with database password_hash
    } elseif (!password_verify($loginPass, $row['hash_password'])) {

        $displayErrorToUser[] = "Incorrect password. Try again!";

    } else {

        // 8c. if loginEmail exist && password verified, 
        // save user sessions, redirect them to respective dashboards
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['firstname'] . " " . $row['lastname'];
        $_SESSION['user_dob'] = $row['birthday'];
        $_SESSION['user_gender'] = $row['gender'];
        $_SESSION['user_email'] = $row['email'];
        $_SESSION['user_type'] = $row['user_type'];
        $_SESSION['reg_id'] = $row['reg_id'];
        $_SESSION['phone'] = $row['phone'];
        

        // 13. log activity
        $logMessage = "User logged in: " . $_SESSION['user_email'] . " (ID: " . $_SESSION['user_id'] . ", Type: " . $_SESSION['user_type'] . ")";
        $timestamp = date('l jS, F Y h:i:s A');
        $logStatus = "[$timestamp] [$logMessage]" . PHP_EOL;
        file_put_contents($logFile, $logStatus, FILE_APPEND | LOCK_EX) !== false;



        // 10. redirect to respective dashboard based on user type
        if($_SESSION['user_type'] == 'Admin') {
            header('Location: ' . $redirect_Admin);
            exit();

        } elseif($_SESSION['user_type'] == 'Teacher') {
            header('Location: ' . $redirect_Teacher);
            exit();

        } elseif($_SESSION['user_type'] == 'Student') {
            header('Location: ' . $redirect_Student);
            exit();

        } else {
            $connection = null;
            header('Location: logout.php');
            exit();
        }
    }

} 