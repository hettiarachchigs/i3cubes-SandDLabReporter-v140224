<?php

include_once 'database.php';

class functions {

    function login($un,$ps){
        $res=-1;
        if($un=='' || $ps==''){
                $res=2;	//password or user name empty
        }
        else {
                $str="SELECT id,status FROM usr WHERE user_name='$un' AND password=SHA1('$ps') AND status <>'D';";
                //print $str;
                $result=dbQuery($str);
                if(dbNumRows($result)==1){
                        $row=dbFetchAssoc($result);
                        if($row['status']=='S'){
                                $res=array(3,'user suspended');	//suspended
                        }
                        else if ($row['status']=='C'){
                                $res=array(4,$row['id']); 	//need password change
                        }
                        else {
                                $res=array(1,$row['id']);	//success
                        }
                }
                else{
                        $res=array(0,'unsuccess');
                }
        }

        return $res;
    }
    function loginWithCode($code){
        $res=-1;
        $str="SELECT id,employee_id,status FROM usr WHERE code='$code' AND status='1';";
        //print $str;
        $result=dbQuery($str);
        if(dbNumRows($result)==1){
            $row=dbFetchAssoc($result);
            if($row['status']=='3'){
                $res=array(3,'user suspended');	//suspended
            }
            else if ($row['status']=='2'){
                $res=array(4,$row['id']); 	//need password change
            }
            else {
                $res=array(1,$row['id']);	//success
            }
        }
        else{
            $res=array(0,'unsuccess');
        }
        return $res;
    }
    function loginAnonemous($un){
        $res=-1;
        $str="SELECT id,status FROM usr WHERE user_name='$un';";
        //print $str;
        $result=dbQuery($str);
        if(dbNumRows($result)==1){
                $row=dbFetchAssoc($result);
                if($row['status']=='S'){
                        $res=array(3,'user suspended');	//suspended
                }
                else if ($row['status']=='C'){
                        $res=array(4,$row['id']); 	//need password change
                }
                else {
                        $res=array(1,$row['id']);	//success
                }
        }
        else{
                $res=array(0,'unsuccess');
        }
        return $res;
    }
    function CreateMenu($table, $column, $where, $selected = "", $distinct = false, $val_column = "", $slect_one = true, $order = true) {
        if (!$distinct) {
            if ($val_column == "") {
                $fields = $column;
            } else {
                $fields = $val_column . "," . $column;
            }
            if ($where == '') {
                $sqlstr = "SELECT $fields FROM $table";
            } else {
                $sqlstr = "SELECT $fields FROM $table WHERE $where";
            }
        } else {
            if ($where == '') {
                $sqlstr = "SELECT DISTINCT($column) FROM $table";
            } else {
                $sqlstr = "SELECT DISTINCT($column) FROM $table WHERE $where";
            }
        }
        if ($order) {
            $sqlstr = $sqlstr . " ORDER BY " . $column;
        } else {
            
        }
        //print $sqlstr;
        $result = dbQuery($sqlstr);
        $i = 0;
        $txt = "";
        if (!dbNumRows($result) == 0) {
            //print "XXXXXXX";
            if ($slect_one) {
                $txt .= '<option value="">Select One </option>';
            } else {
                $txt = '';
            }
            while ($row_x = dbFetchArray($result)) {
                if ($val_column == "") {
                    $val = $row_x[0];
                    $dis = $row_x[0];
                } else {
                    $val = $row_x[0];
                    $dis = $row_x[1];
                }
                if (($val == $selected) && ($selected != "")) {
                    $txt .= '<option value="' . $val . '" selected>' . $dis . '</option>';
                } else {
                    if ($row_x[0] != "") {
                        $txt .= '<option value="' . $val . '">' . $dis . '</option>';
                    }
                }
            }
        } else {
            $txt .= '<option selected value="">Not Available</option>';
        }
        return $txt;
    }

    function CreateCustomMenu($ary_text, $ary_val, $selected_tex = '', $selected_val = '') {
        //print "S=".$selected_val;
        $i = 0;
        $txt = "";
        foreach ($ary_text as $text) {
            if ($selected_tex != "") {
                if ($text == $selected_tex) {
                    $txt .= '<option value="' . $ary_val[$i] . '" selected>' . $text . '</option>';
                } else {
                    $txt .= '<option value="' . $ary_val[$i] . '">' . $text . '</option>';
                }
            } elseif ($selected_val != "") {
                if ($ary_val[$i] == $selected_val) {
                    $txt .= '<option value="' . $ary_val[$i] . '" selected>' . $text . '</option>';
                } else {
                    $txt .= '<option value="' . $ary_val[$i] . '">' . $text . '</option>';
                }
            } else {
                $txt .= '<option value="' . $ary_val[$i] . '">' . $text . '</option>';
            }
            $i++;
        }
        return $txt;
    }
   
}

?>