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
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Anggota <a href="{{{ action('Anggota\AnggotaController@tambah') }}}" class="btn btn-success btn-flat btn-sm" data-toggle="modal" title="Tambah"><i class="fa fa-plus"></i></a></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="dataAnggota" class="table table-bordered table-hover">
                    <thead>
                      <tr>                        
                        <th>ID Anggota</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Prodi</th>                    
                        <th>Rincian</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php foreach ($anggota as $itemAnggota):  ?>
                      <tr>
                        <td>{{$itemAnggota->anggotaid}}</td>
                        <td>{{$itemAnggota->anggotaNama}}</td>
                        <td>{{$itemAnggota->anggotaNim}}</td>
                        <td>{{$itemAnggota->anggotaJur}}</td>                       
                        <td><a href="{{{ URL::to('anggota/'.$itemAnggota->anggotaid.'/detail') }}}">
                              <span class="label label-info"><i class="fa fa-list"> Detail </i></span>
                              </a>
                        </td>
                        <td><a href="{{{ URL::to('anggota/'.$itemAnggota->anggotaid.'/edit') }}}">
                              <span class="label label-warning"><i class="fa fa-edit"> Edit </i></span>
                              </a> <a href="{{{ action('Anggota\AnggotaController@hapus',[$itemAnggota->anggotaid]) }}}" title="hapus"   onclick="return confirm('Apakah anda yakin akan menghapus anggota bernama {{{($itemAnggota->anggotaNama)}}}?')">
                              <span class="label label-danger"><i class="fa fa-trash"> Delete </i></span>
                              </a>                          
                          </td>  
                      </tr>
                      <?php endforeach  ?> 
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div><!-- /.col -->
          </div><!-- /.row -->

@endsection
@section('script')

    <script src="{{ URL::asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script>
      $(function () {

        $('#dataAnggota').DataTable({"pageLength": 10});

      });

    </script>

@endsection

