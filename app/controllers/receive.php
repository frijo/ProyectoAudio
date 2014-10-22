<?php
	
	require_once __DIR__ . '/vendor/autoload.php';
	use PhpAmqpLib\Connection\AMQPConnection;
	
	# Setting up is the same as the sender; we open a connection and a channel,
	# and declare the queue from which we're going to consume. Note this matches up
	# with the queue that send publishes to.
	$connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
	$channel = $connection->channel();

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
		Part();
		echo " [x] Received "."Audio ID :".$json['id']."\n";
//	exec(ffmpeg -ss 0 -t 60 -i $path $newpath);
	//shell_exec (ffmpeg -ss 0 -t 60 -i $path $newpath );
		
	//exec(ffmpeg -i $path -acodec copy -t 00:00:60 -ss 00:00:00 $newpath);
	
	};
	function Part()
	{

	//	$path=public_path()."/media/"."bell-ringing-01.mp3";
	//	$newpath=public_path()."/PartsSongs/"."bell-ringing-01"."-part1".".mp3";
		$cmd="ffmpeg -ss 0 -t 120 -i /var/www/ProyectoAudio/public/media/America-Horse.mp3 /var/www/ProyectoAudio/public/PartsSongs/America-Horse-part1.mp3";
		shell_exec($cmd);
	}
	$channel->basic_consume('myQueue', '', false, true, false, false, $callback);

	while(count($channel->callbacks)) {
	    $channel->wait();
	}
?>