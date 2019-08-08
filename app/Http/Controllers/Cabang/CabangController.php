<?php

namespace App\Http\Controllers\Cabang;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Response;


use Validator;
//use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Cabang as Cabang;

class CabangController extends Controller
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
    // $jurusan = Jurusan::orderBy('jurKode')->get();
    $data = array('cabang' => Cabang::all());

   
    return view('admin.dashboard.cabang.cabang',$data);
        //  ->with('listjurusan', $jurusan);

    //return view('admin.dashboard.jurusan');
  }

  public function hapus($id)
  {
   
    $cabangKode = Cabang::where('cabangKode', '=', $id)->first();
    //$cabangKode = cabang::find($id)->cabang()->where('cabangKode', 'foo')->first();
    if ($cabangKode == null)
      app::abort(404);
    /*print_r($cabangKode->cabangKode);
    exit;*/
    $cabangKode->delete();
    //return Redirect::route('cabang');
    return Redirect::action('Cabang\CabangController@index');
            /*->with('successMessage','Data dengan kode '.$cabangKode->cabangKode.' telah berhasil dihapus');*/
  }

  protected function validator(array $data)
  {
        $messages = [
            'cabangKode.required'    => 'Kode Cabang dibutuhkan.',
            'cabangKode.unique'      => 'Kode Cabang sudah digunakan.',
            'cabangNama.required'    => 'Nama Cabang dibutuhkan.',
        ];
        return Validator::make($data, [
            'cabangKode' => 'required|unique:cabang',
            'cabangNama' => 'required|max:60',
        ], $messages);
  }
 
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
  protected function tambah(array $data)
  {

        $cabang = new Cabang();
        $cabang->cabangKode         = $data['cabangKode'];
        $cabang->cabangNama         = $data['cabangNama'];

        //melakukan save, jika gagal (return value false) lakukan harakiri
        //error kode 500 - internel server error
        if (! $cabang->save() )
          App::abort(500);
  }
 
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
 /*   public function postRegister(Request $request)
    {
        

        $validator = $this->validator($request->all());
        
        if ($validator->fails()) {
            //dd($request->all());
            $this->throwValidationException(
                $request, $validator
            );
            return Response::json(array(
              'fail' => true,
              'errors' => $validator->getMessageBag()->toArray()
            ));
        }
 
        $this->tambah($request->all());

        $data = array('prodi' => Prodi::all(),
                      'successMessage' => 'Data prodi "'.$request->prodiNama.'" telah berhasil ditambahkan');
        
        return view('admin.dashboard.prodi',$data);
        //return response()->json();
        //return Redirect::action('Prodi\ProdiController@index')
        //                ->with('successMessage','Data prodi "'.$request->prodiNama.'" telah berhasil ditambahkan'); 
    }
*/
    public function tambahcabang(Request $request)
    {
        $validator = $this->validator($request->all());
 
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
            //return Response::json( array('errors' => $validator->errors()->toArray()),422);
        }
 
        $this->tambah($request->all());
 
        return response()->json($request->all(),200);
        //return Redirect::action('Prodi\ProdiController@index')
        //               ->with('successMessage','Data prodi "'.$request->prodiNama.'" telah berhasil ditambahkan'); 

       /* $validator = $this->validator($request->all());

        if ($validator->passes()) 
        {                
           
          if ($this->tambah($request->all())){
            if(Request::ajax()){

               return Response::json(array('success' => true));
            }
          }
          return Redirect::to('prodi')->withError("Error: an error has occurred.");
        }
        
        return Response::json( array('fail' => true,'errors' => $validator->errors()->toArray()));
        */
    }

    public function editcabang($id)
    {

        $data = Cabang::find($id);
        // $jurusan = Jurusan::orderBy('jurKode')->get();

        return view('admin.dashboard.cabang.editcabang',$data);
                // ->with('listjurusan', $jurusan);
    }

    public function simpanedit($id)
    {
        $input =Input::all();
        $messages = [
            'cabangKode.required'    => 'Kode Cabang dibutuhkan.',            
            'cabangNama.required'    => 'Nama Cabang dibutuhkan.',
            
        ];
        

        $validator = Validator::make($input, [
                          'cabangKode' => 'required',
                          'cabangNama' => 'required|max:60',
                      ], $messages);

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();
          # Bila validasi sukses
        }

        $editCabang = Cabang::find($id);
        $editCabang->cabangKode = Input::get('cabangKode'); //atau bisa $input['cabangKode']
        $editCabang->cabangNama = $input['cabangNama'];
        if (! $editCabang->save())
          App::abort(500);

        return Redirect::action('Cabang\CabangController@index')
                          ->with('successMessage','Data Cabang "'.Input::get('cabangNama').'" telah berhasil diubah.'); 
    }
}

