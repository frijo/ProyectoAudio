<?php

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
		if ($extension=="mp3"||$extension=="wav"||$extension=="ogg") {
		
			if ($opcion == "partes") {
				$audio->parts = $duracion;
				$audio->time_per_chunk = 0;
			}
			else{
				$audio->parts = 0;
				$audio->time_per_chunk = $duracion;
			}
			
			$audio->files = $name;
			$audio->save();

			$profiles = public_path(). "/media";
			$upload = $file->move($profiles,$name);
		}
		else{
			Session::flash('message','Incompatible file, please select an audio file with MP3, WAV or OGG extension');
			Session::flash('class','danger');
		}
		$SongData=Audio::all();
		$data=json_encode($SongData);
		return Redirect::to('/');

	}

}

