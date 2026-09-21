<?php include '../includes/authenticateLogin.php';
// note:
// session_start() and all $_SESSION[] variables referenced from  authenticateLogin.php


// Make sure only students can access this dashboard
if ($_SESSION['user_type'] !== 'Student') {
    header("Location: ../login.php");
    exit();
}

$studentId = $_SESSION['user_id'];

function convertTermToOrdinal(string $term): string {
    $map = [
        '1st'  => '1<sup>st</sup>',
        '2nd' => '2<sup>nd</sup>',
        '3dr'  => '3<sup>rd</sup>',
        'Term'   => strtolower('Term')
    ];
    $key = strtolower(trim(str_replace('Term', '', $term)));
    return $map[$key] ?? $term;
}

include 'header.php'; ?>


<main class="home">
    <section class="hero">
        <div class="container py-lg-5">
            <h1 class="fw-bold">Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
            <ul class="list-unstyled lh-lg h5" id="studentInfo">
                <li><strong style="color: #f4b640">Age: </strong><?php echo date('Y') - (int) substr(htmlspecialchars($_SESSION['user_dob']) ?? '', -4) . ' years'; ?></li>
                <li><strong style="color: #f4b640">Gender: </strong><?php echo htmlspecialchars($_SESSION['user_gender']) ?></li>
                <li><strong style="color: #f4b640">Email: </strong><?php echo htmlspecialchars($_SESSION['user_email']) ?></li>
                <li><strong style="color: #f4b640">Phone: </strong><?php echo htmlspecialchars($_SESSION['phone']) ?></li>
                <li><strong style="color: #f4b640">Status: </strong><?php echo htmlspecialchars($_SESSION['user_type']) ?></li>
                <li><strong style="color: #f4b640">Reg No.: </strong><?php echo htmlspecialchars($_SESSION['reg_id']) ?></li>
            </ul>
        </div>
    </section>

    <section class="result-section">
        <div class="container table-responsive">
            <table class="table table-borderless" style="--bs-table-bg: transparent; --bs-table-color: inherit;">
                <thead class="text-center fs-5" style="color: #f4b640">
                    <tr>
                        <th style="width: 7%;">No.</th>
                        <th style="width: 12%;">Term</th>
                        <th style="width: 7%;">Year</th>
                        <th style="width: 7%;">English</th>
                        <th style="width: 7%;">Maths</th>
                        <th style="width: 7%;">Biology</th>
                        <th style="width: 7%;">Chemistry</th>
                        <th style="width: 7%;">Physics</th>
                        <th style="width: 7%;">Total</th>
                        <th style="width: 7%;">Average</th>
                        <th style="width: 7%;">Grade</th>
                        <th style="width: 12%;">Teacher</th>
                    </tr>
                </thead>
                <tbody class="text-center table-hover" style="color: var(--cream);">
                    <?php
                    // fetch ONLY this student's results from [student_results] table
                    $sql = "SELECT * FROM student_results WHERE student_id = ?";
                    $stmt = $connection->prepare($sql);
                    $stmt->execute([$studentId]);
                    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($row) :
                        $number = 1;
                        foreach ($row as $row):
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $number++; ?></td>
                                <td><?php echo convertTermToOrdinal($row['term']); ?></td>
                                <td><?php echo $row['year']; ?></td>
                                <td><?php echo $row['english']; ?></td>
                                <td><?php echo $row['maths']; ?></td>
                                <td><?php echo $row['biology']; ?></td>
                                <td><?php echo $row['chemistry']; ?></td>
                                <td><?php echo $row['physics']; ?></td>
                                <td><?php echo $row['total']; ?></td>
                                <td><?php echo $row['average']; ?></td>
                                <td><?php echo $row['grade']; ?></td>
                                <td>
                                    <?php
                                    $teacher_id = $row['teacher_id'];
                                    // get teacher firstname, lastname from [users] table where users.id = student_results.teacher_id ($row['teacher_id'])
                                    $sql ="SELECT firstname, lastname FROM users WHERE id = ?";
                                    $stmt = $connection->prepare($sql);
                                    $stmt->execute([$teacher_id]);
                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                    if ($row) :
                                        $teacher_name = $row['firstname'] . ' ' . $row['lastname'];
                                        echo $teacher_name;
                                    endif;
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr>
                            <td colspan="12" class="text-center py-4">
                                No results have been uploaded yet.
                            </td>
                        </tr>
                    <?php
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</main>


<?php include 'footer.php'; ?>