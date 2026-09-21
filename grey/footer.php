<footer class="py-4 bg-black">
    <div class="container d-flex flex-column flex-sm-row justify-content-between gap-2 small text-secondary">
        <span>© 2026 Grey High Schools. All rights reserved.</span>
        <a class="text-secondary text-decoration-none" href="
        <?php 
        // 1. Get the user type or default to an empty string if it's not set
        $user_type = $_SESSION['user_type'] ?? '';

        // 2. Check the value safely
        if ($user_type === 'Teacher') : 
            echo 'controller/teacher.php'; 
        elseif ($user_type === 'Student') : 
            echo 'controller/student.php'; 
        elseif ($user_type === 'Admin') : 
            echo 'controller/admin.php'; 
        else : 
            echo 'includes/logout.php'; 
        endif; 
        ?>
        ">
            Student portal</a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>