@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
            <li class="active">Anggota</li>
          </ol>
@stop
@section('content')
<div class="row">
            <div class="col-md-6">
                <div class="box-body flash-message" data-uk-alert>
                    <a href="" class="uk-alert-close uk-close"></a>
                    <p>{{  isset($successMessage) ? $successMessage : '' }}</p>
                     @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="box box-primary">
                  <div class="box-header">
                    <h3 class="box-title">Data Anggota - Edit</h3>
                  </div><!-- /.box-header -->
                  <div class="box-body no-padding">
                      <form id="formAnggotaTambah" class="form-horizontal" role="form" method="POST" action="{{ url('/anggota/'.$anggotaid.'/simpanedit') }}">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="_method" value="PUT">
                      <input type="hidden" name="id" value="{{$id}}" >

                      <div class="form-group">
                          <label class="col-md-4 control-label"> ID anggota</label>
                          <div class="col-md-6 @if ($errors->has('anggotaNim')) has-error @endif">
                              <input type="text" class="form-control" name="anggotaNim" value="{{$anggotaid}}" disabled="true">
                              <small class="help-block"></small>
                          </div> 
                      </div>

                      <div class="form-group">
                          <label class="col-md-4 control-label"> Nim</label>
                          <div class="col-md-6 @if ($errors->has('anggotaNim')) has-error @endif">
                              <input type="text" class="form-control" name="anggotaNim" value="{{$anggotaNim}}">
                              <small class="help-block"></small>
                          </div> 
                      </div>
   
                      <div class="form-group">
                          <label class="col-md-4 control-label"> Nama</label>
                          <div class="col-md-6  @if ($errors->has('anggotaNama')) has-error @endif">
                              <input type="text" class="form-control"  name="anggotaNama" value="{{$anggotaNama}}">
                              <small class="help-block"></small>
                              <!-- @if ($errors->has('anggotaNama')) <small class="help-block">{{ $errors->first('anggotaNama') }}</small> @endif -->
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-4 control-label">RiwayatPenyakit </label>
                          <div class="col-md-6  @if ($errors->has('anggotaRiwayatPenyakit')) has-error @endif">
                              <input type="text" class="form-control"  name="anggotaRiwayatPenyakit" value="{{$anggotaRiwayatPenyakit}}">
                              <small class="help-block"></small>
                              <!-- @if ($errors->has('anggotaRiwayatPenyakit')) <small class="help-block">{{ $errors->first('anggotaRiwayatPenyakit') }}</small> @endif -->
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-4 control-label">TglLahir </label>
                          <div class="col-md-6  @if ($errors->has('anggotaTglLahir')) has-error @endif">
                              <input type="date" class="form-control" name="anggotaTglLahir" value="{{$anggotaTglLahir}}">
                              <small class="help-block"></small>
                              <!-- @if ($errors->has('anggotaTglLahir')) <small class="help-block">{{ $errors->first('anggotaTglLahir') }}</small> @endif -->
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-4 control-label">No Hp </label>
                          <div class="col-md-6  @if ($errors->has('anggotaHp')) has-error @endif">
                              <input type="text" class="form-control"  name="anggotaHp" value="{{$anggotaHp}}">
                              <small class="help-block"></small>
                              <!-- @if ($errors->has('anggotaHp')) <small class="help-block">{{ $errors->first('anggotaHp') }}</small> @endif -->
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-4 control-label">anggotaAngkatan </label>
                          <div class="col-md-6  @if ($errors->has('anggotaAngkatan')) has-error @endif">
                              <input type="text" class="form-control" name="anggotaAngkatan" value="{{$anggotaAngkatan}}">
                              <small class="help-block"></small>
                              <!-- @if ($errors->has('anggotaAngkatan')) <small class="help-block">{{ $errors->first('anggotaAngkatan') }}</small> @endif -->
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-4 control-label">anggotaJK </label>
                          <div class="col-md-6  @if ($errors->has('anggotaJK')) has-error @endif">
                              <input type="text" class="form-control" name="anggotaJK" value="{{$anggotaJK}}">
                              <small class="help-block"></small>
                              <!-- @if ($errors->has('anggotaJK')) <small class="help-block">{{ $errors->first('anggotaJK') }}</small> @endif -->
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-md-4 control-label">anggotaJur </label>
                          <div class="col-md-6  @if ($errors->has('anggotaJur')) has-error @endif">
                              <input type="text" class="form-control" name="anggotaJur"  value="{{$anggotaJur}}">
                              <small class="help-block"></small>
                              <!-- @if ($errors->has('anggotaJur')) <small class="help-block">{{ $errors->first('anggotaJur') }}</small> @endif -->
                          </div>
                      </div>
                      
                      <div class="form-group">
                                  <label class="col-md-4 control-label">Sabuk</label>
                                  <div class="col-md-6 has-error">
                                      <select class="form-control" name="anggotaSabuk">
                                        @foreach ($listSabuk as $itemsabuk)
                                            <option @if ($itemsabuk->sabukKode == $anggotaSabuk) selected @endif}}" value="{{$itemsabuk->sabukKode}}">{{$itemsabuk->sabukNama}}</option>
                                        @endforeach
                                      </select>
                                      
                                      <small class="help-block"></small>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-4 control-label">anggotaCabang</label>
                                  <div class="col-md-6 has-error">
                                      <select class="form-control" name="anggotaCabang">
                                         
                                        @foreach ($listCabang as $itemcabang)
                                            <option @if ($itemcabang->cabangKode == $anggotaCabang) selected @endif}}" value="{{$itemcabang->cabangKode}}">{{$itemcabang->cabangNama}}</option>
                                        @endforeach

                                      </select>
                                      
                                      <small class="help-block"></small>
                                  </div>
                              </div>
                                   
   
                      <div class="form-group">
                          <div class="col-md-6 col-md-offset-4">
                              <button type="submit" class="btn btn-primary" id="button-reg">
                                  Simpan
                              </button>

                              
                              <a href="{{{ action('Anggota\AnggotaController@index') }}}" title="Cancel">
                              <button type="button" class="btn btn-default" id="button-reg">
                                  Cancel
                              </button>
                              </a>  
                          </div>
                      </div>
                      </form>   
                  </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
          </div><!-- /.row (main row) -->
            
@endsection

