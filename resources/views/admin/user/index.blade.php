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
            User
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">User</li>
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
                <h3 class="box-title">Daftar User</h3>
                <button class="btn btn-sm bg-blue pull-right" onclick="createModal()" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i> Tambah</button>
                @include('admin.user.component.modal')
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 30px">#</th>
                            <th>NAMA</th>
                            <th>EMAIL</th>
                            <th>USERNAME</th>
                            <th>PILIHAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ([] as $key => $item)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $item->city_name }}</td>
                            <td>{{ $item->description ?? '-' }}</td>
                            <td>
                                <button class="btn btn-sm bg-orange" onclick='return updateModal({{ $item->id }}, "{{ $item->city_name }}", "{{ $item->description }}")' data-toggle="modal" data-target="#modal-default"><i class="fa fa-edit"></i> Ubah</button>
                                <form action="{{ route('city.delete', $item->id) }}" style="display: inline;" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm bg-red" onclick="return confirm('Yakin ingin menghapus lokasi {{ $item->city_name }}?')"><i class="fa fa-trash"></i> Hapus</button>
                                </form>
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

<!-- DataTables -->
<script src="{{ asset('assets') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example1').DataTable();
    })
    
    createModal = ()=>{
        resetForm();
    }
    
    updateModal = (cityId, cityName, description) => {
        $('input[name=_method]').val('PUT');
        $('form').attr('action', `{{ url('city') }}/` + cityId);
        $('.modal-title').text('Update Kota/Kabupaten');
        $('#city').val(cityName);
        $('#description').val(description);
    }
    resetForm = ()=>{
        $('form').trigger("reset");
        $('form').attr('action', `{{ url('city') }}`);
        $('input[name=_method]').val('POST');
    }

</script>
@endsection
