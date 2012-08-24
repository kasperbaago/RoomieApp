<form method="post" enctype="multipart/form-data">
                <input type="file" name="picture" />
                <input type="submit" value="Make OCR" />
            </form>

<?php 
if($ocrtext) {
    var_dump($ocrtext);
}
?>