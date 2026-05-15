<?php
    require_once 'connector.php';

    function addStdnt($conn, $post){
        $stdnt_num = $post['num'];
        $sex = $post['sex'];
        $lname = $post['lname'];
        $fname = $post['fname'];
        $mname = $post['mname'];
        $bday = $post['bday'];
        $email = $post['email'];
        $contact = $post['cont'];

        $sqlCheck = "SELECT * FROM students WHERE student_number = ?";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param("s", $stdnt_num);
        $stmtCheck->execute();

        $result = $stmtCheck->get_result();

        if ($result->num_rows > 0) {
            echo "
                <script>
                    alert('Student number already exists.')
                    window.location.href = '../views/manage_students.php?page=AddStudent'
                </script>
            ";
        } else {

            $sql = "INSERT INTO students
            (student_number, first_name, last_name, middle_name, birth_date, sex, contact_number, stud_email)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param(
                "ssssssss",
                $stdnt_num,
                $fname,
                $lname,
                $mname,
                $bday,
                $sex,
                $contact,
                $email
            );

            $stmt->execute();

            echo "
                <script>
                    alert('Student added successfully.')
                    window.location.href = '../views/manage_students.php?page=AddStudent'
                </script>
            ";
        }
    }

    function search($conn, $post){
        $search = "%" . $post['search'] . "%";
        $sql = "SELECT *
                FROM students AS s
                INNER JOIN student_enrollment AS se ON se.student_id = s.student_id
                INNER JOIN program AS p ON p.program_id = se.program_id
                INNER JOIN year_level AS y ON y.year_level_id = se.year_level_id
                INNER JOIN section AS sec ON sec.section_id = se.section_id
                WHERE 
                    s.student_number LIKE ?
                    OR s.first_name LIKE ?
                    OR s.last_name LIKE ?
                    OR s.middle_name LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $search, $search, $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();
        $students = [];
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        return $students;
    }

    
    function getStudentsByYear($pr, $yr){
        global $conn;
        $sql = "SELECT *
                FROM students AS s
                INNER JOIN student_enrollment AS se ON se.student_id = s.student_id
                INNER JOIN program AS p ON p.program_id = se.program_id
                INNER JOIN year_level AS y ON y.year_level_id = se.year_level_id
                INNER JOIN section AS sec ON sec.section_id = se.section_id
                WHERE
                    se.program_id = ?
                    AND se.year_level_id = ?
                ORDER BY sec.section_name asc, s.last_name asc, s.first_name asc";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $pr, $yr);
        $stmt->execute();
        $result = $stmt->get_result();
        $students = [];
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        return $students;
    }
    
?>