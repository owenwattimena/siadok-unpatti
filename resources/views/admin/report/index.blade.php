@extends('admin.templates.template')

@section('style')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('assets') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

@endsection

@section('body')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Laporan
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Laporan</li>
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
            <div class="box-body">
                <div class="row">
                    <form action="" method="get">   
                        <div class="col-xs-3">
                            <label for="entry_year">Tahun Masuk S1</label>
                            <input type="number" class="form-control" name="entry_year" value="{{ app('request')->input('entry_year') }}" placeholder="[Tahun Masuk]">
                        </div>
                        <div class="col-xs-3">
                            <label for="graduation_year">Tahun Lulus S1</label>
                            <input type="number" class="form-control" name="graduation_year" value="{{ app('request')->input('graduation_year') }}" placeholder="[Tahun Lulus]">
                        </div>
                        <div class="col-xs-3">
                            <label for="city">Kota Kabupaten</label>
                            <select class="form-control" name="city">
                                <option value="">---PILIH KOTA---</option>
                                @foreach ($cities as $item)
                                <option value="{{ $item->kota_kabupaten }}" {{ (app('request')->input('city') == $item->kota_kabupaten) ? 'selected' : '' }}>{{ $item->kota_kabupaten }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xs-3">
                            <label for="">Filter & Unduh</label>
                            <div class="form-group">
                                <button class="btn btn-primary" style="margin-bottom: 2px"><i class="fa fa-filter"></i> FILTER</button>
                                <button name="download" value="true" class="btn btn-success" style="margin-bottom: 2px"><i class="fa fa-download"></i> UNDUH</button>
                                <button name="export" value="true" class="btn btn-warning"><i class="fa fa-file-excel-o"></i> UNDUH TRACER STUDY</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Laporan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="col-sm-4 invoice-col">
                    {!! $filter !!}
                    <br>
                </div>
                <div class="table-responsive" style="width: 100%">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 30px">#</th>
                                <th>NIM</th>
                                <th>NAMA</th>
                                <th>TAHUN MASUK</th>
                                <th>TAHUN LULUS</th>
                                <th>KOTA</th>
                                <th>TEMPAT KERJA</th>
                                <th>WAHANA INTERNSHIP</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alumnus as $key => $item)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $item->nim }}</td>
                                <td>{{ $item->nama_lengkap }}</td>
                                <td>{{ $item->tahun_masuk_s1 }}</td>
                                <td>{{ $item->tahun_lulus_s1 }}</td>
                                <td>{{ $item->kota_kabupaten }}</td>
                                <td>{{ $item->tempat_kerja }}</td>
                                <td>{{ $item->wahana_internship }}</td>
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

<!-- DataTables -->
<script src="{{ asset('assets') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example1').DataTable();
    })
</script>
@endsection
