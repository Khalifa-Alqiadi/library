<?php

    function getTitle(){

    global $pageTitle;

    if(isset($pageTitle)){

        echo $pageTitle;

    }else{
        
        echo "Defult";
    }
    }

    function redirectHome($TheMsg, $url = null, $seconds = 3){

    if($url === null){
        $url = 'index.php';
        $link = 'HomePage';
    }else{
        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){

            $url = $_SERVER['HTTP_REFERER'];
            $link = 'Previous Page';

        }else{
            
            $url = 'index.php'; 
            $link = 'HomePage';
        } 
    }

    echo "<div class='container'>";
    echo $TheMsg;
    echo "<div class='alert alert-info'>You Will Redirected To $link After $seconds Seconds.</div>";

        header("refresh:$seconds;url=$url");
        
        exit(); 

    echo "</div>";
    }
