<?php
session_start();
$json[]=array(
            'uid'=> $_SESSION['UID'],
            'user_name'=> $_SESSION['USERNAME']
        );
print json_encode($json);
?>