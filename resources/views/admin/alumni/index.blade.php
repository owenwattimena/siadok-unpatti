@extends('admin.templates.template')

@section('style')

<!-- Leaftlet Js -->
@include('assets.css.leaflet')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- Select2 -->
{{-- <link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.min.css') }}"> --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                <button class="btn btn-sm bg-blue pull-right" onclick="createMode()" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah</button>
                @include('admin.alumni.component.create_modal')
                <!-- /.modal -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>NIM</th>
                                <th>NAMA</th>
                                <th>TAHUN MASUK</th>
                                <th>TAHUN LULUS</th>
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
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->entry_year ?? '-' }}</td>
                                <td>{{ $item->graduation_year ?? '-'}}</td>
                                <td>{{ $item->workplace_name ?? '-'}}</td>
                                <td>{{ $item->city_name ?? '-'}}</td>
                                <td>
                                    <button class="btn btn-sm bg-blue" onclick="return detailMode({{ $item->nim }})" data-toggle="modal" data-target="#modal-default"><i class="fa fa-list"></i> Detail</button>
                                    <button class="btn btn-sm bg-orange" onclick="return updateMode({{ $item->nim }})" data-toggle="modal" data-target="#modal-default"><i class="fa fa-edit"></i> Ubah</button>
                                    <form action="{{ route('alumni.delete', $item->id) }}" style="display: inline;" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm bg-red" onclick="return confirm('Yakin ingin menghapus alumni {{ $item->name }}?')"><i class="fa fa-trash"></i> Hapus</button>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
        @if($errors->has('city_id')||$errors->has('latitude')||$errors->has('longitude'))
        showCityMap();
        @else
        showCityMap(false);
        @endif
        initMap();
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
    })

    $('#workplace').on('select2:select', function(e) {
        showCityMap();
        var data = e.params.data;
        if (Number.isInteger(data.id)) {
            var ajax = ajaxGet(`{{ url('api/v1/workplace?id=') }}${data.id}`);
            ajax.done(function(response) {
                // console.log(response)
                $('#city_id').val(response.city_id)
                $('#latitude').val(response.latitude)
                $('#longitude').val(response.longitude)
                $('#latitude').trigger("change");
                $('#longitude').trigger("change");
                
            });
        }
    })

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
        disableForm(true)
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

    function createMode() {
        $('.modal-title').text('Tambah Alumni');
        $('form').attr('action', `{{ url('alumni') }}`);
        $('input[name=_method]').val('POST');
        disableForm(false)
        showCityMap(false);
        mapDisable = false
        map.dragging.enable();
        showPasswordFiled();
        setFormValue();
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
