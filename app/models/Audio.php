<?php

class Audio extends Eloquent
{
	protected $table = 'audio';
	protected $fillable = array('file','parts','time_per_chunk');
	protected $guarded  = array('id');
	public    $timestamps = false;

	public static function ver()
    {
    	return DB::select('SELECT * FROM audio ORDER BY id DESC LIMIT 1');

    }


}