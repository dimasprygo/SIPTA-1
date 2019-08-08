<?php

namespace App\Http\Controllers\Sabuk;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Response;


use Validator;
//use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Sabuk as Sabuk;

class SabukController extends Controller
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
    $data = array('sabuk' => Sabuk::all());

   
    return view('admin.dashboard.sabuk.sabuk',$data);
        //  ->with('listjurusan', $jurusan);

    //return view('admin.dashboard.jurusan');
  }

  public function hapus($id)
  {
   
    $sabukKode = Sabuk::where('sabukKode', '=', $id)->first();
    //$sabukKode = sabuk::find($id)->sabuk()->where('sabukKode', 'foo')->first();
    if ($sabukKode == null)
      app::abort(404);
    /*print_r($sabukKode->sabukKode);
    exit;*/
    $sabukKode->delete();
    //return Redirect::route('sabuk');
    return Redirect::action('Sabuk\SabukController@index');
            /*->with('successMessage','Data dengan kode '.$sabukKode->sabukKode.' telah berhasil dihapus');*/
  }

  protected function validator(array $data)
  {
        $messages = [
            'sabukKode.required'    => 'Kode Sabuk dibutuhkan.',
            'sabukKode.unique'      => 'Kode Sabuk sudah digunakan.',
            'sabukNama.required'    => 'Nama Sabuk dibutuhkan.',
        ];
        return Validator::make($data, [
            'sabukKode' => 'required|unique:sabuk',
            'sabukNama' => 'required|max:60',
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

        $sabuk = new Sabuk();
        $sabuk->sabukKode         = $data['sabukKode'];
        $sabuk->sabukNama         = $data['sabukNama'];

        //melakukan save, jika gagal (return value false) lakukan harakiri
        //error kode 500 - internel server error
        if (! $sabuk->save() )
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
    public function tambahsabuk(Request $request)
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

    public function editsabuk($id)
    {

        $data = Sabuk::find($id);
        // $jurusan = Jurusan::orderBy('jurKode')->get();

        return view('admin.dashboard.sabuk.editsabuk',$data);
                // ->with('listjurusan', $jurusan);
    }

    public function simpanedit($id)
    {
        $input =Input::all();
        $messages = [
            'sabukKode.required'    => 'Kode Sabuk dibutuhkan.',            
            'sabukNama.required'    => 'Nama Sabuk dibutuhkan.',
            
        ];
        

        $validator = Validator::make($input, [
                          'sabukKode' => 'required',
                          'sabukNama' => 'required|max:60',
                      ], $messages);

        if($validator->fails()) {
            # Kembali kehalaman yang sama dengan pesan error
            return Redirect::back()->withErrors($validator)->withInput();
          # Bila validasi sukses
        }

        $editSabuk = Sabuk::find($id);
        $editSabuk->sabukKode = Input::get('sabukKode'); //atau bisa $input['sabukKode']
        $editSabuk->sabukNama = $input['sabukNama'];
        if (! $editSabuk->save())
          App::abort(500);

        return Redirect::action('Sabuk\SabukController@index')
                          ->with('successMessage','Data sabuk "'.Input::get('sabukNama').'" telah berhasil diubah.'); 
    }
}

