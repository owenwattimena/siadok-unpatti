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
    #dashboard-map {
        height: 650px;
        width: 100%;
    }
    #map {
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
    height: 70px;
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
    top: 70px;
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
                    <div class="text-center">
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
                        <li class="active"><a href="#tab_list" data-toggle="tab">DAFTAR</a></li>
                        <li><a href="#tab_map" data-toggle="tab">PETA</a></li>
                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane" id="tab_map">
                            <div id="dashboard-map" class="map">

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
                                {{-- Detail Modal --}}
                                <div class="modal fade" id="modal-dialog-detail">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Nama Alumni</h4>
                                                <p class="modal-description">NIM</p>
                                            </div>
                                            <div class="modal-body">
                                                @include('admin.alumni.component.form')
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

                        <div class="tab-pane active" id="tab_list">

                            {{-- Detail Modal --}}
                            <div class="modal fade" id="modal-dialog-daftar">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                                <div class="container">
                                                    <h4 class="modal-title">Nama Alumni</h4>
                                                    <p class="modal-description">NIM</p>
                                                </div>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container">
                                                @include('admin.alumni.component.detail_form')
                                            </div>
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
                                            <td><a href="" data-toggle="modal" onclick="return detailMode({{ $item->nim }}, '#modal-dialog-daftar')" data-target="#modal-dialog-daftar" >{{ $item->nama_lengkap }}</a></td>
                                            <td>{{ $item->tahun_masuk_s1 ?? '-' }}</td>
                                            <td>{{ $item->tahun_lulus_s1 ?? '-'}}</td>
                                            <td>{{ $item->tempat_kerja ?? '-'}}</td>
                                            <td>{{ $item->kota_kabupaten ?? '-'}}</td>
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
<script src="{{ asset('assets/app-js/appAjax.js') }}"></script>
<script src="{{ asset('assets/app-js/markerKabMaluku.js') }}"></script>

<script>
    var  map, detailMap, detailMap2, detailMarker, detailMarker2;
    $('#example1').DataTable();
    (function() {
        initMap();
        initDetailMap();
        initDetailMap2();
    }).call(this);

    function initMap()
    {
        var base_layer, mbAttr, mbUrl;
        var icon = L.icon({
            iconUrl: `{{ asset('assets/dist/img/pin-star.png') }}`,

            iconSize: [20, 20], // size of the icon
            // shadowSize:   [50, 64], // size of the shadow
            // iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
            // shadowAnchor: [4, 62],  // the same for the shadow
            // popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
        });


        mbAttr = 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community';

        // mbUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
        mbUrl = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';

        base_layer = L.tileLayer(mbUrl, {
            id: 'mapbox.streets'
            , attribution: mbAttr
            , minZoom: 6
        , });

        map = L.map('dashboard-map', {
            center: [30, 0]
            , zoom: 7
            , layers: [base_layer]
        , }).setView([-6.0251815, 131.1685883]);
        markerKabMaluku(L, map);
        
        map.addControl(new L.Control.Fullscreen())
        var lokasi = @json($lokasi);
        for (var key in lokasi) {
            var data = lokasi[key];
            // console.log(data.angkatan);
            let latitude = parseFloat(data.latitude);
            let longitude = parseFloat(data.longitude);
            if( !isNaN(latitude) && !isNaN(longitude)){
                var marker = L.marker([latitude, longitude], {
                        icon: icon,
                        zIndexOffset: 900
                    })
                    .bindPopup(card(data.tempat_kerja,data.angkatan, data.kota_kabupaten))
                    .addTo(map);
            }
        }

        $('a[href="#tab_map"]').click(function (e) {
            console.log('owen')
            setTimeout(function() {
                map.invalidateSize()
            }, 400);
        })
    }   

    function initDetailMap() {
        // disableForm(false);
        var base_layer, mbAttr, mbUrl;

        mbAttr = 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community';

        mbUrl = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';

        base_layer = L.tileLayer(mbUrl, {
            id: 'mapbox.streets'
            , attribution: mbAttr
            , minZoom: 6
        , });

        detailMap = L.map('detail_map', {
            center: [30, 0]
            , zoom: 7
            , layers: [base_layer]
        , }).setView([-6.0251815, 131.1685883]);
        detailMap.addControl(new L.Control.Fullscreen())
        markerKabMaluku(L, detailMap);
        /// OnClick on detailMap set value to latitude and longitude
        detailMap.on('click', function(e) {
            if (mapDisable) {
                return;
            }
            if (detailMarker != undefined) {
                detailMap.removeLayer(detailMarker);
            };
            detailMarker = L.marker(e.latlng).addTo(detailMap);
            let lat = e.latlng.lat;
            let lng = e.latlng.lng;
            $('#latitude').val(lat);
            $('#longitude').val(lng);
        });
        /// fix detailMap view on modal dialog
        $('#modal-dialog-daftar').on('show.bs.modal', function() {
            setTimeout(function() {
                detailMap.invalidateSize()
            }, 400);
        });

        // set latitude from latitude form filed to detailMap
        $('#modal-dialog-daftar #latitude').change(function(e) {
            let lat = $('#modal-dialog-daftar #latitude').val();
            let lng = $('#modal-dialog-daftar #longitude').val();
            if (detailMarker != undefined ) {
                detailMap.removeLayer(detailMarker);
            };
            detailMarker = L.marker([lat, lng]).addTo(detailMap);
            detailMap.setView([lat, lng], 16);
        });
        // set longitude from longitude form filed to detailMap
        $('#modal-dialog-daftar #longitude').change(function(e) {
            let lat = $('#modal-dialog-daftar #latitude').val();
            let lng = $('#modal-dialog-daftar #longitude').val();
            if (detailMarker != undefined) {
                detailMap.removeLayer(detailMarker);
            };
            detailMarker = L.marker([lat, lng]).addTo(detailMap);
            detailMap.setView([lat, lng], 16);
        });
    } 
    function initDetailMap2() {
        // disableForm(false);
        var base_layer, mbAttr, mbUrl;

        mbAttr = 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community';

        mbUrl = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';

        base_layer = L.tileLayer(mbUrl, {
            id: 'mapbox.streets'
            , attribution: mbAttr
            , minZoom: 6
        , });

        detailMap2 = L.map('map', {
            center: [30, 0]
            , zoom: 7
            , layers: [base_layer]
        , }).setView([-6.0251815, 131.1685883]);
        detailMap2.addControl(new L.Control.Fullscreen())
        markerKabMaluku(L, detailMap2);
        /// OnClick on detailMap2 set value to latitude and longitude
        detailMap2.on('click', function(e) {
            if (mapDisable) {
                return;
            }
            if (detailMarker2 != undefined) {
                detailMap2.removeLayer(detailMarker2);
            };
            detailMarker2 = L.marker(e.latlng).addTo(detailMap2);
            let lat = e.latlng.lat;
            let lng = e.latlng.lng;
            $('#latitude').val(lat);
            $('#longitude').val(lng);
        });
        /// fix detailMap2 view on modal dialog
        $('#modal-dialog-detail').on('show.bs.modal', function() {
            setTimeout(function() {
                detailMap2.invalidateSize()
            }, 400);
        });

        // set latitude from latitude form filed to detailMap2
        $('#modal-dialog-detail #latitude').change(function(e) {
            let lat = $('#modal-dialog-detail #latitude').val();
            let lng = $('#modal-dialog-detail #longitude').val();
            if (detailMarker2 != undefined) {
                detailMap2.removeLayer(detailMarker2);
            };
            detailMarker2 = L.marker([lat, lng]).addTo(detailMap2);
            detailMap2.setView([lat, lng], 16);
        });
        // set longitude from longitude form filed to detailMap2
        $('#modal-dialog-detail #longitude').change(function(e) {
            let lat = $('#modal-dialog-detail #latitude').val();
            let lng = $('#modal-dialog-detail #longitude').val();
            if (detailMarker2 != undefined) {
                detailMap2.removeLayer(detailMarker2);
            };
            detailMarker2 = L.marker([lat, lng]).addTo(detailMap2);
            detailMap2.setView([lat, lng], 16);
        });
    } 

    function detailMode(nim, modal) {
        // map.dragging.disable();
        var ajax = ajaxGet(`{{ url('api/v1/alumni?nim=') }}${nim}`);
        ajax.done(function(result) {
            setFormValue(result, modal);
        });
    }

    function setFormValue(data, modal) {
        console.log(data)
        if (data != null) {
            $(modal+' .modal-title').text(data.nama_lengkap);
            $(modal+' .modal-description').text(data.nim);

            if(data.photo != null)
            {
                $(modal+" .img-circle").attr('src', `{{ asset('public/profile-picture') }}/` + data.photo);
            }else{
                $(modal+" .img-circle").attr('src',`{{ asset('assets/img/no-profile-image.png') }}`);
            }
            $(modal+" #name").val(data.nama_lengkap);
            $(modal+" #h_nim").val(data.nim);
            $(modal+" #nim").val(data.nim);
            $(modal+" #email").val(data.email);
            $(modal+" #entry_year").val(data.tahun_masuk_s1);
            $(modal+" #graduation_year").val(data.tahun_lulus_s1);
            $(modal+" #previous_job").val(data.wahana_internship);
            $(modal+" #workplace").val(data.tempat_kerja);
            $(modal+" #city").val(data.kota_kabupaten);
            $(modal+" #latitude").val(data.latitude);
            $(modal+" #longitude").val(data.longitude);
            $(modal+" #latitude").trigger("change");
            $(modal+" #longitude").trigger("change");
        } else {
            $(modal+" #name").val('');
            $(modal+" #nim").val('');
            $(modal+" #email").val('');
            $(modal+" #entry_year").val('');
            $(modal+" #graduation_year").val('');
            $(modal+" #previous_job").val('');
            $(modal+' #workplace').val('');
            $(modal+' #city').val('');
            $(modal+" #latitude").val(null);
            $(modal+" #longitude").val(null);
            map.removeLayer(detailMarker);
            map.removeLayer(detailMarker2);
        }
    }

    function card(tempatKerja, angkatan, kota) {
        // console.log(angkatan);
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
                        li.dataset.angkatan = data.tahun_masuk_s1;
                        li.dataset.alumni = JSON.stringify(data.alumnus)
                        li.dataset.toggle = 'modal'
                        li.dataset.target = '#modal-dialog'
                        li.innerHTML = `<a href="#">${(data.tahun_masuk_s1 == '' ? '-' : data.tahun_masuk_s1)} <span class="pull-right badge bg-blue">${data.alumnus.length} Orang</span></a>`;
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
                    <td><a href="" data-toggle="modal" data-target="#modal-dialog-detail" onclick="return detailMode(${element.nim}, '#modal-dialog-detail')">${element.nama_lengkap}</a></td>
                    <td>${(element.tahun_lulus_s1 == null ? '-' : element.tahun_lulus_s1)}</td>
                </tr>`;
            }
        }
        $('#tbody').html(tbody);
        $('.modal-title').text(tempatKerja + ' - Angkatan ' + angkatan);
        $('.modal-description').text(kota);
    }

</script>
@endsection
