<?php

namespace App\Http\Controllers\Kejuaraan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
 
use Validator;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Kejuaraan as Kejuaraan;


class KejuaraanController extends Controller
{

	public function __construct()
  {
    //$this->middleware('auth');
   // $this->middleware('auth:dosen');
  }
      /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $data = array('kejuaraan' => Kejuaraan::all());
    
   
    return view('admin.dashboard.kejuaraan.kejuaraan',$data);
    //return view('admin.dashboard.jurusan');
  }
  
  protected function validator(array $data)
  {
        $messages = [
            'kejKode.required'    => 'Kode Kejuaraan harus di isi.',
            'kejKode.unique'      => 'Nomor kejuaaran sudah digunakan.',
            'kejNama.required'    => 'Nama Kejuaraan harus di isi.',
            'kejTglBatas.required'    => 'Tanggal Batas Kejuaraan harus di isi.',
            'kejDeskripsi.required'    => 'Deskripsi harus disi .',
        ];
        return Validator::make($data, [
            'kejKode' => 'required|unique:kejuaraan',
            'kejNama' => 'required|max:60',
            'kejTglBatas'=> 'required|date|after:start_date',
            'kejDeskripsi'=> 'required|max:500',
        ], $messages);
  }
 

  public function tambah(array $data)
  {
        $kejuaraan = new Kejuaraan();
        $kejuaraan->kejKode         = $data['kejKode'];
        $kejuaraan->kejNama         = $data['kejNama'];
        $kejuaraan->kejTglBatas         = $data['kejTglBatas'];
        $kejuaraan->kejDeskripsi         = $data['kejDeskripsi'];

        //melakukan save, jika gagal (return value false) lakukan harakiri
        //error kode 500 - internel server error
        if (! $kejuaraan->save() )
          App::abort(500);
  }

  public function tambahKejuaraan(Request $request)
  {
    $validator = $this->validator($request->all());
 
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

      $this->tambah($request->all());
  
      return response()->json($request->all(),200);
  }

  public function hapus($id)
  {
    $kejKode = Kejuaraan::where('kejKode','=',$id)->first();

    if($kejKode==null)
      app::abort(404);
    $kejKode->delete();
    
    return Redirect::route('kejuaraan');

  }

  public function editKejuaraan($id)
  {

    $data = Kejuaraan::find($id);

    return view('admin.dashboard.kejuaraan.editkejuaraan',$data);
  }

  public function simpanedit(Request $request)
    {
      
      $messages = [
        'prodiKode.required'    => 'Kode Program Studi dibutuhkan.',            
        'prodiNama.required'    => 'Nama Program Studi dibutuhkan.',
        'prodiJurKode.required' => 'Kita membutuhkan Kode Jurusan asal Program Studi .',
        ];
        

        $validator = Validator::make([
                          'prodiKode' => 'required',
                          'prodiNama' => 'required|max:60',
                          'prodiJurKode' => 'required',
                      ], $messages);

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();
          # Bila validasi sukses
        }

      DB::table('kejuaraan') ->where('kejKode', $request->id)->update([
        'kejKode'=>$request->kejKode,
        'kejNama'=>$request->kejNama,
        'kejTglBatas'=>$request->kejTglBatas,
        'kejDeskripsi'=>$request->kejDeskripsi
      ]);

        return Redirect::action('Kejuaraan\KejuaraanController@index'); 
    }

    public function default_aktif(Request $request, $id)
    {
       if(Kejuaraan::findOrFail($id))
        {
          DB::table('kejuaraan')
              ->update(['kejStatus' => 1]);

          $editKejuaraan = Kejuaraan::find($id);
          $editKejuaraan->kejStatus = 1;    
          if (! $editKejuaraan->save())
            App::abort(500);
        }
    return Redirect::action('Kejuaraan\KejuaraanController@index');

  }
}

