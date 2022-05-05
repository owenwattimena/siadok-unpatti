@extends('admin.templates.template')

@section('style')

<!-- Leaftlet Js -->
@include('assets.css.leaflet')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- Select2 -->
{{-- <link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}"> --}}
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
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
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {!! session('message') !!}
        </div>
        @endif
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Daftar Alumni</h3>
                <button class="btn btn-sm bg-blue pull-right" onclick="createMode()"><i class="fa fa-plus"></i> Tambah/Update</button>
                <div class="box hide" style="margin-top: 15px" id="import-box">
                    <div class="box-body">
                        <form action="{{ route('alumni.import') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="import">Import</label>
                                <div class="row">
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="file" id="import" placeholder="Pilih File" required>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="submit" class="btn btn-primary">IMPORT</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- /.modal -->
                @include('admin.alumni.component.create_modal')
                <div class="table-responsive">

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>NIM</th>
                                <th>NAMA</th>
                                <th>TAHUN MASUK S1</th>
                                <th>TAHUN LULUS S1</th>
                                <th>TEMPAT KERJA</th>
                                <th>KOTA/KABUPATEN</th>
                                <th>AKSI</th>
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
                                <td>{{ $item->tempat_kerja ?? '-'}}</td>
                                <td>{{ $item->kota_kabupaten ?? '-'}}</td>
                                <td>
                                    <button class="btn btn-sm bg-blue" onclick="return detailMode({{ $item->nim }})" data-toggle="modal" data-target="#modal-default"><i class="fa fa-list"></i> Detail</button>
                                    {{-- <button class="btn btn-sm bg-orange" onclick="return updateMode({{ $item->nim }})" data-toggle="modal" data-target="#modal-default"><i class="fa fa-edit"></i> Ubah</button> --}}
                                    <form action="{{ route('alumni.delete', $item->id) }}" style="display: inline;" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm bg-red" onclick="return confirm('Yakin ingin menghapus alumni {{ $item->nama_lengkap }}?')"><i class="fa fa-trash"></i> Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
@include('assets.js.leaflet')
<!-- DataTables -->
<script src="{{ asset('assets') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- select2 -->
{{-- <script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.min.js') }}"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
<!-- ajaxPost -->
<script src="{{ asset('assets/app-js/appAjax.js') }}"></script>
<script src="{{ asset('assets/app-js/markerKabMaluku.js') }}"></script>
<script>
    let map;
    var marker;
    let mapDisable = false;
    $(document).ready(function() {
        $('#example1').DataTable();
        @if($errors->any())
        setTimeout(function() {
            $('#modal-default').modal('show');
        }, 400);
        @endif
        @if($errors->has('city_id') || $errors-> has('latitude') || $errors-> has('longitude'))
        showCityMap();
        @else
        showCityMap(false);
        @endif
        initMap();

        $('#upload-image-form').on('submit', function(e){
            e.preventDefault();
            var formData = new FormData(this);
            var ajax = ajaxPost(`{{ url('api/v1/alumni/image') }}`, formData);
            ajax.done(function(result){
                $(".img-circle").attr('src', `{{ asset('public/profile-picture') }}/` + result.photo);
            })
        });
    })

    function disableForm(state) {
        // $('form input').prop("disabled", state);
        // $('form textarea').prop("disabled", state);
        // $('form select').prop("disabled", state);
        // if (state) {
        //     $('.modal-footer').hide();
        // } else {
        //     $('.modal-footer').show();
        // }
        // $('#upload-image-form input').prop("disabled", false);
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

    function showCityMap(state = true) {
        if (state) {
            $('label[for=city_id]').show();
            $('#city_id').show();
            $('label[for=workplace]').show();
            $('#workplace').show();
            $('label[for=map]').show();
            $('#latitude').show();
            $('#longitude').show();
            $('#map').css('opacity', '1');
        } else {
            $('label[for=city_id]').hide();
            $('#city_id').hide();
            $('label[for=workplace]').hide();
            $('#workplace').hide();
            $('label[for=map]').hide();
            $('#latitude').hide();
            $('#longitude').hide();
            $('#map').css('opacity', '0');
        }
    }

    function initMap() {
        disableForm(false);
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

    function detailMode(nim) {
        $('.modal-title').text('Detail Alumni');
        // disableForm(true)
        showCityMap();
        mapDisable = true
        map.dragging.disable();
        showPasswordFiled(false);
        var ajax = ajaxGet(`{{ url('api/v1/alumni?nim=') }}${nim}`);
        ajax.done(function(result) {
            setFormValue(result, true);
        });
    }

    function setFormValue(data, isDetail = false) {
        if (data != null) {
            console.log(data.photo);
            if(data.photo != null)
            {
                $(".img-circle").attr('src', `{{ asset('public/profile-picture') }}/` + data.photo);
            }else{
                $(".img-circle").attr('src',`{{ asset('assets/img/no-profile-image.png') }}`);
            }
            $("#name").val(data.nama_lengkap);
            $("#h_nim").val(data.nim);
            $("#nim").val(data.nim);
            $("#email").val(data.email);
            $("#entry_year").val(data.tahun_masuk_s1);
            $("#graduation_year").val(data.tahun_lulus_s1);
            $("#previous_job").val(data.wahana_internship);
            $("#workplace").val(data.tempat_kerja);
            $("#city").val(data.kota_kabupaten);
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
            $('#workplace').val('');
            $('#city').val('');
            $("#latitude").val(null);
            $("#longitude").val(null);
            map.removeLayer(marker);
        }
    }

    function createMode() {
        $('#import-box').toggleClass('hide');
        // $('.modal-title').text('Tambah Alumni');
        // $('form').attr('action', `{{ url('alumni') }}`);
        // $('input[name=_method]').val('POST');
        // disableForm(false)
        // showCityMap(false);
        // mapDisable = false
        // map.dragging.enable();
        // showPasswordFiled();
        // setFormValue();
    }

    function updateMode(nim) {
        $('form').attr('action', `{{ url('alumni') }}/${nim}`);
        $('input[name=_method]').val('PUT');
        $('.modal-title').text('Update Alumni');
        disableForm(false)
        showCityMap(true);
        mapDisable = false;
        map.dragging.enable();
        showPasswordFiled(false);
        var ajax = ajaxGet(`{{ url('api/v1/alumni?nim=') }}${nim}`);
        ajax.done(function(result) {
            setFormValue(result);
        });
    }

    function formSubmit() {
        if (document.getElementById('form').reportValidity()) {
            return document.getElementById('form').submit();
        }
        return;
    }

</script>
@endsection
