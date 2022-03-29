
@extends('admin.templates.template')

@section('style')

<!-- Leaftlet Js -->
<link rel="stylesheet" href="https://d19vzq90twjlae.cloudfront.net/leaflet/v0.7.7/leaflet.css" />
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
<link rel="stylesheet" href="{{ asset('assets/dist/css/leafletjs-label.css') }}">

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style>
    .map{
        height: 600px;
        width: 100%;
    }
    .map:hover{
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
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
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
                            <form action="{{ route('lokasi.store') }}" method="post">
                                @csrf
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title">Tambah Lokasi</h4>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="latitude" id="latitude">
                                    <input type="hidden" name="longitude" id="longitude">
                                    <div class="form-group">
                                        <label for="lokasi">Nama Lokasi</label>
                                        <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Masukan Nama Lokasi" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Pilih Lokasi</label>
                                        <div class="map" id="map"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Masukan Keterangan"></textarea>
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
                            <th>Lokasi</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Keterangan</th>
                            <th>Pilihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lokasi as $key => $item)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->latitude }}</td>
                            <td>{{ $item->longitude }}</td>
                            <td>{{ $item->keterangan ?? '-'}}</td>
                            <td>
                                <button onclick="mapEdit(`{{ $item->latitude }}`, `{{ $item->longitude }}`, `{{ $key }}`)" class="btn btn-sm bg-orange" data-toggle="modal" data-target="#modal-default-{{ $key }}"><i class="fa fa-edit"></i> Ubah</button>
                                @if(count($item->alumni) <= 0)
                                <form action="{{ route('lokasi.delete', $item->id) }}" style="display: inline;" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm bg-red" onclick="return confirm('Yakin ingin menghapus lokasi {{ $item->nama }}?')"><i class="fa fa-trash"></i> Hapus</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        <div class="modal fade" id="modal-default-{{ $key }}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('lokasi.update', $item->id) }}" method="post">
                                        @csrf
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h4 class="modal-title">Ubah Lokasi</h4>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="latitude" id="latitude-{{ $key }}" value="{{ $item->latitude }}">
                                            <input type="hidden" name="longitude" id="longitude-{{ $key }}" value="{{ $item->longitude }}">
                                            <div class="form-group">
                                                <label for="lokasi">Nama Lokasi</label>
                                                <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ $item->nama }}" placeholder="Masukan Nama Lokasi" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Pilih Lokasi</label>
                                                <div class="map" id="map-edit-{{ $key }}"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="keterangan">Keterangan</label>
                                                <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Masukan Keterangan">{{ $item->keterangan }}</textarea>
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
                            <th>Lokasi</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Keterangan</th>
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
<script src="{{ asset('assets/dist/js/leafletjs-label.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('assets') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
        $('#example1').DataTable();
        mapTambah()
    })

    function mapEdit(lat, lng, key)
    {
        var base_layer, map, mbAttr, mbUrl;
        
        mbAttr = 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community';
        
        mbUrl = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
        
        base_layer = L.tileLayer(mbUrl, {
            id: 'mapbox.streets',
            attribution: mbAttr,
            minZoom: 6,
        });
        
        map = L.map('map-edit-' + key, {
            center: [30, 0],
            zoom: 7,
            layers: [base_layer],
        }).setView([lat, lng]);
        map.addControl(new L.Control.Fullscreen())
        L.marker([-3.3163733, 126.5720491],{opacity:0.01}).bindLabel('KAB. BURU', {noHide: true, offset: [-42,-40], }).addTo(map);
        L.marker([-3.600275,126.6161067],{opacity:0.01}).bindLabel('KAB. BURU SELATAN', {noHide: true, offset: [-62,-10], }).addTo(map);
        L.marker([-6.161061,134.4254625],{opacity:0.01}).bindLabel('KAB. KEP. ARU', {noHide: true, offset: [-52,-10], }).addTo(map);
        L.marker([-7.4597688,131.4123121],{opacity:0.01}).bindLabel('KAB. KEP. TANIMBAR', {noHide: true, offset: [-72,-10], }).addTo(map);
        L.marker([-8.1439268,127.7812751],{opacity:0.01}).bindLabel('KAB. MBD', {noHide: true, offset: [-42,-10], }).addTo(map);
        L.marker([-3.3054009,128.9569751],{opacity:0.01}).bindLabel('KAB. MALUKU TENGAH', {noHide: true, offset: [-42,-10], }).addTo(map);
        L.marker([-5.6630139,132.7284609],{opacity:0.01}).bindLabel('KAB. MALUKU TENGGARA', {noHide: true, offset: [-62,-10], }).addTo(map);
        L.marker([-3.0591965,128.1815531],{opacity:0.01}).bindLabel('KAB. SBB', {noHide: true, offset: [-62,-10], }).addTo(map);
        L.marker([-3.1096585,130.4897502],{opacity:0.01}).bindLabel('KAB. SBT', {noHide: true, offset: [-22,-5], }).addTo(map);
        L.marker([-3.6933882,128.1810017],{opacity:0.01}).bindLabel('KOTA AMBON', {noHide: true, offset: [-22,-5], }).addTo(map);
        L.marker([-5.6318696,132.7455933],{opacity:0.01}).bindLabel('KOTA TUAL', {noHide: true, offset: [-22,-5], }).addTo(map);
        var marker;
        marker = L.marker({
            lat:lat, lng:lng
        }).addTo(map);
        map.on('click', function(e){
            if (marker != undefined) {
                map.removeLayer(marker);
            };
            marker = L.marker(e.latlng).addTo(map);
            let lat = e.latlng.lat;
            let lng = e.latlng.lng;
            $('#latitude-'+ key).val(lat);
            $('#longitude-'+ key).val(lng);
        })
        $('.modal').on('show.bs.modal', function(){      
            
            
            setTimeout(function(){ map.invalidateSize()}, 400);
        });
    }
    function mapTambah()
    {
        var base_layer, map, mbAttr, mbUrl;
        
        mbAttr = 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community';
        
        mbUrl = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
        
        base_layer = L.tileLayer(mbUrl, {
            id: 'mapbox.streets',
            attribution: mbAttr,
            minZoom: 6,
        });
        
        map = L.map('map', {
            center: [30, 0],
            zoom: 7,
            layers: [base_layer],
        }).setView([-6.0251815, 131.1685883]);
        map.addControl(new L.Control.Fullscreen())
        L.marker([-3.3163733, 126.5720491],{opacity:0.01}).bindLabel('KAB. BURU', {noHide: true, offset: [-42,-40], }).addTo(map);
        L.marker([-3.600275,126.6161067],{opacity:0.01}).bindLabel('KAB. BURU SELATAN', {noHide: true, offset: [-62,-10], }).addTo(map);
        L.marker([-6.161061,134.4254625],{opacity:0.01}).bindLabel('KAB. KEP. ARU', {noHide: true, offset: [-52,-10], }).addTo(map);
        L.marker([-7.4597688,131.4123121],{opacity:0.01}).bindLabel('KAB. KEP. TANIMBAR', {noHide: true, offset: [-72,-10], }).addTo(map);
        L.marker([-8.1439268,127.7812751],{opacity:0.01}).bindLabel('KAB. MBD', {noHide: true, offset: [-42,-10], }).addTo(map);
        L.marker([-3.3054009,128.9569751],{opacity:0.01}).bindLabel('KAB. MALUKU TENGAH', {noHide: true, offset: [-42,-10], }).addTo(map);
        L.marker([-5.6630139,132.7284609],{opacity:0.01}).bindLabel('KAB. MALUKU TENGGARA', {noHide: true, offset: [-62,-10], }).addTo(map);
        L.marker([-3.0591965,128.1815531],{opacity:0.01}).bindLabel('KAB. SBB', {noHide: true, offset: [-62,-10], }).addTo(map);
        L.marker([-3.1096585,130.4897502],{opacity:0.01}).bindLabel('KAB. SBT', {noHide: true, offset: [-22,-5], }).addTo(map);
        L.marker([-3.6933882,128.1810017],{opacity:0.01}).bindLabel('KOTA AMBON', {noHide: true, offset: [-22,-5], }).addTo(map);
        L.marker([-5.6318696,132.7455933],{opacity:0.01}).bindLabel('KOTA TUAL', {noHide: true, offset: [-22,-5], }).addTo(map);
        var marker;
        map.on('click', function(e){
            if (marker != undefined) {
                map.removeLayer(marker);
            };
            marker = L.marker(e.latlng).addTo(map);
            let lat = e.latlng.lat;
            let lng = e.latlng.lng;
            $('#latitude').val(lat);
            $('#longitude').val(lng);
        })
        $('#modal-default').on('show.bs.modal', function(){      
            
            
            setTimeout(function(){ map.invalidateSize()}, 400);
        });
    }
</script>
@endsection