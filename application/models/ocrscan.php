<?php

/**
 * OCRSCAN
 * --------------
 * Gets text out of pictures
 * 
 * @author Kasper Baag� Jensen
 */

class ocrscan extends CI_Model {
    var $txtPath, $img, $lang, $psm, $ocrTempFolder;
    var $TEXT_EXT = ".txt";
    
    public function __construct() {
        parent::__construct();
        $this->txtPath = "TEMP_OCR_".time(). "_".rand(0, 100000);        
        $this->lang = "dan";
        $this->psm = 0;
        return true;
    }
    
    /*
     * Runs the OCR function
     * @return string/boolean false
     */
    public function doOCR($img, $lang = "dan", $psm = 0) {
        if(!$this->setImg($img) || !$this->setLang($lang) || !$this->setPsm($psm)) return false;
        $this->scanPic();
        $r = $this->getOCRText();
        $this->deleteTempFile();
        
        return $r;
    }
    
    /**
     * Using tesseract to OCR image scan
     * @return boolean 
     */
    public function scanPic() {
        if(!$this->img) return false;
        if($this->psm != false) {
            $psm = "-psm". $this->psm;
        } else {
            $psm = "";
        }
        $tempFile = $this->txtPath;
        exec("tesseract $this->img  $tempFile -l $this->lang $psm");
        return true;
    }
    
    /**
     * Returns the scanned text, scanned by OCR
     * @return string
     */
    public function getOCRText() {
        if(!file_exists($this->getTxtPath())) return false;
        return file_get_contents($this->getTxtPath());
    }
    
    /**
     * Deletes temperary file
     * @return boolean 
     */
    public function deleteTempFile() {
        if(file_exists($this->getTxtPath()) && file_exists($this->img)) {
            unlink($this->getTxtPath());
            unlink($this->img);
            return true;
        }
        
        return false;
    }
    
    /**
     * Returns OCR text file path
     * @return string 
     */
    public function getTxtPath() {
        return $this->txtPath. $this->TEXT_EXT;
    }
    
    /**
     * Sets image file to scan
     * @param string $img
     * @return boolean 
     */
    public function setImg($img) {
        if(!is_string($img)|| !file_exists($img)) return false;
        $this->img = $img;
        return true;
    }

    /**
     * Sets language - default dan
     * @param string $lang 
     */
    public function setLang($lang) {
        if(!is_string($lang)) return false;
        $this->lang = $lang;
        return true;
    }

    /**
     * Sets PSM mode - read tesseract documentation
     * Default 0
     * @param int $psm 
     */
    public function setPsm($psm) {
        if(!is_int($psm)) return false;
        $this->psm = $psm;
        return true;
    }

}

?>
