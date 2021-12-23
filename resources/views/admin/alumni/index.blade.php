
@extends('admin.templates.template')

@section('style')

<!-- Leaftlet Js -->
<link rel="stylesheet" href="https://d19vzq90twjlae.cloudfront.net/leaflet/v0.7.7/leaflet.css" />
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style>
    .modal {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        overflow: hidden;
    }
    
    .modal-dialog {
        position: fixed;
        margin: 0;
        width: 100%;
        height: 100%;
        padding: 0;
    }
    
    .modal-content {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        border: 2px solid #3c7dcf;
        border-radius: 0;
        box-shadow: none;
    }
    
    .modal-header {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        height: 50px;
        padding: 10px;
        background: #3c8dbc;
        border: 0;
    }
    
    .modal-title {
        font-weight: 300;
        font-size: 2em;
        color: #fff;
        line-height: 30px;
    }
    
    .modal-body {
        position: absolute;
        top: 50px;
        bottom: 60px;
        width: 100%;
        font-weight: 300;
        overflow: auto;
    }
    
    .modal-footer {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        height: 60px;
        padding: 10px;
        background: #f1f3f5;
    }
</style>
@endsection

@section('body')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Alumni
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Alumni</li>
        </ol>
    </section>
    
    <!-- Main content -->
    <section class="content container-fluid">
        @if (session('status'))
            <div class="alert alert-{!! session('status') !!} alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                {!! session('message') !!}
            </div>
        @endif
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Daftar Alumni</h3>
                <button class="btn btn-sm bg-blue" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah</button>
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="{{ route('alumni.store') }}" method="post" class="form-horizontal">
                                @csrf
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title">Tambah Alumni</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="nama" class="col-sm-2 control-label">Nama</label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="angkatan" class="col-sm-2 control-label">Tahun Angkatan</label>
                                        <div class="col-sm-10">
                                          <input type="number" min="2000" max="3000" class="form-control" id="angkatan" name="angkatan" placeholder="angkatan">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="lokasi_id" class="col-sm-2 control-label">Lokasi</label>
                                        <div class="col-sm-10">
                                            <select min="2000" max="3000" class="form-control" id="lokasi_id" name="lokasi_id">
                                                <option>---pilih lokasi---</option>
                                                @foreach ($lokasi as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tempat_kerja" class="col-sm-2 control-label">Tempat Kerja</label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control" id="tempat_kerja" name="tempat_kerja" placeholder="Tempat Kerja">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Keluar</button>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                                </div>                                
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->    
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 30px">#</th>
                            <th>Nama</th>
                            <th>Tahun Angkatan</th>
                            <th>Lokasi</th>
                            <th>Tempat Kerja</th>
                            <th>Pilihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alumni as $key => $item)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->angkatan }}</td>
                            <td>{{ $item->lokasi->nama }}</td>
                            <td>{{ $item->tempat_kerja}}</td>
                            <td>
                                <button class="btn btn-sm bg-orange" data-toggle="modal" data-target="#modal-default-{{ $key }}"><i class="fa fa-edit"></i> Ubah</button>
                                <form action="{{ route('alumni.delete', $item->id) }}" style="display: inline;" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm bg-red" onclick="return confirm('Yakin ingin menghapus alumni {{ $item->nama }}?')"><i class="fa fa-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <div class="modal fade" id="modal-default-{{ $key }}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('alumni.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('put')
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h4 class="modal-title">Ubah Alumni</h4>
                                        </div>
                                        <div class="modal-body form-horizontal">
                                            <div class="form-group">
                                                <label for="nama" class="col-sm-2 control-label">Nama</label>
                                                <div class="col-sm-10">
                                                  <input type="text" class="form-control" id="nama" name="nama" value="{{ $item->nama }}" placeholder="Nama">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="angkatan" class="col-sm-2 control-label">Tahun Angkatan</label>
                                                <div class="col-sm-10">
                                                  <input type="number" min="2000" max="3000" class="form-control" id="angkatan" name="angkatan" value="{{ $item->angkatan }}" placeholder="angkatan">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="lokasi_id" class="col-sm-2 control-label">Lokasi</label>
                                                <div class="col-sm-10">
                                                    <select min="2000" max="3000" class="form-control" id="lokasi_id" name="lokasi_id">
                                                        <option>---pilih lokasi---</option>
                                                        @foreach ($lokasi as $value)
                                                        <option value="{{ $value->id }}"  {{ $value->id == $item->lokasi_id ? 'selected' : '' }}>{{ $value->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="tempat_kerja" class="col-sm-2 control-label">Tempat Kerja</label>
                                                <div class="col-sm-10">
                                                  <input type="text" class="form-control" id="tempat_kerja" name="tempat_kerja" value="{{ $item->tempat_kerja }}" placeholder="Tempat Kerja">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Keluar</button>
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                                        </div>                                
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Tahun Angkatan</th>
                            <th>Lokasi</th>
                            <th>Tempat Kerja</th>
                            <th>Pilihan</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
        
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@endsection

@section('script')

<!-- Leaftlet JS -->
<script src="https://d3js.org/d3.v3.min.js"></script>
<script src="https://d19vzq90twjlae.cloudfront.net/leaflet/v0.7.7/leaflet.js"></script>
<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
<!-- DataTables -->
<script src="{{ asset('assets') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
        $('#example1').DataTable();
    })
</script>
@endsection