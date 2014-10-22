<?php 
	require_once __DIR__ . '/vendor/autoload.php';
	use PhpAmqpLib\Connection\AMQPConnection;
	use PhpAmqpLib\Message\AMQPMessage;



	function fire($datas)
    {
	    $connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
		$channel = $connection->channel();	
		//$channel->queue_declare('myQueue', false, false, false, false);
		$channel->queue_declare('myQueue', false, false, false, false);
    
    	$data=json_decode($datas,true);
    
       foreach ($data as $dat)
		{
			
			$continue = true;
			//$message= '{"id":'.$dat ->id.',"file":"'.$dat ->file.'","parts":"'.$dat ->parts.'","time_per_chunk":"'.$dat ->time_per_chunk.'"}';
			//$message= $Rowdat ->id .",". $Rowdat ->file;
			
			

			$id=$dat["id"];
			$file=$dat["file"];
			$parts=$dat["parts"];
			$time_per_chunk=$dat["time_per_chunk"];
			//$message= '{"id":'.$id.',"file":"'.$file.'","parts":"'.$parts.'","time_per_chunk":"'.$time_per_chunk.'"}';
			$message=$id.$file.$parts.$time_per_chunk;
			$message=json_encode($message,true);

			//return Response::Json($message);
			
			$msg = new AMQPMessage($message);
			$channel->basic_publish($msg, '', 'myQueue');
			//$channel->basic_publish($message, '', 'myQueue');
	//		$msg=json_encode($msg,true);
			echo " [x] Sent '". $msg->body ."'\n\n";

		}
		$channel->close();
		$connection->close();
		
    }
