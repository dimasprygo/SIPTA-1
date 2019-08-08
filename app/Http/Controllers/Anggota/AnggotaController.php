<?php

namespace App\Http\Controllers\Anggota;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Response;

use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Anggota as Anggota;
use App\Cabang as Cabang;
use App\Sabuk as Sabuk;

class AnggotaController extends Controller
{
  
	public function __construct()
  {
    $this->middleware('auth');
  }
      /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $sabuk = Sabuk::orderBy('sabukKode')->get();
    $cabang = Cabang::orderBy('cabangKode')->get();
    $data = array('anggota' => Anggota::all());

   
    return view('admin.dashboard.anggota.anggota',$data)
          ->with('listsabuk', $sabuk)
          ->with('listcabang', $cabang);

    // $dataAnggota = Anggota::select(DB::raw("anggota.anggotaid as id, anggotaNim, anggotaNama, anggotaRiwayatPenyakit, 
    //                                         anggotaTglLahir, anggotaHp, anggotaAngkatan, anggotaJK, anggotaJur, anggotaStatus, 
    //                                         anggotaSabuk, SabukNama,
    //                                         anggotaCabang, cabangNama"))
    //     ->join('cabang', 'cabang.cabangKode', '=', 'anggota.anggotaCabang')
    //     ->join('sabuk','sabuk.sabukKode','=','anggota.anggotaSabuk')
    //     ->orderBy(DB::raw("cabangKode"))
    //     ->orderBy(DB::raw("sabukKode"))       
    //     ->get();
        
    // $data = array('anggota' => $dataAnggota);   
    // return view('admin.dashboard.anggota.anggota',$data);
  }

  public function detail($anggotaid)
  {
    $dataAnggota = Anggota::select(DB::raw("anggota.anggotaid as id, anggotaNim, anggotaNama, anggotaRiwayatPenyakit, 
                                            anggotaTglLahir, anggotaHp, anggotaAngkatan, anggotaJK, anggotaJur, anggotaStatus, 
                                            anggotaSabuk, sabukNama,
                                            anggotaCabang, cabangNama"))
        ->join('cabang', 'cabang.cabangKode', '=', 'anggota.anggotaCabang')
        ->join('sabuk','sabuk.sabukKode','=','anggota.anggotaSabuk')
        ->orderBy(DB::raw("cabangKode"))   
        ->where('anggotaid', $anggotaid)
        ->get();

      
      // $data['anggota'] = DB::table('anggota')
      //                 ->join('cabang', 'anggota.anggotaCabang', '=', 'cabang.cabangKode')
      //                 ->join('sabuk', 'anggota.anggotaSabuk', '=', 'sabuk.sabukKode')
      //                 ->select('anggota.*', 'sabuk.sabukNama', 'cabang.cabangNama')
      //                 ->where('anggotaid', $id)
      //                 ->get();

      $data = array('anggota' => $dataAnggota);  
        return view('admin.dashboard.anggota.detailanggota',$data);



    // return view('admin.dashboard.anggota.detailanggota', compact('dataAnggota'));
    // return view('admin.dashboard.anggota.detailanggota',$data);
  }

  public function hapus($id)
  {
   
    $anggotaKode = Anggota::where('anggotaid', '=', $id)->first();
    
    if ($anggotaKode == null)
      App::abort(404);

    /*print_r($anggotaKode->anggotaKode);
    exit;*/
    $anggotaKode->delete();

    //return Redirect::route('anggota');
    return Redirect::action('Anggota\AnggotaController@index');
            /*->with('successMessage','Data dengan kode '.$anggotaKode->anggotaKode.' telah berhasil dihapus');*/
  }

  protected function validator(array $data)
  {
        $messages = [
            'prodiKode.required'    => 'Kode Program Studi dibutuhkan.',
            'prodiKode.unique'      => 'Kode Program Studi sudah digunakan.',
            'prodiNama.required'    => 'Nama Program Studi dibutuhkan.',
            'prodiJurKode.required' => 'Kita membutuhkan Kode Jurusan asal Program Studi .',
        ];
        return Validator::make($data, [
            'prodiKode' => 'required|unique:program_studi',
            'prodiNama' => 'required|max:60',
            'prodiJurKode' => 'required',
        ], $messages);
  }
 
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
  protected function tambah()
    {

      return view('admin.dashboard.anggota.tambahanggota');
    }
 
  public function regisanggota(Request $request)
    {
        
        $input= $request->all();
        $anggota = new Anggota;
        $anggota->anggotaid           = $input['anggotaid'];
        $anggota->anggotaNama         = $input['anggotaNama'];
        $anggota->anggotaNim          = $input['anggotaNim'];
        $anggota->anggotaRiwayatPenyakit          = $input['anggotaRiwayatPenyakit'];
        $anggota->anggotaTglLahir          = $input['anggotaTglLahir'];
        $anggota->anggotaHp          = $input['anggotaHp'];
        $anggota->anggotaAngkatan          = $input['anggotaAngkatan'];
        $anggota->anggotaJur          = $input['anggotaJur'];
        $anggota->anggotaJK          = $input['anggotaJK']; 
        $anggota->anggotaCabang          = $input['anggotaCabang']; 
        $anggota->anggotaSabuk          = $input['anggotaSabuk']; 

        if (! $anggota->save())
        App::abort(500);

        return Redirect::action('Anggota\AnggotaController@index')
                          ->with('successMessage','Data Anggota 
                          "'.$input['anggotaid'].'"
                          "'.$input['anggotaNama'].'"
                          "'.$input['anggotaNim'].'"
                          "'.$input['anggotaRiwayatPenyakit'].'"
                          "'.$input['anggotaTglLahir'].'"
                          "'.$input['anggotaAngkatan'].'"
                          "'.$input['anggotaJur'].'"
                          "'.$input['anggotaJK'].'" 
                          "'.$input['anggotaCabang'].'" 
                          "'.$input['anggotaSabuk'].'" telah berhasil diubah.'); 
        
        

    }

    public function edit($id)
    {

        $data = Anggota::where('anggotaid', '=', $id)->first();
        $sabuk = Sabuk::orderBy('sabukKode')->get();
        $cabang = Cabang::orderBy('cabangKode')->get();

        return view('admin.dashboard.anggota.editanggota',$data)
                ->with('listCabang', $cabang)
                ->with('listSabuk', $sabuk);
    }

    public function simpanedit(Request $request, $id)
    {
         DB::table('anggota') ->where('anggotaid', $id)->update([
          'anggotaNama'=>$request->anggotaNama,
          'anggotaNim'=>$request->anggotaNim,
          'anggotaRiwayatPenyakit'=>$request->anggotaRiwayatPenyakit,
          'anggotaTglLahir'=>$request->anggotaTglLahir,
          'anggotaHp'=>$request->anggotaHp,
          'anggotaAngkatan'=>$request->anggotaAngkatan,
          'anggotaRiwayatPenyakit'=>$request->anggotaRiwayatPenyakit,
          'anggotaJur'=>$request->anggotaJur,
          'anggotaJK'=>$request->anggotaNama,
          'anggotaCabang'=>$request->anggotaCabang,
          'anggotaSabuk'=>$request->anggotaSabuk

        ]);
  
          return Redirect::action('Anggota\AnggotaController@index'); 

        // $editAnggota = Anggota::find($anggotaid);
        // $editAnggota->anggotaNama         = $request->get('anggotaNama');
        // $editAnggota->anggotaNim          = $request->get('anggotaNim');
        // $editAnggota->anggotaRiwayatPenyakit          = $request->get('anggotaRiwayatPenyakit');
        // $editAnggota->anggotaTglLahir          = $request->get('anggotaTglLahir');
        // $editAnggota->anggotaHp          = $request->get('anggotaHp');
        // $editAnggota->anggotaAngkatan          = $request->get('anggotaAngkatan');
        // $editAnggota->anggotaJur          = $request->get('anggotaJur');
        // $editAnggota->anggotaJK          = $request->get('anggotaJK'); 
        // $editAnggota->anggotaCabang          = $request->get('anggotaCabang'); 
        // $editAnggota->anggotaSabuk          = $request->get('anggotaSabuk'); 
        // // $editAnggot->prodiKodeJurusan =  Input::get->get('prodiJurKode');
        // if (! $editAnggota->save())
        //   App::abort(500);

        // return Redirect::action('Anggota\AnggotaController@index')
        //                   ->with('successMessage','Data Anggota "'.Input::get('AnggotaNama').'" telah berhasil diubah.'); 
    }
}

