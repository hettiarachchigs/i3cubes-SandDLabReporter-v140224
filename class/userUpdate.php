<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of userUpdate
 *
 * @author Administrator
 */
class userUpdate {
    //put your code here
    public $id;
    public $reply;
    public $emp_id,$emp_name;
    public $time;
    
    function __construct($id='') {
        $this->id=$id;
    }
    
}
