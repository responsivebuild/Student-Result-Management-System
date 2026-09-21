<?php include '../includes/authenticateLogin.php';

$redirect = "../login.php";

// Make sure only teachers can access this dashboard
if ($_SESSION['user_type'] !== 'Teacher') {
    header("Location: " . $redirect);
    exit();
}

// get the teacher ID
$teacherId = $_SESSION['user_id'];

// convert terms to ordinals - 1st, 2nd, 3rd
function convertTermToOrdinal(mixed $term): mixed {
    $map = [
        '1st'  => '1<sup>st</sup>',
        '2nd' => '2<sup>nd</sup>',
        '3rd'  => '3<sup>rd</sup>',
        'Term'   => strtolower('Term')
    ];
    $key = strtolower(trim(str_replace('Term', '', $term)));
    return $map[$key] ?? $term;
}
include 'header.php';
?>


<main class="home">
    <section class="hero">
        <div class="container py-lg-5">
            <h1 class="fw-bold">Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
            <ul class="list-unstyled lh-lg h5">
                <li><strong style="color: #f4b640">Age: </strong><?php echo date('Y') - (int) substr(htmlspecialchars($_SESSION['user_dob']) ?? '', -4) . ' years'; ?></li>
                <li><strong style="color: #f4b640">Gender: </strong><?php echo htmlspecialchars($_SESSION['user_gender']); ?></li>
                <li><strong style="color: #f4b640">Email: </strong><?php echo htmlspecialchars($_SESSION['user_email']); ?></li>
                <li><strong style="color: #f4b640">Phone: </strong><?php echo htmlspecialchars($_SESSION['phone']); ?></li>
                <li><strong style="color: #f4b640">Status: </strong><?php echo htmlspecialchars($_SESSION['user_type']); ?></li>
                <li><strong style="color: #f4b640">Reg No.: </strong><?php echo htmlspecialchars($_SESSION['reg_id']); ?></li>
            </ul>
        </div>
    </section>

    <?php
    /* TEACHER RESULT MANAGEMENT
     *
     * 1. connect to database
     * 2. Fetch —— get all students from users table, join student_results table subjects scores
     * 3. Table —— display [students => results]
     * 4. Checkbox —— each student ID stored in its value=""
     * 5. Edit button —— communicate with checkbox (get ID of the selected student)
     * 6. If edit button click —— Use the selected ID to fetch JOIN student's name, scores, term and year
     * 7. Modal Form —— prepare the edit/update form (with bootstrap modal)
     * 8. place the retrieved student record into modal form
     * —— if student have no result yet, the fields can remain empty
     * —— if result exist, put into the modal inputs
     * 9. Trigger the modal form to display
     * 10. Update button —— save changes
     * 11. Return to teacher dashboard
     * 12. Search filter to search the JOIN tables */
    $english = "";
    $maths = "";
    $biology = "";
    $chemistry = "";
    $physics = "";
    $term = "";
    $year = "";
    /* Controller determine when to activate modal —— update form   */
    $show_edit_form = false;
    /*  
     * Objective:
     * 1. user clicks row checkbox, it stores student_id,
     * 2. if user clicks edit button, pops new FORM where user either INSERT/UPDATE student_results table
     * 3. saves changes
     * 4. INSERT/UPDATE form clears, table returns back with the INSERT/UPDATE new scores


     * EDIT PROCESS */
    if (isset($_POST['editBtn']) && $_POST['editBtn'] == 'editBtn') :
        
        // if checkbox clicked
        if (isset($_POST['selected_student'])) :

            // a. get student ID that came from selected checkbox, store in $studentId
            $studentId = $_POST['selected_student'];

            $sql = "SELECT users.firstname, users.lastname, student_results.english, student_results.maths, student_results.biology, student_results.chemistry, student_results.physics, student_results.total, student_results.average, student_results.grade, student_results.term, student_results.year 
            FROM users
            LEFT JOIN student_results
            ON users.id = student_results.student_id
            WHERE users.id = ? ";
            $stmt = $connection->prepare($sql);
            $stmt->execute([$studentId]);
            // b. fetches data → tell Bootstrap to open the modal
            $result = $stmt->fetch();
            // c. get the 5 scores from fetched array (example: result['english'])
            if ($result) :
                $student_name = $result['firstname'] . ' ' . $result['lastname'];
                $english = $result['english'];
                $maths = $result['maths'];
                $biology = $result['biology'];
                $chemistry = $result['chemistry'];
                $physics = $result['physics'];
                $term = $result['term'];
                $year = $result['year'];
                // telling bootstrap to open the modal form
                $show_edit_form = true;
            endif;
        endif;
    endif;
    /*
     *
     * UPDATE PROCESS */
    if (isset($_POST['update-submit'])) :

        $studentId = $_POST['student_id'];
        /*
         *
         * ———— prepare INSERT/UPDATE statements ———— */
        do {
            try {
                // find the student and check whether a result already exists
                $sql = "SELECT users.id,
                            student_results.id as result_id,
                            student_results.term,
                            student_results.year
                        from users
                        left join student_results
                        on users.id = student_results.student_id
                        where users.id = ?
                        and users.user_type = 'Student'";

                $stmt = $connection->prepare($sql);
                $stmt->execute([$studentId]);
                $result = $stmt->fetch();

            
                // check if a result already exists
                if (empty($result['result_id'])) {

                    // no result exists —— INSERT new result
                    // a. get the values from the modal
                    $term = $_POST['term'];
                    $year = $_POST['year'];

                    $english = $_POST['english'];
                    $maths = $_POST['maths'];
                    $biology = $_POST['biology'];
                    $chemistry = $_POST['chemistry'];
                    $physics = $_POST['physics'];


                    // b. insert the new result
                    $sql = "INSERT into student_results (student_id, term, year, english, maths, biology, chemistry,   
                            physics, teacher_id)
                            values (?, ?, ?, ?, ?, ?, ?, ?, ?)";

                    $stmt = $connection->prepare($sql);
                    $stmt->execute([
                        $studentId,
                        $term,
                        $year,
                        $english,
                        $maths,
                        $biology,
                        $chemistry,
                        $physics,
                        $teacherId
                    ]);
                    echo "success";

                } else {
                    // result already exists —— UPDATE
                    // a. get the updated scores
                    $english = $_POST['english'];
                    $maths = $_POST['maths'];
                    $biology = $_POST['biology'];
                    $chemistry = $_POST['chemistry'];
                    $physics = $_POST['physics'];


                    // b. update the existing result
                    $sql = "UPDATE student_results
                            set english = ?,
                                maths = ?,
                                biology = ?,
                                chemistry = ?,
                                physics = ?,
                                teacher_id = ?
                            where student_id = ?";

                    $stmt = $connection->prepare($sql);
                    $stmt->execute([
                        $english,
                        $maths,
                        $biology,
                        $chemistry,
                        $physics,
                        $teacherId,
                        $studentId
                    ]);
                }
            } catch (PDOException $e) {
                $status = $e->getMessage() . PHP_EOL;
                file_put_contents("../includes/logs/app.log", $status, FILE_APPEND | LOCK_EX) !== false;
            }
        } while (false);


    endif;
    ?>
    <section class="result-section">
        <div class="container table-responsive vh-100">
            <?php
            /*
             *
             * Default Student Results Table (default view)
             *
             */
            ?>
            <table class="table table-borderless table-dark table-hover" style="--bs-table-bg: transparent; --bs-table-color: inherit;">
                <thead class="fw-bold fs-5 text-center" style="color: #f4b640;">
                    <tr>
                        <th style="width: 3%; font-size: medium"><input type="checkbox" class="form-check-input"></th>
                        <th class="text-start" style="width: 25%;">Name</th>
                        <th style="width: 4%">English</th>
                        <th style="width: 4%">Maths</th>
                        <th style="width: 4%">Biology</th>
                        <th style="width: 4%">Chem</th>
                        <th style="width: 4%">Physics</th>
                        <th style="width: 4%">Total</th>
                        <th style="width: 4%">Average</th>
                        <th style="width: 4%">Grade</th>
                        <th style="width: 4%">Term</th>
                        <th style="width: 4%">Year</th>
                        <th style="width: 27%;">Reg_No</th>
                    </tr>
                </thead>
                <?php
                /*
                 *
                 * Search button
                 *
                 *
                 */
                ?>
                <div class="row mb-4">
                    <div class="col-md-3">
                        <form method="GET">
                            <div class="input-group">
                                <input type="text" name="search" value="<?php if(isset($_GET['search'])) {echo $_GET['search'];} ?>" class="form-control bg-dark text-light" placeholder="<?php echo 'Search students or teachers...'; ?>">
                                <button type="submit" class="input-group-text btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>
                    <?php
                    /*
                    *
                    * Edit button
                    *
                    *
                    */
                    ?>
                    <div class="col">
                        <form method="POST" id="editForm">
                            <button type="submit" class="btn btn-primary" name="editBtn" value="editBtn">Edit</button>
                        </form>
                    </div>
                </div>
                <?php
                /*
                 *
                 * tbody
                 *
                 *
                 */
                ?>
                <tbody class="text-white text-center">
                    <?php
                    /*
                     *
                     * Objective: Handle search filter query
                     *
                     * Get search input */
                    $input = '%' . trim($_GET['search'] ?? '') . '%';
                    $sql = "SELECT u.id, u.firstname, u.lastname, u.reg_id, r.term, r.year, r.english, r.maths, 
                            r.biology, r.chemistry, r.physics, r.total, r.average, r.grade
                            FROM users AS u
                            LEFT JOIN student_results AS r 
                            ON u.id = r.student_id
                            WHERE u.user_type = 'Student'
                            AND CONCAT_WS('', u.firstname, u.lastname, u.birthday, u.gender, u.email, u.user_type, r.english, r.maths, r.biology, r.chemistry, r.physics) LIKE ?";
                    $stmt = $connection->prepare($sql);
                    $stmt->execute([$input]);
                    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    /*
                     *
                     * 1. select only student rows in users table and joining to student_results table
                     * 2. Activate search filter
                     * 3. query database and fetch
                     * 4. display as table */
                    if (count($row) === 0) :
                        $sql = "SELECT u.id, u.firstname, u.lastname, u.reg_id, r.term, r.year, r.english, 
                                r.maths, r.biology, r.chemistry, r.physics, r.total, r.average, r.grade
                                FROM users AS u
                                LEFT JOIN student_results AS r 
                                ON u.id = r.student_id
                                WHERE u.user_type = 'Student'";
                        $stmt = $connection->query($sql);
                        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    endif;


                    // display fetched student_result from joint tables
                    $number = 1;
                    foreach ($row as $row) :
                        ?>
                        <tr>
                            <td><input type="checkbox" name="selected_student" value="<?php echo $row['id']; ?>" class="form-check-input" form="editForm"></td>
                            <td class="text-start px-2"><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                            <td><?php echo $row['english']; ?></td>
                            <td><?php echo $row['maths']; ?></td>
                            <td><?php echo $row['biology']; ?></td>
                            <td><?php echo $row['chemistry']; ?></td>
                            <td><?php echo $row['physics']; ?></td>
                            <td><?php echo $row['total']; ?></td>
                            <td><?php echo $row['average']; ?></td>
                            <td><?php echo $row['grade']; ?></td>
                            <td><?php echo convertTermToOrdinal($row['term']); ?></td>
                            <td><?php echo $row['year']; ?></td>
                            <td class="px-2"><?php echo $row['reg_id']; ?></td>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    <?php
    /**
     * 
     * 
     *  This is the update form modal
     * 
     *
     */
    ?>
    <div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg shadow-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bolder text-primary"><?php echo $student_name ?? ''; ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="resultForm">
                        <input type="hidden" name="student_id" value="<?php echo $studentId; ?>">
                        <div class="row mb-2 px-sm-1">
                            <div class="col px-2">
                                <label for="english" class="ps-3">English:</label>
                            </div>
                            <div class="col-8">
                                <input type="text" name="english" id="english" class="form-control" placeholder="Enter scores between 0 - 100" value="<?php echo $english; ?>" oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(Number(this.value) > 100) this.value = 100;" required>
                            </div>
                        </div>

                        <div class="row mb-2 px-sm-1">
                            <div class="col px-2">
                                <label for="maths" class="ps-3">Maths:</label>
                            </div>
                            <div class="col-8">
                                <input type="text" name="maths" id="maths" class="form-control" placeholder="Enter scores between 0 - 100" value="<?php echo $maths; ?>" oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(Number(this.value) > 100) this.value = 100;" required>
                            </div>
                        </div>

                        <div class="row mb-2 px-sm-1">
                            <div class="col px-2">
                                <label for="biology" class="ps-3">Biology:</label>
                            </div>
                            <div class="col-8">
                                <input type="text" name="biology" id="biology" class="form-control" placeholder="Enter scores between 0 - 100" value="<?php echo $biology ?>" oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(Number(this.value) > 100) this.value = 100;" required>
                            </div>
                        </div>

                        <div class="row mb-2 px-sm-1">
                            <div class="col px-2">
                                <label for="chemistry" class="ps-3">Chemistry:</label>
                            </div>
                            <div class="col-8">
                                <input type="text" name="chemistry" id="chemistry" class="form-control" placeholder="Enter scores between 0 - 100" value="<?php echo $chemistry; ?>" oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(Number(this.value) > 100) this.value = 100;" required>
                            </div>
                        </div>

                        <div class="row mb-2 px-sm-1">
                            <div class="col px-2">
                                <label for="physics" class="ps-3">Physics:</label>
                            </div>
                            <div class="col-8">
                                <input type="text" name="physics" id="physics" class="form-control" placeholder="Enter scores between 0 - 100" value="<?php echo $physics; ?>" oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(Number(this.value) > 100) this.value = 100;" required>
                            </div>
                        </div>

                        <div class="row mb-2 px-sm-1">
                            <div class="col px-2">
                                <label for="term" class="ps-3">Term:</label>
                            </div>
                            <div class="col-8">
                                <select class="form-select" name="term" id="term" <?php echo !empty($term) ? 'disabled' : ''; ?> required>
                                    <option selected disabled hidden>Choose Term</option>
                                    <option value="<?php echo '1st Term'; ?>">1</option>
                                    <option value="<?php echo '2nd Term'; ?>">2</option>
                                    <option value="<?php echo '3rd Term'; ?>">3</option>
                                </select>
                            </div>
                        </div>

                        <div class="row px-sm-1">
                            <div class="col px-2">
                                <label for="year" class="ps-3">Year:</label>
                            </div>
                            <div class="col-8">
                                <input type="text" name="year" id="year" class="form-control" placeholder="Enter school year" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="<?php echo $year; ?>" <?php echo !empty($year) ? 'disabled' : ''; ?> required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <?php
                    if (empty($term)) {
                        ?>
                        <button type="submit" name="update-submit" form="resultForm" class="btn btn-primary">Create Result</button>
                    <?php
                    } else {
                        ?>
                        <button type="submit" name="update-submit" form="resultForm" class="btn btn-primary">Update</button>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    /**
     * 
     * 
     *  Create Bootstrap trigger to open modal form
     * 
     *
     */
    if ($show_edit_form):
        ?>
        <button type="button" id="openUpdateModal" class="d-none" data-bs-toggle="modal" data-bs-target="#updateModal"></button>
        <script>
            document.getElementById('openUpdateModal').click();
        </script>
        <?php
    endif;
    ?>
</main>


<?php include 'footer.php'; ?>