<?php

class Audio extends Eloquent
{
	protected $table = 'audio';
	protected $fillable = array('files','parts','time_per_chunk');
	protected $guarded  = array('id');
	public    $timestamps = false;
}