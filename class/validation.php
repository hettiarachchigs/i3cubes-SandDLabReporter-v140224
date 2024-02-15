<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of validation
 *
 * @author Sudaraka Ranasinghe
 */
class validation {

    public function isEmpty($str) {
        $sttrim = trim($str);

        if ($sttrim == '') {
            return true;
        } else if ($str == null) {
            return true;
        } else {

            return false;
        }
    }

    public function Numbercheck($str) {
       
        if ($str == "") {
            return 0;
        } else if ($str == null) {
            return 0;
        }else{
            return $str;
        }
    }

}
