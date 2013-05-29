<?php
session_start();
if(!isset($_SESSION["last_task_timestamp"]) || (microtime(true)-$_SESSION["last_task_timestamp"]>=.6)){ //Prevent spamming, applies cooldown
    if($_GET && isset($_GET["lmotor"]) && isset($_GET["rmotor"]) && isset($_GET["dur"]) && filesize("tasks.txt")<32768){
        $lmotor = $_GET["lmotor"];
        $rmotor = $_GET["rmotor"];
        $dur = $_GET["dur"]; //Milliseconds
        if(is_numeric($lmotor) && is_numeric($rmotor)){
            //Ensure motor values and duration are
            //within the proper boundaries
            if($lmotor<-255) $lmotor=-255;
            if($lmotor>255) $lmotor=255;
            if($rmotor<-255) $rmotor=-255;
            if($rmotor>255) $rmotor=255;
            if($dur<500) $dur=500;
            if($dur>4000) $dur=4000;
            
            $tasks_handle=fopen("tasks.txt","r+");
            flock($tasks_handle,LOCK_EX);
            $current_tasks=fread($tasks_handle,filesize("tasks.txt")+1);
            rewind($tasks_handle);
            
            $motorvals=$lmotor.":".$rmotor.":".$dur; //Left:Right:Duration
            
            //Append new task to end
            //Prepend with comma if other tasks come before
            if(strlen($current_tasks)>0){
                $current_tasks = $current_tasks.",".$motorvals;
            }
            else{
                $current_tasks = $motorvals;
            }
            fwrite($tasks_handle,$current_tasks);
            fclose($tasks_handle);
        }
    }
}
$_SESSION["last_task_timestamp"] = microtime(true); //Update cooldown start
?>