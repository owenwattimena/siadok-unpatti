@extends('admin.templates.template')

@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- Leaflet -->
{{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script> --}}
{{-- <link rel="stylesheet" href="https://d19vzq90twjlae.cloudfront.net/leaflet/v0.7.7/leaflet.css" /> --}}
@include('assets.css.leaflet')
<style>
    #map {
        height: 650px;
        width: 100%;
    }

    .leaflet-popup-content-wrapper {
        border-radius: 0;
    }

    .leaflet-popup-content {
        margin: 0;
    }

    .box-widget {
        width: 300px;
    }

    .leaflet-popup-content .widget-user-2 {
        margin-bottom: 0px !important;
    }

    .widget-user-desc,
    .widget-user-username {
        margin-left: 0 !important;
    }

</style>
@endsection

@section('body')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Selamat datang, {{ auth()->user()->name }}</br>
            <small>SISTEM INFORMASI ALUMNI KEDOKTERAN UNIVERSITAS PATTIMURA</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-map"></i> Map</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-2">
                @if(app('request')->input('entry_year') != null)                    
                    <a href="{{ route('dashboard') }}" class="btn btn-sm bg-blue" style="width: 100%">Semua Data</a>
                @endisset
                <div class="box widget-user-2">
                    <div class="box-heade text-center">
                        <h5><strong>TAHUN MASUK</strong></h5>
                    </div>
                    <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                            @foreach ($entryYear as $key => $value)
                            <li class="{{ app('request')->input('entry_year') == $key  ? 'active' : '' }}"><a href="{{ route('dashboard-filter', ['entry_year'=> $key]) }}">{{ empty($key) ? '-' : $key }} <span class="pull-right badge bg-green">{{ count($value) }}</span></a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
            <div class="col-md-10">


                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_map" data-toggle="tab">PETA</a></li>
                        <li><a href="#tab_list" data-toggle="tab">DAFTAR</a></li>
                        
                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane active" id="tab_map">
                            <div id="map" class="map">
                                <div class="modal fade" id="modal-dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Default Modal</h4>
                                                <p class="modal-description">Ambon</p>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-striped">
                                                    <tr>
                                                        <th style="width: 10px">#</th>
                                                        <th>NAMA</th>
                                                        <th>TAHUN LULUS</th>
                                                    </tr>
                                                    <tbody id="tbody"></tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->
                            </div>
                        </div>

                        <div class="tab-pane" id="tab_list">
                            <div class="table-responsive">

                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>NIM</th>
                                            <th>NAMA</th>
                                            <th>MASUK</th>
                                            <th>LULUS</th>
                                            <th>TEMPAT KERJA</th>
                                            <th>KOTA/KAB</th>
                                            {{-- <th>PILIHAN</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($alumni as $key => $item)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $item->nim }}</td>
                                            <td>{{ $item->nama_lengkap }}</td>
                                            <td>{{ $item->tahun_masuk_s1 ?? '-' }}</td>
                                            <td>{{ $item->tahun_lulus_s1 ?? '-'}}</td>
                                            <td>{{ $item->jalan ?? '-'}}</td>
                                            <td>{{ $item->kabupaten_kota ?? '-'}}</td>
                                            {{-- <td>
                                                <button class="btn btn-sm bg-blue" onclick="return detailMode({{ $item->nim }})" data-toggle="modal" data-target="#modal-default"><i class="fa fa-list"></i> Detail</button>
                                            </td> --}}
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
</div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('script')
<script src="https://d3js.org/d3.v3.min.js"></script>
<!-- DataTables -->
<script src="{{ asset('assets') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.js" integrity="sha512-e+JSf1UWuoLdiGeXXi5byQqIN7ojQLLgvC+aV0w9rnKNwNDBAz99sCgS20+PjT/r+yitmU7kpGVZJQDDgevhoA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
{{-- <script src="https://d19vzq90twjlae.cloudfront.net/leaflet/v0.7.7/leaflet.js"></script> --}}
@include('assets.js.leaflet')
<script src="{{ asset('assets/app-js/markerKabMaluku.js') }}"></script>

<script>
    $('#example1').DataTable();
    (function() {

        var icon = L.icon({
            iconUrl: `{{ asset('assets/dist/img/pin-star.png') }}`,

            iconSize: [20, 20], // size of the icon
            // shadowSize:   [50, 64], // size of the shadow
            // iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
            // shadowAnchor: [4, 62],  // the same for the shadow
            // popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
        });

        var base_layer, map, mbAttr, mbUrl;

        mbAttr = 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community';

        // mbUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
        mbUrl = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';

        base_layer = L.tileLayer(mbUrl, {
            id: 'mapbox.streets'
            , attribution: mbAttr
            , minZoom: 6
        , });

        map = L.map('map', {
            center: [30, 0]
            , zoom: 7
            , layers: [base_layer]
        , }).setView([-6.0251815, 131.1685883]);
        markerKabMaluku(L, map);
        
        map.addControl(new L.Control.Fullscreen())

        for (var key in lokasi) {
            var data = lokasi[key];
            let latitude = data.latitude;
            let longitude = data.longitude;
            // map.panBy([0, 3500]);
            var marker = L.marker([latitude, longitude], {
                    icon: icon,
                    zIndexOffset: 900
                })
                .bindPopup(card(data.workplace_name,data.angkatan, data.city_name))
                .addTo(map);
        }

    }).call(this);

    function card(tempatKerja, angkatan, kota) {
        var divBoxWidget = document.createElement('div')
        var divWidgetUserHeader = document.createElement('div')
        var divBoxFooter = document.createElement('div')
        var ulNav = document.createElement('ul')
        divBoxWidget.className = 'box box-widget widget-user-2'
        divWidgetUserHeader.className = 'widget-user-header bg-yellow'
        divBoxFooter.className = 'box-footer no-padding'
        ulNav.className = 'nav nav-stacked'

        divWidgetUserHeader.innerHTML = `<h3 class="widget-user-username">${tempatKerja}</h3>`
        divWidgetUserHeader.innerHTML += `<p class="no-margin">${kota}</p>`
        divBoxWidget.appendChild(divWidgetUserHeader)
        divBoxWidget.appendChild(divBoxFooter)
        divBoxFooter.appendChild(ulNav)
        if(angkatan != undefined){
            if (Object.keys(angkatan).length > 0) {
                for (var key in angkatan) {
                    if (Object.hasOwnProperty.call(angkatan, key)) {
                        var data = angkatan[key];
                        var li = document.createElement('li')
                        li.dataset.kota = kota
                        li.dataset.lokasi = tempatKerja
                        li.dataset.angkatan = data.entry_year;
                        li.dataset.alumni = JSON.stringify(data.alumnus)
                        li.dataset.toggle = 'modal'
                        li.dataset.target = '#modal-dialog'
                        li.innerHTML = `<a href="#">${(data.entry_year == '' ? '-' : data.entry_year)} <span class="pull-right badge bg-blue">${data.alumnus.length} Orang</span></a>`;
                        // card += el;
                        li.onclick = function() {
                            showDetail(this.dataset.lokasi, this.dataset.alumni, this.dataset.angkatan, this.dataset.kota)
                        }
                        ulNav.appendChild(li)
                    }
                }
            } else {
                var li = document.createElement('li')
                li.style.textAlign = 'center'
                li.style.padding = "50px 15px"
                li.innerHTML = `Oopss...Belum ada alumni di ${tempatKerja}`;
                ulNav.appendChild(li)
            }
        }else{
            var li = document.createElement('li')
                li.style.textAlign = 'center'
                li.style.padding = "50px 15px"
                li.innerHTML = `Oopss...Belum ada alumni di ${tempatKerja}`;
                ulNav.appendChild(li)
        }
        return divBoxWidget
    }

    function _click(e) {
        console.log(e);
    }


    function showDetail(tempatKerja, alumni, angkatan, kota) {
        var tbody = '';
        var alumni = eval(alumni);
        console.log(alumni);
        for (key in alumni) {
            if (Object.hasOwnProperty.call(alumni, key)) {
                const element = alumni[key];
                tbody +=
                    `<tr>
                    <td>${++key}</td>
                    <td>${element.name}</td>
                    <td>${(element.graduation_year == null ? '-' : element.graduation_year)}</td>
                </tr>`;
            }
        }
        $('#tbody').html(tbody);
        $('.modal-title').text(tempatKerja + ' - Angkatan ' + angkatan);
        $('.modal-description').text(kota);
    }

</script>
@endsection
