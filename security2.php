<?php

    #config
    $_SESSION["error_page"] = ""; 
    $_SESSION["limit"] = 5; #max request every second
    #end config

function inpuattack($url) {
    $payload = array(">","<","+","union","../");
    $error = $_SESSION["error_page"];
    foreach ($x in $payload) {
        if (substr_count($url, urlencode($x)) > 0) {
            header("Location: $error");
        }
        if (substr_count($url, $x) > 0) {
            header("Location: $error");
        }
    }
    
}
function ddosattack() {
    $time = $_SESSION["RTIME"]; 
    $count = $_SESSION["RCOUNT"];
    $error = $_SESSION["error_page"];
    if ($time == time()) {
        if (isset($_SESSION["RCOUNT"])){
            $_SESSION["RCOUNT"] = 0;
        }
        
        $_SESSION["RCOUNT"] = $count + 1;
    }
    if ($a > $_SESSION["limit"]) {
        header("Location: $error");
    }
}
function rewrite($url) {
    $a = str_replace(".php", "", $url);
    $a = str_replace(".html", "", $a);
    header("Location: $a");
}
function templating($x) {
    $php = file_get_contents("$x.php");
    $hmtl = file_get_contents("$x.html");
    if (isset($php)) {
        require("$x.php");
    } elseif (isset($html)) {
        require("$x.html");
    } else {
        $y = explode("?", $x)[0];
        if ($y == "/") {
            require("./index.php);
    }
}

function bootsrap() {
    $url = $_SERVER["REQUEST_URI"];
    ddosattack();
    inpuattack($url);
    rewrite($url);
    

}

bootsrap();



