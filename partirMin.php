<?php
	$path = 'prueba.mp3';	
	
	$time = exec("ffmpeg -i " . escapeshellarg($path) . " 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//");
	list($hms, $milli) = explode('.', $time);
	list($hours, $minutes, $seconds) = explode(':', $hms);
	$total_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;
	
	echo "\n";
	echo $time."\n";
	echo $hms."\n";
	echo $total_seconds."\n";
	echo ($argv[1])."\n";

	$result_division = ($total_seconds/$argv[1]);
	$file = substr($path, 0, -4);
	$extesion = substr($path, -4, 4); 

	$o=0;
	for ($i=0; $i < $result_division; $i++) { 
		
		if ($i==0){
			exec("ffmpeg -t ". $argv[1]." -i ".$file.$extesion." ".$file.$i.$extesion);
			exec("ffmpeg -ss ". $argv[1] ." -i ".$file.$extesion." ".$file."new".$i.$extesion);
		}else{
			exec("ffmpeg -t ". $argv[1] ." -i ".$file."new".$o.$extesion." ".$file.$i.$extesion);
			exec("ffmpeg -ss ". $argv[1] ." -i ".$file."new".$o.$extesion." ".$file."new".$i.$extesion);
			unlink($file."new".$o.$extesion);
			$o=$i;	
		}
		
	}
	unlink($file."new".$o.$extesion);


