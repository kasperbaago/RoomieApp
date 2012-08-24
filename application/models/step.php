<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of step
 *
 * @author Baagoe
 */
class step  extends CI_Model {
    private $step, $msg, $return, $useCamera, $userInput, $lastStep;
    
    public function __construct($step = 0, $msg = "", $return = array(), $camera = true, $userInput = false) {
        parent::__construct();
        $this->step = (int) $step;
        $this->msg = $msg;
        $this->return = $return;
        $this->useCamera = $camera;
        $this->userInput = $userInput;
        $this->lastStep = false;
    }
    
    public function uftEncodeRet() {
        foreach($this->return as $k => $value) {
            if(is_string($value)) {
                $this->return[$k] = utf8_encode($value);
            }
        }
    }
    
    public function setStep($step) {
        $this->step =  $step;
    }

    public function setMsg($msg) {
        $this->msg = $msg;
    }

    public function setOutput($output) {
        $this->output = $output;
    }
    
    public function setUserInput($userInput) {
        $this->userInput = $userInput;
    }
    
    public function setLastStep($lastStep) {
        $this->lastStep = $lastStep;
    }
    
    public function setReturn($return) {
        $this->return = $return;
    }

    
        
    public function jsonOutput() {
        $this->uftEncodeRet();
        return array(
            "step" => $this->step,
            "msg" => utf8_encode($this->msg), 
            "returnData" => $this->return,
            "useCamera" => $this->useCamera,
            "userInput" => $this->userInput,
            "lastStep" => $this->lastStep
        );
    }

}

?>
