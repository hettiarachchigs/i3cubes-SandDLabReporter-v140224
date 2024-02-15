<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of constants
 *
 * @author Sudaraka Ranasinghe
 */
class constants {

    public static $Active = 1;
    public static $Open= 2;
    public static $Pending= 3;
    public static $Deleted= 0;
    public static $Cancel= 5;
    public static $Inprogress = 6;
    public static $Close = 7;
    public static $Repaired= 8;
    public static $Estimated= 9;
    public static $Renewed= 10;
    public static $Resolved= 11;
    public static $Confirmed= 12;

    public function getStatus($id) {
        switch ($id) {
            case '1':
                return 'ACTIVE';
                break;
            case '2':
                return 'OPEN';
                break;
            case '3':
                return 'PENDING';
                break;
            case '4':
                return 'DELETED';
                break;
            case '0':
                return 'DELETED';
                break;
            case '5':
                return 'CANCEL';
                break;
            case '6':
                return 'INPROGRESS';
                break;
            case '7':
                return 'CLOSED';
            case '8':
                return 'Repaired';
            case '9':
                return 'Estimated';
                break;
            case '11':
                return 'Resolved';
                break;
        }
    }
    
}
