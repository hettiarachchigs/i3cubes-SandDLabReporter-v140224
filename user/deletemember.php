<?php
include_once '../class/employee.php';
include_once '../class/employeeManager.php';
include_once '../class/team.php';
include_once '../class/teamManager.php';
include_once '../class/functions.php';
include_once '../class/constants.php';


$tid = $_POST['gid'];
$emid = $_POST['emp_id'];


$team2 = new team($tid);
$res = $team2->deleteMember($emid);
if ($res) {
    $close = true;
//    $msg = "<span class='ngs_success_span'>
//                <i class='fa-fw fa fa-check'></i>&nbsp;Group Member was deleted.
//                </span>";

   header("Location: editgmember?tid=".$tid);
} else {
    $close = false;
    $msg = "<span class='ngs_failure_span'>
            <i class='fa-fw fa fa-times'></i>&nbsp; Group Member Could not be deleted. please contact administrator.
            </span>";
     header("Location: editgmember?tid=".$tid);
}
?>
