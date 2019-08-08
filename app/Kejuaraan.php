<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Kejuaraan extends Model
{
	//protected $primaryKey = "idx";
	protected $table = "kejuaraan";
	public $timestamps = false;
	protected $primaryKey = 'kejKode';

	protected $fillable = array('kejKode','kejNama','kejTglBatas','kejDeskripsi','kejStatus');

	// foreign key ke table lain
	public function Prodi(){
		return $this->hasMany('App\Prodi', 'foreign_key', 'prodiKodeJurusan');
	}
}
