<?php
include("app/controllers/send.php");
class HomeController extends BaseController {


	public function index()
	{
		$this->layout->nest('content', 'index');
	}

	public function store()
	{
		$audio = new Audio();
		$file = Input::file('filename');

		$name = $file->getClientOriginalName();
		$extension=$file->getClientOriginalExtension();
		$duracion = Input::get('duracion');
		$opcion = Input::get('opcion');
		$profiles = public_path(). "/media";
		
		if ($extension=="mp3"||$extension=="wav"||$extension=="ogg") {
		
			if ($opcion == "partes") {
				$audio->parts = $duracion;
				$audio->time_per_chunk = 0;
			}
			else{
				$audio->parts = 0;
				$audio->time_per_chunk = $duracion;
			}
			
			$audio->file = $profiles."/".$name;
		
			$audio->save();

			
			$upload = $file->move($profiles,$name);
		}
		else{
			Session::flash('message','Incompatible file, please select an audio file with MP3, WAV or OGG extension');
			Session::flash('class','danger');
		}
		

		$SongDatas=Audio::ver();
		$datas=json_encode($SongDatas);
		//$datas=Audio::all();
		//Queue::push('send', array('message' => $datas));
//
        fire($datas);

	
		//;
		return Redirect::to('/');

	

}
}
