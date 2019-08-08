@extends('admin.layout.master')
@section('breadcrump')
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
            <li class="active">Kejuaraan</li>
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
                    <h3 class="box-title">Daftar Kejuaraan <a class="btn btn-success btn-flat btn-sm" id="tambahKejuaraan" title="Tambah"><i class="fa fa-plus"></i></a></h3>
                  </div><!-- /.box-header -->
                  <div class="box-body no-padding">
                    <table class="table table-condensed">
                      <tbody><tr>
                        <th style="width: 50px; text-align: center;">Kode </th>
                        <th>Nama Kejuaraan</th>
                        <th>Deskrpsi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                      <?php foreach ($kejuaraan as $datakejuaraan):  ?>
                      <tr id="prodi-list" name="prodi-list">
                          <td style="text-align: center;">{{ $datakejuaraan->kejKode}}</td>
                          <td>{{ $datakejuaraan->kejNama}}</td>
                          <td>{{ $datakejuaraan->kejDeskripsi}}</td>
                          <td>   
                          @if($datakejuaraan->kejStatus==0) 
                               <a href="{{{ URL::to('kejuaraan/'.$datakejuaraan->kejKode.'/aktif') }}}">
                              <span class="label label-warning"><i class="fa fa-check"> Aktifkan! </i></span>
                              </a>
                            @else
                               <span class="label label-success"><i class="fa fa-check-circle"> Selesai </i></span>
                              </a>
    
                            @endif
                            </td>
                          <td>
                            <a href="{{{ URL::to('kejuaraan/'.$datakejuaraan->kejKode.'/edit') }}}">
                              <span class="label label-warning"><i class="fa fa-edit"> Edit </i></span>
                              </a> 
                              <a href="{{{ action('Kejuaraan\KejuaraanController@hapus',[$datakejuaraan->kejKode]) }}}" title="hapus"   onclick="return confirm('Apakah anda yakin akan menghapus Kejuaraan {{{$datakejuaraan->kejNama }}}?')">
                              <span class="label label-danger"><i class="fa fa-trash"> Delete </i></span>
                              </a>                       
                          </td>                         
                      </tr>
                      <?php endforeach  ?>  
                      </tbody>
                    </table>
                  </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
          </div><!-- /.row (main row) -->

          <!-- Modal -->
          <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                          <h4 class="modal-title" id="myModalLabel">Infor Kejuaraan - Tambah</h4>
                      </div>
                      <div class="modal-body">
           
                          <form id="formProdi" class="form-horizontal" role="form" method="POST" action="{{ url('/kejuaraan/tambah') }}">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
           
                              <div class="form-group">
                                  <label class="col-md-4 control-label">Kode</label>
                                  <div class="col-md-6">
                                      <input type="text" class="form-control" name="kejKode">
                                      <small class="help-block"></small>
                                  </div>
                              </div>
           
                              <div class="form-group">
                                  <label class="col-md-4 control-label">Nama Kejuaraan </label>
                                  <div class="col-md-6">
                                      <input type="text" class="form-control" name="kejNama">
                                      <small class="help-block"></small>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-4 control-label">Batas Penerimaan </label>
                                  <div class="col-md-6">
                                      <input type="date" class="form-control" name="kejTglBatas">
                                      <small class="help-block"></small>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-4 control-label">Dekripsi </label>
                                  <div class="col-md-6">
                                      <textarea type="text" class="form-control" name="kejDeskripsi"></textarea>
                                      <small class="help-block"></small>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <div class="col-md-6 col-md-offset-4">
                                      <button type="submit" class="btn btn-primary" id="button-reg">
                                          Simpan
                                      </button>
                                  </div>
                              </div>
                          </form>                       
           
                      </div>
                  </div>
              </div>
          </div>
          <!--end of Modal -->            
                 

@endsection
@section('script')
    <script>
 
    $(function(){


        $('#tambahKejuaraan').click(function(){
            $('input+small').text('');
            $('input').parent().removeClass('has-error');
            $('select').parent().removeClass('has-error');

            $('#myModal').modal('show');
            //console.log('test');
            return false;
        });

       
        $(document).on('submit', '#formProdi', function(e) {  
            e.preventDefault();
             
            $('input+small').text('');
            $('input').parent().removeClass('has-error');           
             
            $.ajax({
                method: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json"
            })
            .done(function(data) {
                console.log(data);
                
                $('.alert-success').removeClass('hidden');
                $('#myModal').modal('hide');
                
                window.location.href='/kejuaraan'; 
            })
            .fail(function(data) {
                console.log(data.responeJSON);
                $.each(data.responseJSON, function (key, value) {
                    var input = '#formProdi input[name=' + key + ']';
                    
                    $(input + '+small').text(value);
                    $(input).parent().addClass('has-error');
                });
            });
        });
 
    })
 
    </script>
@endsection

