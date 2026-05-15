<?php
    require_once '../model/connector.php';
    require_once '../model/students.php';

    function getStudentsByYearProgram($pr, $yr){
        $main = getStudentsByYear($pr, $yr);
        return $main;
    }

?>