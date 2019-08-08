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
            <div class="col-md-12">
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Data Anggota</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                
                
                <?php foreach ($anggota as $itemAnggota); ?>
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-3">
                      <p align="center">
                        <img src="{{ URL::asset('admin/dist/img/user-160-nobody.jpg') }}" alt="User Image">
                        <a class="users-list-name" href="#">{{$itemAnggota->anggotaNama}}</a>
                        <span class="users-list-date">{{$itemAnggota->anggotaid}}</span>
                      </p>
                   
                    </div><!-- /.col -->
                    <div class="col-md-8">
                   
                     <table id="dataKurikulum" class="table table-bordered table-hover">
                      <tbody>
                        <tr>
                          <td>Anggota ID</td>  
                          <td>{{$itemAnggota->anggotaid}}</td>
                        </tr>
                        <tr>
                          <td>Nama</td>  
                          <td>{{$itemAnggota->anggotaNama}}</td>
                        </tr>
                        <tr>
                          <td>NIM</td> 
                          <td>{{$itemAnggota->anggotaNim}}</td>
                        </tr>                        
                        <tr>
                          <td>Angkatan</td> 
                          <td>{{$itemAnggota->anggotaAngkatan}}</td>                        
                        </tr>
                         <tr>
                          <td>Riwayat Penyakit</td> 
                          <td>{{$itemAnggota->anggotRiwayatPenyakit}}</td>                        
                        </tr>
                      </tbody>
                    </table>
                    
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div><!-- /.box-body -->
              </div>
            </div>
          </div><!-- /.row -->

@endsection
@section('script')

    <script src="{{ URL::asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('admin/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script>
      $(function () {

        $('#dataMahasiswa').DataTable({"pageLength": 10});

      });

    </script>

@endsection

