# Grey School Portal — Student & Result Management System

A full-stack **school management and academic result portal** built with **PHP, MySQL, PDO, Bootstrap 5, HTML, CSS, and JavaScript**.

The system provides separate experiences for students and teachers through **role-based authentication and dashboard access**. Students can securely view their academic results, while teachers can create, update, search, and manage student results through a dedicated dashboard.

---

## 📌 Project Overview

**Grey School Portal** is a secondary-school management web application designed to provide a simple and structured way to manage student accounts and academic results.

The application combines a school profile website with an authenticated academic portal.

Students can create accounts, sign in, and view their academic performance.

Teachers can access a result-management dashboard where they can select students, enter scores, update existing results, and search student records.

The system uses **PHP and PDO** to communicate securely with a **MySQL database**, while Bootstrap 5 provides a responsive interface.

---

## ✨ Key Features

### 🔐 Authentication & User Access

* User registration and login
* Session-based authentication
* Role-based access control
* Separate access for:

  * Students
  * Teachers
  * Administrators
* Protected student and teacher dashboards
* Password-protected accounts
* Logout/session management

---

### 👨‍🎓 Student Dashboard

Students have a **read-only academic dashboard** where they can:

* View their personal profile information
* View their registration number
* View their academic results
* View results by term and academic year
* View individual subject scores
* View:

  * English
  * Maths
  * Biology
  * Chemistry
  * Physics
* View total score
* View average score
* View grade
* View the teacher responsible for the result

Students cannot modify their academic results.

---

### 👨‍🏫 Teacher Dashboard

Teachers have a dedicated **result-management dashboard** with read/write access.

Teachers can:

* View registered students
* View existing academic results
* Select a student using a checkbox
* Open a result-management form
* Create results for students who do not have results
* Update existing results
* Enter scores for multiple subjects
* Associate results with the teacher who entered them
* Search student/result records
* View calculated totals, averages, and grades

The system determines whether a result already exists and performs the appropriate **INSERT or UPDATE** operation.

---

### 📊 Result Management

The academic result system supports:

* English
* Maths
* Biology
* Chemistry
* Physics
* Total score
* Average score
* Grade
* Term
* Academic year
* Teacher identification

The database stores the relationship between students, results, and teachers.

Result records are connected to users through their IDs, allowing the system to identify the student and teacher associated with each record.

---

### 🔎 Result Search

The teacher dashboard includes a search system that allows teachers to search across student/result information.

The search can process information such as:

* Student first name
* Student last name
* Date of birth
* Gender
* Email
* User type
* Subject scores

If the search does not produce a matching record, the dashboard automatically returns to the **default student results view**.

---

### 📝 Student Registration

The registration system uses a multi-step form for collecting:

* First name
* Last name
* Date of birth
* Gender
* Email
* Phone number
* Password
* Account role

A registration number is automatically generated for users.

Example:

`GRE-XXXXXXXXXAA`

The registration process also includes client-side form validation and server-side processing.

---

### 🏫 School Profile / Landing Page

The public-facing website provides a school profile and introduction page containing:

* School introduction
* School values
* Learning philosophy
* Community information
* Registration call-to-action
* Login access
* Signup access

The landing page provides an entry point into the academic portal.

---

## 🛠️ Technologies Used

| Technology          | Purpose                                     |
| ------------------- | ------------------------------------------- |
| **PHP**             | Backend application logic                   |
| **MySQL**           | Database management                         |
| **PDO**             | Database connection and prepared queries    |
| **HTML5**           | Page structure                              |
| **CSS3**            | Custom styling                              |
| **Bootstrap 5**     | Responsive UI and components                |
| **Bootstrap Icons** | Interface icons                             |
| **JavaScript**      | Client-side interactions and form behaviour |
| **Google Fonts**    | Typography                                  |

---

## 🗄️ Database Structure

The application uses a relational MySQL database.

### `users`

Stores user account and profile information.

Main fields include:

```text
id
firstname
lastname
birthday
gender
email
phone
password
user_type
reg_id
```

---

### `student_results`

Stores academic result records.

Main fields include:

```text
id
student_id
term
year
english
maths
biology
chemistry
physics
total
average
grade
teacher_id
```

The `student_id` connects a result to the student's account.

The `teacher_id` identifies the teacher who created or updated the result.

---

## 🔗 Database Relationships

The application uses user IDs to connect different parts of the system.

```text
users
 │
 ├── Student
 │      │
 │      └──────── student_results
 │
 └── Teacher
        │
        └──────── student_results
```

Conceptually:

```text
users.id
   │
   ├──────── student_results.student_id
   │
   └──────── student_results.teacher_id
```

This allows the system to determine:

* Which student owns a result
* Which teacher entered/updated a result

---

## 🔐 Role-Based Access

The application checks the authenticated user's role before allowing access to protected dashboards.

### Student

```text
Login
  ↓
Authentication
  ↓
Student role verified
  ↓
Student Dashboard
  ↓
View results
```

### Teacher

```text
Login
  ↓
Authentication
  ↓
Teacher role verified
  ↓
Teacher Dashboard
  ↓
Create / Update / Search results
```

This prevents users from accessing dashboards intended for another role.

---

## 📁 Project Structure

A simplified structure of the project is:

```text
grey-school-portal/
│
├── index.php
├── login.php
├── signup.php
├── style.css
│
├── img/
│   └── grey.svg
│
├── js/
│   ├── showPasswordToggle.js
│   └── triggerError.js
│
├── includes/
│   ├── authenticateLogin.php
│   ├── register.php
│   ├── config.php
│   ├── session.php
│   └── logs/
│       └── app.log
│
├── student/
│   ├── student.php
│   ├── header.php
│   └── footer.php
│
└── teacher/
    ├── teacher.php
    ├── header.php
    └── footer.php
```

*The exact structure may vary depending on the final project configuration.*

---

## ⚙️ How the Result Management Works

### Creating a Result

A teacher selects a student and opens the result form.

The system checks whether the student already has a result record.

If no result exists:

```text
Student selected
       ↓
Check database
       ↓
No result found
       ↓
INSERT new result
```

If a result already exists:

```text
Student selected
       ↓
Check database
       ↓
Existing result found
       ↓
UPDATE result
```

This prevents the teacher from having to use completely separate forms for creating and editing results.

---

## 🔍 Search Workflow

The teacher dashboard initially displays the complete student result table.

When a teacher searches:

```text
Default Results Table
        ↓
Enter search term
        ↓
Submit Search
        ↓
Search joined user/result data
        ↓
 ┌───────────────┐
 │ Match found?  │
 └───────┬───────┘
         │
    ┌────┴────┐
   YES        NO
    │          │
    ↓          ↓
Show matches  Show default table
```

The search uses PDO prepared statements rather than directly inserting user input into SQL queries.

---

## 🔒 Security Considerations

The project uses several basic security practices, including:

* PDO prepared statements
* Session-based authentication
* Role-based authorization
* `htmlspecialchars()` when displaying user-controlled data
* Password-protected accounts
* Server-side authentication checks
* Separation of authentication and dashboard logic
* Error logging

Example of a protected dashboard check:

```php
if ($_SESSION['user_type'] !== 'Student') {
    header("Location: ../login.php");
    exit();
}
```

---

## 🎨 User Interface

The interface uses **Bootstrap 5** together with custom CSS to create a responsive school portal.

The project includes:

* Responsive layouts
* Bootstrap forms
* Bootstrap modals
* Responsive result tables
* Custom school branding
* Custom typography
* Form validation feedback
* Student and teacher dashboard layouts

---

## 🚀 Getting Started

### 1. Clone the repository

```bash
git clone https://github.com/YOUR-USERNAME/YOUR-REPOSITORY.git
```

### 2. Move the project

Place the project inside your local web server directory.

For example, with XAMPP:

```text
C:/xampp/htdocs/
```

### 3. Create the database

Create a MySQL database using phpMyAdmin.

Example:

```sql
create database grey_school;
```

### 4. Configure the database connection

Update your database configuration in:

```text
includes/config.php
```

with your local MySQL credentials.

### 5. Import the database tables

Create/import the required tables:

```text
users
student_results
```

and configure their relationships.

### 6. Start the local server

Start:

* Apache
* MySQL

from your local development environment.

### 7. Open the project

Visit:

```text
http://localhost/grey-school-portal/
```

---

## 👤 User Roles

| Role    | Access                                     |
| ------- | ------------------------------------------ |
| Student | View personal profile and academic results |
| Teacher | Manage student academic results            |
| Admin   | Account/system administration              |

---

## 🎯 Project Objectives

The project was built to demonstrate practical implementation of:

* PHP backend development
* MySQL database design
* PDO database interaction
* CRUD operations
* SQL joins
* Prepared statements
* Session management
* Role-based authorization
* Form processing
* Result computation
* Search functionality
* Responsive frontend development
* Separation of user permissions

---

## 📚 What This Project Demonstrates

This project demonstrates how a relational database can be connected to a PHP application to create a real-world school workflow.

Instead of treating students, teachers, and academic results as isolated records, the system connects them through relational database IDs and controlled user access.

The project also demonstrates the difference between **read-only** and **read/write** access:

```text
Student
   ↓
Read-only
   ↓
View academic results


Teacher
   ↓
Read + Write
   ↓
Create / Update academic results
```

---

## 🔮 Possible Future Improvements

Future versions could include:

* Admin dashboard
* Subject management
* Multiple result records per student by term and year
* Result report/print functionality
* PDF result generation
* Student result ranking
* Attendance management
* Class management
* Teacher-subject assignment
* Password reset
* Email verification
* Profile editing
* Audit/history tracking
* Pagination for large student databases
* More advanced search and filtering
* Improved validation and security hardening

---

## 👨‍💻 Author

**Uduak Akpan**

Network Engineer | PHP Developer | IT Support

This project was developed as a practical full-stack web application demonstrating backend development, relational databases, authentication, authorization, CRUD operations, SQL queries, and responsive frontend design.

---

## 📄 License

This project is intended for educational and portfolio purposes.

Add an appropriate open-source license if you decide to distribute the source code publicly.
