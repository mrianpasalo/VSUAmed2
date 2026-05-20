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
            $student_id = $conn->insert_id;
            return $student_id;
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
                    OR s.middle_name LIKE ?
                    OR CONCAT(s.first_name, ' ', s.last_name) LIKE ?
                    OR CONCAT(s.first_name, ' ', s.middle_name, ' ', s.last_name) LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $search, $search, $search, $search, $search, $search);
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

    function getRecentVisits($id){
        global $conn;

        $sql = "SELECT *
                FROM visits AS v
                INNER JOIN prescription AS p ON p.visit_id = v.visit_id
                INNER JOIN admin AS a ON a.staff_id = v.staff_id
                WHERE v.student_id = ?
                ORDER BY v.visit_date DESC
                LIMIT 3";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $records = [];
        while($row = $result->fetch_assoc()){
            $records[] = $row;
        }
        return $records;
    }

    function getStudentById($id){
        global $conn;
        $sql = "SELECT *
                FROM students
                WHERE student_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    function enrollStud($id, $post){
        global $conn;
        $sql = "INSERT INTO student_enrollment
        (student_id, year_level_id, program_id, section_id, status, enrollment_date)
        VALUES (?, ?, ?, ?, ?, NOW())";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param(
            "sssss",
            $id,
            $post['year'],
            $post['prog'],
            $post['sec'],
            $post['status']
        );

        $stmt->execute();
        return $stmt;

    }
?>