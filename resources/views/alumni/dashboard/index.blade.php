@extends('admin.templates.template')

@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- Select2 -->
{{-- <link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}"> --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
            <li class="active"><i class="fa fa-map"></i> Dashboard</li>
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
            <div class="box-header with-border">
                <h3 class="box-title">
                    Data Saya
                </h3>
                <div class="box-body">
                    <button id="btn-ubah" onclick="return toggleButton()" class="btn btn-primary pull-right">Ubah</button>
                    <form action="{{ route('my-data.update', auth()->user()->nim) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('admin.alumni.component.form')
                        </br>
                        <button id="btn-simpan" type="submit" class="btn btn-primary pull-right">Simpan</button>
                    </form>
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
<!-- select2 -->
{{-- <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.js" integrity="sha512-e+JSf1UWuoLdiGeXXi5byQqIN7ojQLLgvC+aV0w9rnKNwNDBAz99sCgS20+PjT/r+yitmU7kpGVZJQDDgevhoA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
{{-- <script src="https://d19vzq90twjlae.cloudfront.net/leaflet/v0.7.7/leaflet.js"></script> --}}
@include('assets.js.leaflet')
<script src="{{ asset('assets/app-js/appAjax.js') }}"></script>
<script src="{{ asset('assets/app-js/markerKabMaluku.js') }}"></script>

<script>
    let map;
    var marker;
    let mapDisable = true;
    $(function(){
        initMap();
        initForm();
        $('#workplace').select2({
            placeholder: "--- Masukan Tempat Kerja ---"
            , tags: []
            ,minimumInputLength: 3
            , ajax: {
                type: 'GET'
                , url: `{{ url('api/v1/select2workplace') }}`
                , dataType: 'json'
                , data: function(params) {
                    var query = {
                        workplace: params.term
                    }
                    // Query parameters will be ?workplace=[term]
                    return query;
                }
                , processResults: function(data) {
                    return {
                        results: data
                    };
                }
            }
        });
        
        $('#btn-simpan').click(function(){
            $('form').trigger('submit');
        });
    })
    $('#workplace').on('select2:select', function(e) {
        var data = e.params.data;
        if (Number.isInteger(data.id)) {
            var ajax = ajaxGet(`{{ url('api/v1/workplace?id=') }}${data.id}`);
            ajax.done(function(response) {
                $('#city_id').val(response.city_id)
                $('#latitude').val(response.latitude)
                $('#longitude').val(response.longitude)
                $('#latitude').trigger("change");
                $('#longitude').trigger("change");
                
            });
        }
    })
    function initMap() {
        var base_layer, mbAttr, mbUrl;

        mbAttr = 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community';

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
        map.addControl(new L.Control.Fullscreen())
        markerKabMaluku(L, map);
        /// OnClick on Map set value to latitude and longitude
        map.on('click', function(e) {
            if (mapDisable) {
                return;
            }
            if (marker != undefined) {
                map.removeLayer(marker);
            };
            marker = L.marker(e.latlng).addTo(map);
            let lat = e.latlng.lat;
            let lng = e.latlng.lng;
            $('#latitude').val(lat);
            $('#longitude').val(lng);
        });
        /// fix map view on modal dialog
        $('#modal-default').on('show.bs.modal', function() {
            setTimeout(function() {
                map.invalidateSize()
            }, 400);
        });

        // set latitude from latitude form filed to map
        $('#latitude').change(function(e) {
            let lat = $('#latitude').val();
            let lng = $('#longitude').val();
            if (marker != undefined) {
                map.removeLayer(marker);
            };
            marker = L.marker([lat, lng]).addTo(map);
            map.setView([lat, lng], 16);
        });
        // set longitude from longitude form filed to map
        $('#longitude').change(function(e) {
            let lat = $('#latitude').val();
            let lng = $('#longitude').val();
            if (marker != undefined) {
                map.removeLayer(marker);
            };
            marker = L.marker([lat, lng]).addTo(map);
            map.setView([lat, lng], 16);
        });
    }

    function showPasswordFiled(state = true) {
        if (state) {
            $("#password").attr('disabled', false);
            $("#password").show();
            $("#password_confirmation").attr('disabled', false);
            $("#password_confirmation").show();
            $('label[for=password]').show();
            $('label[for=password_confirmation]').show();
        } else {
            $("#password").attr('disabled', true);
            $("#password").hide();
            $("#password_confirmation").attr('disabled', true);
            $("#password_confirmation").hide();
            $('label[for=password]').hide();
            $('label[for=password_confirmation]').hide();
        }
    }

    function initForm()
    {
        showPasswordFiled(false);
        var ajax = ajaxGet(`{{ url('api/v1/alumni?nim=' . auth()->user()->username) }}`);
        ajax.done(function(result) {
            setFormValue(result);
        });
        disableForm(true);
        map.dragging.disable();
        $('#btn-simpan').hide();
    }
    function setFormValue(data, isDetail = false) {
        var workplace = $('#workplace');
        if (data != null) {
            $("#name").val(data.name);
            $("#nim").val(data.nim);
            $("#email").val(data.email);
            $("#entry_year").val(data.entry_year);
            $("#graduation_year").val(data.graduation_year);
            $("#previous_job").val(data.previous_job);
            if (data.workplace_name != null) {
                var option = new Option(data.workplace_name, data.workplace_id, true, true);
                workplace.append(option).trigger('change');
            } else {
                var option = new Option(isDetail ? '-' : '', isDetail ? '-' : '', true, true);
                workplace.append(option).trigger('change');
            }
            if (data.city_id != null) {
                $('#city_id').val(data.city_id);
            } else {
                $('#city_id').val('-');
            }
            $("#latitude").val(data.latitude);
            $("#longitude").val(data.longitude);
            $("#latitude").trigger("change");
            $("#longitude").trigger("change");
        } else {
            $("#name").val('');
            $("#nim").val('');
            $("#email").val('');
            $("#entry_year").val('');
            $("#graduation_year").val('');
            $("#previous_job").val('');
            var option = new Option('', '', true, true);
            workplace.append(option).trigger('change');
            $('#city_id').val('');
            $("#latitude").val(null);
            $("#longitude").val(null);
            map.removeLayer(marker);
        }
    }
    function disableForm(state) {
        $('form input').prop("disabled", state);
        $('form textarea').prop("disabled", state);
        $('form select').prop("disabled", state);
        if (state) {
            $('.modal-footer').hide();
        } else {
            $('.modal-footer').show();
        }
    }
    var formDisableState = true;    
    function toggleButton() {
        if (formDisableState) {
            disableForm(false);
            formDisableState = false;
            $('#btn-ubah').text('Batal')
            $('#btn-simpan').show();
            mapDisable = false
            map.dragging.enable();
        }else{
            disableForm(true);
            formDisableState = true;
            $('#btn-ubah').text('Ubah')
            $('#btn-simpan').hide();
            initMap();
            initForm();
            mapDisable = true
            map.dragging.disable();
        }
    }
</script>
@endsection
