<?php

class systemManager {

    public function serachFullInventory($serial, $partname, $location_id) {
        $ary_sql = array();
        $where = "";
        if ($serial != '') {
            array_push($ary_sql, "t1.serial like '%" . $serial . "%' ");
        }
        if ($partname != '') {
            array_push($ary_sql, "t1.ref_no like '%" . $partname . "%' ");
        }


        if ($location_id != '') {
            array_push($ary_sql, "t1.customer_entity_id='" . $location_id . "' ");
        }
        
        array_push($ary_sql, "t4.type='I' ");
        $fullinven = array();
        if (count($ary_sql) > 0) {
            array_push($ary_sql, " t1.status<>" . constants::$Deleted_STE);
            $where = " WHERE " . implode(" AND ", $ary_sql);
        } else {
//            $where = "LIMIT 500 ";
            $where = "where t1.status<>" . constants::$Deleted_STE;
        }

        $str = "SELECT t1.*,t2.name as Customer_entity_name,t3.GRN as grnno,t4.product_code,t4.description,t4.type,t4.model_id,t4.`status` as status1 
            FROM customer_systems as t1 left join customer_entity as t2 on t1.customer_entity_id=t2.id left join grn as t3 on t1.grn_id=t3.id 
            left join systems as t4 on t1.systems_id=t4.id" . $where;

//        echo $str;

        $result = dbQuery($str);
        if (dbNumRows($result) > 0) {
            while ($row = dbFetchAssoc($result)) {
                array_push($fullinven, $row);
            }
        }

        return $fullinven;
    }
    
   function getSystems ($systems_id){
       $results = array();
       $str = "SELECT * FROM systems WHERE id='$systems_id'";
       //print $str."<br>";
       $res = dbQuery($str);
       $row = dbFetchAssoc($res);
       /*while ($row = dbFetchAssoc($res)){
           array_push($results, $row);
       }*/
       return $row;
   }

}

?>
