<?php

/*
 * Finds the CVR number, total sum and creditcard number
 * @author: Anders B. Ipsen | abi@bland.dk
 */

class findInfo extends CI_Model {
//    public function findCvr($text) {
//        $matches = array();
//        preg_match("#[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}#", $text, $matches);
//        return $matches;
//    }
    
    //find total sum
    public function findTotal($text) {
        $totalMatches = array();
        preg_match("#[0-9].+|,[0-9]#i", $text, $totalMatches);    //takes a number and any characters infront
        if(count($totalMatches) > 0){                   
            $number = $totalMatches[0];                 //defines number as the first result
            return $number;
        }else{
            return false;
        }
    }
    //find cardnumber
    public function findCardNr($text) {
        $cardMatches = array();
        if(preg_match("#.*[0-9]{4}#i", $text, $cardMatches)==true) {    //takes four integers and everything infront of them
                if(count($cardMatches) > 0) {
                $cardNumber = substr($cardMatches[0], -4);              //uses substring to isolate the last four characters
                return $cardNumber;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }    
}

?>
