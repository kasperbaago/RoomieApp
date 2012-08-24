<?php
header("Content-type: application/json");
if(isset($json)) echo json_encode(array($json));
?>
