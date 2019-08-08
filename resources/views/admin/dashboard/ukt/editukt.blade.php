@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
            <li class="active">Jurusan</li>
          </ol>
@stop
@section('content')
          <div class="row">
            <div class="col-md-6">
                <div class="uk-alert uk-alert-success" data-uk-alert>
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
                    <h3 class="box-title">Info UKT - Edit</h3>
                  </div><!-- /.box-header -->
                  <div class="box-body no-padding">
                      <form id="formProdiEdit" class="form-horizontal" role="form" method="POST" action="{{ url('/ukt/'.$uktKode.'/simpanedit') }}">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="_method" value="PUT">
                      <input type="hidden" name="uktKode" value="{{$uktKode}}" >
                      
                      <div class="form-group">
                          <label class="col-md-4 control-label">Kode</label>
                          <div class="col-md-6">
                              <input type="text" class="form-control" name="uktKodeShow" value="{{$uktKode}}" disabled="true">
                              <small class="help-block"></small>
                          </div>
                      </div>
   
                      <div class="form-group">
                          <label class="col-md-4 control-label">Nama Kejuaraan</label>
                          <div class="col-md-6">
                              <input type="text" class="form-control" name="uktNama" value="{{$uktNama}}">
                              <small class="help-block"></small>
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-4 control-label">Periode</label>
                          <div class="col-md-6">
                              <input type="text" class="form-control" name="uktPeriode" value="{{$uktPeriode}}">
                              <small class="help-block"></small>
                          </div>
                      </div>



                      <div class="form-group">
                          <label class="col-md-4 control-label">Tanggal batas</label>
                          <div class="col-md-6">
                              <input type="date" class="form-control" name="uktTglBatas" value="{{$uktTglBatas}}">
                              <small class="help-block"></small>
                          </div>
                      </div>

                      <div class="form-group">
                          <label class="col-md-4 control-label">Deskripsi</label>
                          <div class="col-md-6">
                              <textarea class="form-control" name="uktDeskripsi">
                                 {{$uktDeskripsi}}
                              </textarea>
                              <small class="help-block"></small>
                          </div>
                      </div>

                      <div class="form-group">
                          <div class="col-md-6 col-md-offset-4">
                              <button type="submit" class="btn btn-primary" id="button-reg">
                                  Simpan
                              </button>
                              <a href="{{{ action('Prodi\ProdiController@index') }}}" title="Cancel">
                              <span class="btn btn-default"><i class="fa fa-back"> Cancel </i></span>
                              </a>  
                          </div>
                      </div>
                      </form>   
                  </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
          </div><!-- /.row (main row) -->

          
                 

@endsection


