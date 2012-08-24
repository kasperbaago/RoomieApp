<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of test
 *
 * @author Baagoe
 */
class test extends CI_Controller {
    public function ocrtest() {
        $this->load->model('ocrscan');
        $this->load->model('filupload');
        $this->load->model('findInfo');
        $ocrtext = false;
        if($_FILES) {
            $this->filupload->setMappe("ocrpics/");
            $pic = $this->filupload->upload($_FILES['picture']);
            $ocrtext = $this->ocrscan->doOCR($pic);
            //$cvrMatches = $this->findInfo->findCvr($ocrtext);
            $totalMatches = $this->findInfo->findTotal($ocrtext);
            $cardMatches = $this->findInfo->findCardNr($ocrtext);
            //print_r($cvrMatches);
            print_r($totalMatches);
            print_r($cardMatches);
        }
        
        $form = $this->load->view("ocr_upload", array("ocrtext" => nl2br($ocrtext)),true);
        $this->load->view("template", array("content" => $form));
    }
}

?>
