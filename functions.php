<?php


/***
Built in functions used:
    trim()
    stripslashes()
    htmlspecialchars()
    strip_tags()
    str_replace()
    
***/
function validateFormData($formData){
    $formData= trim(stripslashes(htmlspecialchars(strip_tags(str_replace(array('(',')'),'',$formData ) ),ENT_QUOTES ) ) );
    
    return $formData;
}

function validatePassword($formData){
    $formData= trim(stripslashes(htmlspecialchars($formData)));
    
    return $formData;
}

?>