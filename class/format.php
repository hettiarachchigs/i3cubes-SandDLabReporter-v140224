<?php

class format{
    function formartCurrency($n){
        $n_f=number_format($n,2,'.',',');
        return $n_f;
    }
}
