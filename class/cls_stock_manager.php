<?php

include_once 'database.php';

class stock_manager {

    function reduceStock($cus_ent_id, $system_id, $qty) {
        $str = "UPDATE systems_stock SET balance=balance-$qty WHERE systems_id='$system_id' AND customer_entity_id='$cus_ent_id';";
        //print $str;
        $res = dbQuery($str);
        if (dbAffectedRows() == 0) {
            $str = "INSERT INTO systems_stock (systems_id,customer_entity_id,balance) VALUES('$system_id','$cus_ent_id','-$qty');";
            //print $str;
            $res = dbQuery($str);
        }
        return $res;
    }

    function addStock($cus_ent_id, $system_id, $qty) {
        if ($qty)
            $res = $this->updateStock($cus_ent_id, $system_id, $qty);
        if ($res == 0) {
            $res_ins = $this->insertStock($cus_ent_id, $system_id, $qty);
            return $res_ins;
        }
        return $res;
    }

    function updateStock($cus_ent_id, $system_id, $qty) {
        $str = "UPDATE systems_stock SET balance=IFNULL(balance,0)+$qty WHERE systems_id='$system_id' AND customer_entity_id='$cus_ent_id';";
        //print $str;
        $res = dbQuery($str);
        return dbAffectedRows();
    }

    function insertStock($cus_ent_id, $system_id, $qty) {
        $str = "INSERT INTO systems_stock (systems_id,customer_entity_id,balance) VALUES('$system_id','$cus_ent_id','$qty');";
        //print $str;
        $res = dbQuery($str);
        return $res;
    }

    function getCustomerStock($cus_id, $systems_id) {
        $str = "SELECT balance FROM systems_stock WHERE systems_id ='$systems_id' AND customer_entity_id='$cus_id';";
        $res = dbQuery($str);
        //print $str;
        $row = dbFetchArray($res);
        return $row[0];
    }

    function stockInUnconfirmedSTN($cus_id, $systems_id) {
        $str = "SELECT SUM(qty) FROM inventory_track WHERE reference_to='STN' AND systems_id='$systems_id' AND status='" . constants::$STOCK_ITEM_ACTIVE . "' AND customer_entity_id_from='$cus_id';";
        $res = dbQuery($str);
        //print $str;
        $row = dbFetchArray($res);
        return $row[0];
    }

    function stockbalance ($system_id){
        //id,  product_code, make_id, model_id, status, type - systems
        //id, systems_id, customer_entity_id, balance - systems_stock
        //id, name, area, code, status, category, cluster, cus_type, district_id, vendor_id
        $ary_sql = array();
        array_push($ary_sql, " t1.balance IS NOT NULL ");
        array_push($ary_sql, " t1.balance >=0 ");
        array_push($ary_sql, " t3.cus_type='S' AND t3.category='CUS' ");
        if($system_id !=""){
             array_push($ary_sql, " t1.systems_id ='$system_id' ");
        }
        if(count($ary_sql)>0){
            $WHERE  = " WHERE ". implode(" AND ", $ary_sql);
        }
        $str = "SELECT t1.id,t1.balance,t1.systems_id,t1.customer_entity_id,t2.description,t2.product_code,t3.name AS customer_name "
                . "FROM systems_stock AS t1 "
                . "LEFT JOIN systems AS t2 ON t1.systems_id = t2.id "
                . "LEFT JOIN customer_entity AS t3 ON t1.customer_entity_id = t3.id $WHERE";
        
        $res = dbQuery($str);
        $results = array();
        while ($row = dbFetchAssoc($res)){
            array_push($results, $row);
        }
        return $results;
        
    }

    function totalstock($system_id = "", $group_by = "", $location = '') {

        $ary_sql = array();
        $ary_group = array();
        if (is_array($system_id)) {
            $system_ids = implode(",", $system_id);
            array_push($ary_sql, "t1.systems_id IN ($system_ids) ");
        }
        if ($location != "") {
            if (is_array($location)) {
                $location_ids = implode(",", $location);
                array_push($ary_sql, "t1.customer_entity_id IN ($location_ids) ");
            } else {
                array_push($ary_sql, "t1.customer_entity_id='$location'");
            }
        }
        array_push($ary_group, "t1.systems_id");
        if ($group_by != "") {
            if (is_array($group_by)) {

                $ary_group = array_merge($ary_group, $group_by);
            }
            $SELECT = ",t3.id AS location_id,t3.name";
        }
        if (count($ary_group) > 0) {
            $GROPBY = " GROUP BY " . implode(",", $ary_group);
        }
        if (count($ary_sql) > 0) {
            $WHERE = " AND " . implode(" AND ", $ary_sql);
        }
        array_push($ary_group, "t1.systems_id");
        $str = "SELECT t1.systems_id,sum(t1.balance) AS total,t2.description,t2.product_code,t2.type $SELECT FROM systems_stock AS t1 "
                . "LEFT JOIN systems AS t2 ON t1.systems_id = t2.id "
                . "LEFT JOIN customer_entity AS t3 ON t1.customer_entity_id = t3.id "
                . "WHERE t3.cus_type='S' AND t3.category='CUS' $WHERE "
                . " $GROPBY;";
        //print $str."<br>";
        $res = dbQuery($str);

        $results = array();
        while ($row = dbFetchAssoc($res)) {
            array_push($results, $row);
        }
        return $results;
    }

    function currentStock($systems_id) {
        $str = "SELECT * FROM systems_stock WHERE systems_id ='$systems_id'";
        $res = dbQuery($str);
        /* $results = array();
          while ($row = dbFetchAssoc($res)){
          array_push($results, $row);
          } */
        $row = dbFetchAssoc($res);
        return $row;
    }

    function getStockLedger($cus_ent_id, $system_id, $from, $to) {
        $result = array();
        $str = "SELECT t1.*,t2.GRN as grn_no,t3.ref_no as stn_no,t2.Date as grn_date,t3.date as srn_date,t4.name as customer_from,t5.name as customer_to FROM inventory_track as t1 left join grn as t2 on t1.reference_id=t2.id "
                . "left join stn as t3 on t1.reference_id=t3.id left join customer_entity as t4 on t1.customer_entity_id_from=t4.id left join customer_entity as t5 on "
                . "t1.customer_entity_id_to=t5.id WHERE (t1.customer_entity_id_from='$cus_ent_id' OR t1.customer_entity_id_to='$cus_ent_id') "
                . "AND t1.systems_id='$system_id' AND t1.status='2';";
        //print $str;
        $res = dbQuery($str);
        while ($row = dbFetchAssoc($res)) {
            array_push($result, $row);
        }
        return $result;
    }
    function getConsumableStock($customer_entity_id,$systems_id,$type){
        $type = "C";
        $ary_sql = array();
        $results = array();
        if($customer_entity_id !=""){
            array_push($ary_sql, "t1.customer_entity_id='$customer_entity_id'");
        }
        if($systems_id !=""){
            array_push($ary_sql, "t1.systems_id='$systems_id'");
        }
        if($type !=""){
            array_push($ary_sql, "t3.type='$type'");
        }
        if(count($ary_sql)>0){
            $WHERE = " WHERE ".implode(" AND ", $ary_sql);
        }
        $str = "SELECT t1.*, t3.product_code,t3.description,t1.balance "
                . "FROM systems_stock AS t1 "
                . "LEFT JOIN customer_entity AS t2 ON t1.customer_entity_id = t2.id "
                . "LEFT JOIN systems AS t3 ON t1.systems_id = t3.id "
                . " $WHERE ";
        //print $str;
        $res = dbQuery($str);
        while ($row = dbFetchAssoc($res)){
            $sys_stock = new stdClass();
            $sys_stock->system_code = $row['product_code'];
            $sys_stock->system_name= $row['description'];
            $sys_stock->serial ="";
            $sys_stock->qty= $row['balance'];
            $sys_stock->cus_warr_end ="";
            $sys_stock->v_warr_end ="";
            
            array_push($results, $sys_stock);
        }
        return $results;
    }

}

?>