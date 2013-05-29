<?php
if(filesize('tasks.txt')<=0){
    echo "0:0:1500";
}
elseif(filesize('tasks.txt')<=32768){
    $tasks_handle=fopen('tasks.txt','c+');
    $tasks_list=fread($tasks_handle,filesize('tasks.txt')+1);
    
    //Parse task list by commas,
    //and then parse tasks except for
    //the first back into a string. This
    //will eventually simulate popping this
    //task off the "stack".
    $tasks_array=explode(",",$tasks_list);
    
    //Print out the current task
    //for use by the Arduino
    $cur_task = $tasks_array[0];
    echo $cur_task;
    
	//If proper GET is specified,
	//we know Arduino is the one accessing
	//the task. This means we proceed with deleting
	//the current task by filling txt file
	//with a list of tasks minus the first one.
	if(isset($_GET["arduino"]) && $_GET["arduino"]=="1"){
		$new_tasks_list="";
		for($i=1;$i<count($tasks_array);$i++){
			$new_tasks_list.=$tasks_array[$i];
			if($i<count($tasks_array)-1) $new_tasks_list.=",";
		}
		//Lock, truncate, and repopulate
		//the task list with $new_tasks_list
		//such that the current task has
		//been deleted, the others bumped up.
		rewind($tasks_handle);
		flock($tasks_handle,LOCK_EX);
		ftruncate($tasks_handle,0);
		fwrite($tasks_handle,$new_tasks_list);
	}
	fclose($tasks_handle);
}
else{
    echo "Error: Task overload.";
}
?>