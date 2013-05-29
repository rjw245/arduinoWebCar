<?php
if(filesize('tasks.txt')<=0){
    echo "No tasks";
}
elseif(filesize('tasks.txt')<=32768){
    $tasks_handle=fopen('tasks.txt','r');
    $tasks_list=fread($tasks_handle,filesize('tasks.txt')+1);
    
    //Parse task list into individual tasks
    //and then into individual motor values
    $tasks_array=explode(",",$tasks_list);
    $i=0;
    foreach($tasks_array as $task){
        $tasks_array[$i] = explode(":",$task);
        $i++;
    }
    //Tasks_array=>tasks=>taskvals
    
    //Go through each task and, based on the
    //motor commands, generate formal descriptions
    //of each task to be appended to a single string.
    $task_descrips_list="";
    for($i=0; $i<count($tasks_array); $i++){
        $lmotor = $tasks_array[$i][0];
        $rmotor = $tasks_array[$i][1];
        if($lmotor == $rmotor && $rmotor>0) $task_descrips_list.="Forward.";
        if($lmotor == $rmotor && $rmotor<0) $task_descrips_list.="Backward.";
        if($lmotor > $rmotor) $task_descrips_list.="Turn right.";
        if($lmotor < $rmotor) $task_descrips_list.="Turn left.";
        if($i<count($tasks_array)-1) $task_descrips_list.=",";
    }
    //$task_descrips_list="Forward,Backward,Turn Left...etc"
    
    //Print list of descriptions.
    echo $task_descrips_list;
}
else{
    echo "Error: Task overload.";
}
?>