@extends('admin.templates.template')

@section('style')

<!-- Leaftlet Js -->
<link rel="stylesheet" href="https://d19vzq90twjlae.cloudfront.net/leaflet/v0.7.7/leaflet.css" />
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
<link rel="stylesheet" href="{{ asset('assets/dist/css/leafletjs-label.css') }}">

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style>
    .map {
        height: 600px;
        width: 100%;
    }

    .map:hover {
        cursor: crosshair;
    }

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
        background: #6598d9;
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
            Lokasi
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Lokasi</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        @if (session('status'))
        <div class="alert alert-{!! session('status') !!} alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {!! session('message') !!}
        </div>
        @endif
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Daftar lokasi penempatan</h3>
                <button class="btn btn-sm bg-blue" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah</button>
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="{{ route('city.store') }}" method="post">
                                @csrf
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title">Tambah Lokasi</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row justify-content-center">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <input type="hidden" name="latitude" id="latitude">
                                            <input type="hidden" name="longitude" id="longitude">
                                            <div class="form-group">
                                                <label for="city">Kota/Kabupaten</label>
                                                <input type="text" class="form-control" id="city" name="city" placeholder="[Kota/Kabupaten]" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="description">Keterangan</label>
                                                <textarea class="form-control" id="description" name="description" placeholder="[Keterangan]"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="row">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-8">
                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Keluar</button>
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
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
                            <th>KOTA/KABUPATEN</th>
                            <th>KETERANGAN</th>
                            <th>PILIHAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lokasi as $key => $item)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $item->city_name }}</td>
                            <td>{{ $item->description ?? '-' }}</td>
                            <td>
                                UBAH | HAPUS
                                {{-- <button onclick="mapEdit(`{{ $key }}`)" class="btn btn-sm bg-orange" data-toggle="modal" data-target="#modal-default-{{ $key }}"><i class="fa fa-edit"></i> Ubah</button>
                                <form action="{{ route('city.delete', $item->id) }}" style="display: inline;" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm bg-red" onclick="return confirm('Yakin ingin menghapus lokasi {{ $item->city_name }}?')"><i class="fa fa-trash"></i> Hapus</button>
                                </form> --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
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
<script src="{{ asset('assets/dist/js/leafletjs-label.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('assets') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example1').DataTable();
    })
</script>
@endsection
