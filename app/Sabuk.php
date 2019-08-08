<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Sabuk extends Model
{
	//protected $primaryKey = "idx";
	protected $table = "sabuk";
	protected $primaryKey = 'sabukKode';
	public $timestamps = false;
	
	
	protected $fillable = array('sabukKode','sabukNama');
	
	public function Anggota(){
    	return $this->hasMany('App\Anggota', 'foreign_key', 'anggotaid');
    }
}
