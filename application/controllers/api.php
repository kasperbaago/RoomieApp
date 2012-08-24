<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of api
 *
 * @author Baagoe
 */
class api extends CI_Controller {
    var $step;
    var $actions = array("welcome", "cardNumber", "payMent");
    
    public function s($step = 0) { 
        $this->load->model('step');
        $this->load->model('findinfo');
        $this->step = $step;
        
        if(isset($this->actions[$this->step])) {
            call_user_func(array($this, $this->actions[$this->step]));
        } else {
            $step = new step($this->step, "Der skete en fejl!", array("Roomate lukker når du trykker på næste.."), false, false);
            $step->setLastStep(true);
            $this->load->view('json_view', array('json' => $step->jsonOutput()));
        }
    }
    
    public function welcome() {
        $this->nextAction();
        $step = new step($this->step, "Velkommen til roomate", array("Tryk på næste for at komme videre..."), false, false);
        $this->load->view('json_view', array('json' => $step->jsonOutput()));
    }
    
    public function cardNumber() {
        $p = $this->getPostData();
        if($p['ocr'] != false) {
            $cardNumber = $this->findinfo->findCardNr($p['ocr']);
            $step = new step($this->step, "De sidste 4 cifre i dit kornummer", array($cardNumber, $p['ocr']), false , true);
            if($cardNumber == false) {
                $step->setReturn(array("", "Roomate kunne ikke genkende dit kortnummer!", "Tryk på tilbage for at tage et nyt billede"));
                $step->setLastStep(true);
            }
        } else if($p['retval'] != false) {
            $this->nextAction();
            return;
        } else {
            $step = new step($this->step, "Tag et billede af dit 4 cifrede kortnummer");
        }
        
        $this->load->view('json_view', array('json' => $step->jsonOutput()));
    }
    
    public function payment() {
        $p = $this->getPostData();
        if($p['ocr'] != false) {
            $cardNumber = $this->findinfo->findTotal($p['ocr']);
            $step = new step($this->step, "Det totale belob er", array($cardNumber, $p['ocr']), false , true);
            $step->setLastStep(true);
        } else {
            $step = new step($this->step, "Tag et billede af det totale belob");
        }
        $this->load->view('json_view', array('json' => $step->jsonOutput()));
    }
    
    private function getPostData() {
        if(isset($_FILES['picture'])) {
           $ocr = $this->getOCR($_FILES['picture']);
        } else {
            $ocr = false;
        }
        
        $step = false;
        $ok = false;
        $retval = false;
        if($_POST) {
            if(isset($_POST['step'])) {
                $step = $_POST['step'];
            }
            
            if(isset($_POST['ok'])) {
                $ok = $_POST['ok'];
            }
            
            if(isset($_POST['retval'])) {
                $retval = $_POST['retval'];
            }
        }
        
        if($step) {
            return array("step" => $step, "ocr" => $ocr, "ok" => $ok, "retval" => $retval);
        } else {
            return false;
        }
    }
    
    private function getOCR($pic) {
        $this->load->model('ocrscan');
        $this->load->model('filupload');
        
        $this->filupload->setMappe("ocrpics/");
        $pic = $this->filupload->upload($_FILES['picture']);
        $size = getimagesize($pic);
        
        if($size[0] > $size[1]) { //Rotate the picture if landscape
            //$this->filupload->rotate($pic, -90);
        }
        
        return $this->ocrscan->doOCR($pic);
    }
    
    private function nextAction() {
        if($p['retval'] = $this->getPostData() != false) {
            $this->step += 1;
            call_user_func(array($this, $this->actions[$this->step]));
        }
    }
    
}

?>
