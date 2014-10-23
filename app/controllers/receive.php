<?php
	require_once __DIR__ . '/vendor/autoload.php';
	use PhpAmqpLib\Connection\AMQPConnection;

	$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
	$channel = $connection->channel();


	
	# Setting up is the same as the sender; we open a connection and a channel,
	# and declare the queue from which we're going to consume. Note this matches up
	# with the queue that send publishes to.
	

	

	
	$channel->queue_declare('myQueue', false, false, false, false);
	echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
	
	$callback = function($msg) 
	{
	

		$json = $msg->body;
		$json=(json_decode($json,true));
		//$to = "../public/assets/convertSong/".$json["name"].".".$json["to"];
	//	$var = 'sox'." ".$json["from"]." "."../public/assets/convertSong/".$json["name"].".".$json["to"];	
		//$var = 'sox ../public/assets/song/noa23Ld26Y.wav ../public/assets/convertSong/noa23Ld26Y.FLAC';
	//	exec($var);
	//	update($json["id"],$to);
		//echo $json["file"]."\n";
		Part($json);
		echo " [x] Received "."Audio ID :".$json['id']." "."file :".$json['file']."\n";
//	exec(ffmpeg -ss 0 -t 60 -i $path $newpath);
	//shell_exec (ffmpeg -ss 0 -t 60 -i $path $newpath );
		
	//exec(ffmpeg -i $path -acodec copy -t 00:00:60 -ss 00:00:00 $newpath);
	
	};
	function Part($json)
	{
		//$json = $msg->body;
		//$json=(json_decode($json,true));
		$cont=0;
	//	$path=public_path()."/media/"."bell-ringing-01.mp3";
	//	$newpath=public_path()."/PartsSongs/"."bell-ringing-01"."-part1".".mp3";
		if(!$json['parts']=0)
		{

			$cmd='ffmpeg -ss 0 -t 120 -i '.$json['file'].' /var/www/ProyectoAudio/public/PartsSongs/Song'.$json['id'].'-part'.$cont.'.mp3';
			shell_exec($cmd);
		}

		
		$DownloadRute='/var/www/ProyectoAudio/public/PartsSongs/Song'.$json['id'].'-part'.$cont.'.mp3';
		Update($json,$DownloadRute);

		
	}
	function Update($json,$DownloadRute)
	{
		$link=mysql_connect("localhost","root","91j11d20a18a");

		mysql_select_db("ProyectoAudio",$link) OR DIE (
		"Error: No es posible establecer la conexión"
		);
	 
		$id=$json['id'];
		$file=$json['file'];
		$parts=$json['parts'];
		$time_per_chunk=$json['time_per_chunk'];
		$url_download=$DownloadRute;
		
		


	   $tablename="audioParts";
	   $query="insert into audioParts( file,parts,time_per_chunk,audio_id,url_download) VALUES('$file','$parts','$time_per_chunk','$id','$DownloadRute')";

	   	mysql_query($query);
	   	mysql_close();
		
	}
	$channel->basic_consume('myQueue', '', false, true, false, false, $callback);

	while(count($channel->callbacks)) {
	    $channel->wait();
	}

?>