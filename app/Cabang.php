<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Cabang extends Model
{
	//protected $primaryKey = "idx";
	protected $table = "cabang";
	protected $primaryKey = 'cabangKode';
	public $timestamps = false;
	//protected $fillable = ['prodiKode','prodiKodeJurusan','prodiNama'];

	protected $fillable = array('cabangKode','cabangNama');

	public function Anggota(){
    	return $this->hasMany('App\Anggota', 'foreign_key', 'anggotaid');
    }

}
