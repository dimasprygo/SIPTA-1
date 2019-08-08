<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Ukt extends Model
{
	//protected $primaryKey = "idx";
	protected $table = "ukt";
	public $timestamps = false;
	protected $primaryKey = 'uktKode';

	protected $fillable = array('uktKode','uktNama','uktPeriode','uktTglBatas','uktDeskripsi','uktStatus');

	// foreign key ke table lain
	public function Prodi(){
		return $this->hasMany('App\Prodi', 'foreign_key', 'prodiKodeJurusan');
	}
}
