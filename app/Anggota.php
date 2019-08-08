<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Anggota extends Model
{
	//protected $primaryKey = "idx";
	protected $table = "anggota";
	protected $primaryKey = 'id';
	public $timestamps = false;
	//protected $fillable = ['prodiKode','prodiKodeJurusan','prodiNama'];

	protected $fillable = array('anggotaid',
							'anggotaNim',
							'anggotaNama',
							'anggotaRiwayatPenyakit',
							'anggotaTglLahir',
							'anggotaHp',
							'anggotaAngkatan',
							'anggotaJK',
							'anggotaJur',
							'amggotaStatus');

	public function Cabang(){
    	return $this->hasMany('App\Cabang', 'foreign_key', 'cabangKode');
    }

    public function Sabuk(){
    	return $this->belongsTo('App\Sabuk', 'foreign_key', 'sabukKode');
    }


}
