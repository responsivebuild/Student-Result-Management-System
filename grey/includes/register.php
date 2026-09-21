<?php
// 1. connect database
include 'config.php';


// 2. Set the timezone to West Africa Time (WAT / Africa/Lagos)
date_default_timezone_set('Africa/Lagos');


// 3. log monitoring
$logFile = __DIR__ . '/logs/app.log';


// 4a. log error if database connection ✕
if (!$connection) :
    $event = "Gateway connection error: unable to reach the database during signup ❌";
    $timestamp = date('l jS, F Y h:i:s A');
    $status = "[$timestamp] —— [$event]" . PHP_EOL;
    file_put_contents($logFile, $status, FILE_APPEND | LOCK_EX) !== false;

// 4b. log error if database connection ✓
else :
    $event = "Opening gateway connection to database for signup... ✓✅";
    $timestamp = date('l jS, F Y h:i:s A');
    $status = "[$timestamp] —— [$event]" . PHP_EOL;
    file_put_contents($logFile, $status, FILE_APPEND | LOCK_EX) !== false;

endif;


$Firstname = $Lastname = $month = $day = $year = $gender = $email = $phone = $password = $confirmPassword = $user_type = $hash_password = "";
$displayErrorToUser = [];




// 4. reg_id generator
function generateRegNo(PDO $connection): string {
    do {

        $regNo = 'GRE-';

        // Generate 9 random numbers
        foreach (range(1, 9) as $number) {
            $regNo .= random_int(0, 9);
        }

        // Generate 2 random letters
        $letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        foreach (range(1, 2) as $letter) {
            $regNo .= $letters[random_int(0, strlen($letters) - 1)];
        }

        // Check if registration number already exists
        $stmt = $connection->prepare(
            "SELECT id FROM users WHERE reg_id = ?"
        );

        $stmt->execute([$regNo]);

    } while ($stmt->fetch());

    return $regNo;
}



if(isset($_POST['submit'])) {

    // 5. cross-site scripting validation
    function test_input(mixed $data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // 5a. validate firstname
    $Firstname = test_input($_POST['Firstname']);

    // 5b. validate lastname
    $Lastname = test_input($_POST['Lastname']);

    // 5c. validate month
    $month = test_input($_POST['month']);
    
    // 5d. validate day
    if (!is_numeric($_POST['day'])) {

        $displayErrorToUser[] = 'Day—no letter accepted!';

    } else {

        if ($_POST['day'] < 1 || $_POST['day'] > 31) {
            $displayErrorToUser[] = "Day—Enter between 1 and 31";

        } else {
            $day = test_input($_POST['day']);
        }
    }

    // 5e. validate year
    if(!is_numeric($_POST['year'])) {

        $displayErrorToUser[] = 'Year—no letter accepted!';

    } else {

        // if numbers, test only at least 18yrs
        $maxYear = date('Y') - 18;

        if($_POST['year'] >= $maxYear) {

            $displayErrorToUser[] = 'Year—Must be at least 18 years';

        } else {

            $year = test_input($_POST['year']);
        }
    }


    // 5f. structure $birthday to readable string
    $birthday = "$month $day, $year";


    // 5g. validate gender
    $gender = test_input($_POST['gender']);
    

    /****************************** 5h. validate email ********************************/

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {

        $displayErrorToUser[] = "Invalid email format";

    } else {

        $email = test_input($_POST["email"]);
    }


    // 5i. validate phone
    $phone = test_input($_POST['phone']);


    // 5j. validate user_type
    $user_type = test_input($_POST['user_type']);



    /*************** 5k. Check if $password == $confirmPassword ***************/
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($confirmPassword !== $password) {

        $displayErrorToUser[] = "Password—not matched!";

    } else {

        $hash_password = password_hash($password, PASSWORD_DEFAULT);
    }



    // 6. check duplicate user emails OR user email && password already exist
    $sql = "SELECT * FROM `users` 
            WHERE `email` = '$email' OR (`email` = '$email' AND `hash_password` = '$hash_password')";
    $result = $connection->query($sql);

    
    // 6a. if duplicate exist
    if($result->fetch() > 0) {

        $displayErrorToUser[] = "That email is taken. Try another!";

    } else {
        // 6b. if NOT duplicate
        try {
        
            // 7. generate random Reg.No for each user
            $regNo = generateRegNo($connection);
            


            // 8a. prepare sql to insert user data into table
            $sql = "INSERT INTO 
            `users`(`firstname`, `lastname`, `birthday`, `gender`, `email`, `phone`, `hash_password`, `user_type`, `reg_id`) 
            VALUES ('$Firstname', '$Lastname', '$birthday', '$gender', '$email', '$phone', '$hash_password', '$user_type', '$regNo')";


            // 8b. insert data
            $insert = $connection->query($sql);


            // 9. prepare logs
            $eventLog = "New user ($Firstname $Lastname, $email, $user_type, REG. No: $regNo) sign up successful 🎉";
            $timestamp = date('l jS, F Y h:i:s A');
            $logStatus = "[$timestamp] [$eventLog]" . PHP_EOL;
            file_put_contents($logFile, $logStatus, FILE_APPEND | LOCK_EX) !== false;

            // 10. redirect user to login.php
            $connection = null;
            header("location: login.php?msg=New user register successful");
            exit();


        } catch(PDOException $e) {

            // prepare logs if sign up fail
            $eventLog = "New user ($Firstname $Lastname, $email, $user_type) sign up failed ❌ \nReason: " . $e->getMessage();
            $timestamp = date('l jS, F Y h:i:s A');
            $logStatus = "[$timestamp] [$eventLog]" . PHP_EOL;
            file_put_contents($logFile, $logStatus, FILE_APPEND | LOCK_EX) !== false;

            // redirect to ../signup.php if error
            $connection = null;
            header("location: ../signup.php");
            die();
        }
        
    }
}