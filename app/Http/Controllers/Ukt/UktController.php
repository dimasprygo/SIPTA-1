<?php

namespace App\Http\Controllers\Ukt;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
 
use Validator;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ukt as Ukt;


class UktController extends Controller
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
    $data = array('ukt' => Ukt::all());
    
   
    return view('admin.dashboard.ukt.ukt',$data);
    //return view('admin.dashboard.jurusan');
  }
  
  protected function validator(array $data)
  {
        $messages = [
            'uktKode.required'    => 'Kode UKT harus di isi.',
            'uktKode.unique'      => 'Nomor UKT sudah digunakan.',
            'uktNama.required'    => 'Nama UKT harus di isi.',
            'uktPeriode.required'      => 'Periode harus di isi.',
            'uktTglBatas.required'    => 'Tanggal Batas UKT harus di isi.',
            'uktDeskripsi.required'    => 'Deskripsi harus disi .',
        ];
        return Validator::make($data, [
            'uktKode' => 'required|unique:ukt',
            'uktNama' => 'required|max:60',
            'uktPeriode' => 'required|max:60',
            'uktTglBatas'=> 'required|date|after:start_date',
            'uktDeskripsi'=> 'required|max:500',
        ], $messages);
  }
 

  public function tambah(array $data)
  {
        $ukt = new Ukt();
        $ukt->uktKode         = $data['uktKode'];
        $ukt->uktNama         = $data['uktNama'];
        $ukt->uktPeriode         = $data['uktPeriode'];
        $ukt->uktTglBatas        = $data['uktTglBatas'];
        $ukt->uktDeskripsi         = $data['uktDeskripsi'];

        //melakukan save, jika gagal (return value false) lakukan harakiri
        //error kode 500 - internel server error
        if (! $ukt->save() )
          App::abort(500);
  }

  public function tambahUkt(Request $request)
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
    $uktKode = Ukt::where('uktKode','=',$id)->first();

    if($uktKode==null)
      app::abort(404);
    $uktKode->delete();
    
    return Redirect::route('ukt');

  }

  public function editUkt($id)
  {

    $data = Ukt::find($id);

    return view('admin.dashboard.ukt.editukt',$data);
  }

  public function simpanedit(Request $request)
    {
      
      $messages = [
        'uktKode.required'    => 'Kode Kejuaraan harus di isi.',
        'uktKode.unique'      => 'Nomor kejuaaran sudah digunakan.',
        'uktNama.required'    => 'Nama Kejuaraan harus di isi.',
        'uktPeriode.required'      => 'Periode harus di isi.',
        'uktTglBatas.required'    => 'Tanggal Batas Kejuaraan harus di isi.',
        'uktDeskripsi.required'    => 'Deskripsi harus disi .',
    ];        

        $validator = Validator::make([
          'uktKode' => 'required|unique:kejuaraan',
          'uktNama' => 'required|max:60',
          'uktPeriode' => 'required|max:60',
          'uktTglBatas'=> 'required|date|after:start_date',
          'uktDeskripsi'=> 'required|max:500',
                      ], $messages);

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();
          # Bila validasi sukses
        }

      DB::table('ukt') ->where('uktKode', $request->id)->update([
        'uktKode'=>$request->uktKode,
        'uktNama'=>$request->uktNama,
        'uktPeriode'=>$request->uktPeriode,
        'uktTglBatas'=>$request->uktTglBatas,
        'uktDeskripsi'=>$request->uktDeskripsi
      ]);

        return Redirect::action('Ukt\UktController@index'); 
    }

    public function default_aktif(Request $request, $id)
    {
       if(Ukt::findOrFail($id))
        {
          DB::table('ukt')
              ->update(['uktStatus' => 1]);

          $editUkt = Ukt::find($id);
          $editUkt->uktStatus = 1;    
          if (! $editUkt->save())
            App::abort(500);
        }
    return Redirect::action('Ukt\UktController@index');

  }
}

