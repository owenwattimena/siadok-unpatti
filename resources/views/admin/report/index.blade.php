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
                            <input type="number" class="form-control" name="entry_year" value="{{ app('request')->input('entry_year') }}" placeholder="[Tahun Masuk]">
                        </div>
                        <div class="col-xs-3">
                            <input type="number" class="form-control" name="graduation_year" value="{{ app('request')->input('graduation_year') }}" placeholder="[Tahun Lulus]">
                        </div>
                        <div class="col-xs-3">
                            <select class="form-control" name="city">
                                <option value="">---PILIH KOTA---</option>
                                @foreach ($cities as $item)
                                <option value="{{ $item->id }}" {{ (app('request')->input('city') == $item->id) ? 'selected' : '' }}>{{ $item->city_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xs-3">
                            <button class="btn btn-primary"><i class="fa fa-filter"></i> FILTER</button>
                            <button name="download" value="true" class="btn btn-success"><i class="fa fa-download"></i> UNDUH</button>
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
                </div>
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
                            <th>PEKERJAAN SEBELUMNYA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alumnus as $key => $item)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $item->nim }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->entry_year }}</td>
                            <td>{{ $item->graduation_year }}</td>
                            <td>{{ $item->city_name }}</td>
                            <td>{{ $item->workplace_name }}</td>
                            <td>{{ $item->previous_job }}</td>
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

<!-- DataTables -->
<script src="{{ asset('assets') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    // $(document).ready(function() {
    //     $('#example1').DataTable();
    // })
</script>
@endsection
