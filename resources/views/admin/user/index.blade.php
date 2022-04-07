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
                @include('admin.user.component.password-modal')
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 30px">#</th>
                            <th>NAMA</th>
                            <th>USERNAME</th>
                            <th>EMAIL</th>
                            <th>LEVEL</th>
                            <th>PILIHAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $item)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->username }}</td>
                            <td>{{ $item->email ?? '-' }}</td>
                            <td>{{ $item->role }}</td>
                            <td>
                                <button class="btn btn-sm bg-orange" onclick='updateModal({{ $item->id }}, "{{ $item->name }}", "{{ $item->username }}", "{{ $item->email }}", "{{ $item->role }}")' data-toggle="modal" data-target="#modal-default"><i class="fa fa-edit"></i> Ubah</button>
                                <button class="btn btn-sm bg-black" onclick='changePassword({{ $item->id }})' data-toggle="modal" data-target="#modal-password"><i class="fa fa-key"></i> Ubah Password</button>
                                <form action="{{ route('user.delete', $item->id) }}" style="display: inline;" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm bg-red" onclick="return confirm('Yakin ingin menghapus user {{ $item->username }}?')"><i class="fa fa-trash"></i> Hapus</button>
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
        

        @if($errors->update->any())
            setTimeout(function() {
                updateModal();
                $('#modal-default').modal('show');
            }, 400);

        @elseif($errors->password->any())
            changePassword(`{{ old('user_id') }}`);
            $('#modal-password').modal('show');
        @elseif($errors->any())
            setTimeout(function() {
                $('#modal-default').modal('show');
            }, 400);
        @endif
        $('#example1').DataTable();
    })
    
    createModal = ()=>{
        resetForm();
        $('.modal-title').text('Tambah User');
        hidePasswordField(false);
    }
    changePassword = (id)=>{
        $('#user_id_form').val(id);
        $('#form-password').attr('action', `{{ url('user/change-password') }}/` + id);
    }
    
    function updateModal(userId = null, nama = null, username = null, email = null, role = null){
        $('form').attr('action', `{{ url('user') }}/` + userId);
        $('input[name=_method]').val('PUT');
        $('.modal-title').text('Update User');
        hidePasswordField();
        if(userId != null)
        {
            $('input[name=name]').val(nama);
            $('input[name=username]').val(username);
            $('input[name=email]').val(email);
            $('select[name=level]').val(role);
        }
    }
    function resetForm(){
        $('#form')[0].reset();
        $('input[name=name]').val("");
        $('input[name=username]').val("");
        $('input[name=email]').val("");
        $('select[name=level]').val("admin");
        $('form').attr('action', `{{ url('user') }}`);
        $('input[name=_method]').val('POST');
    }

    hidePasswordField = (state = true)=>{
        if(state){
            $('#password').hide();
            $('#password_confirmation').hide();
            $('label[for=password]').hide();
            $('label[for=password_confirmation]').hide();
            $('#password').attr('required', false);
            $('#password_confirmation').attr('required', false);
        }else{
            $('#password').show();
            $('#password_confirmation').show();
            $('label[for=password]').show();
            $('label[for=password_confirmation]').show();
            $('#password').attr('required', true);
            $('#password_confirmation').attr('required', true);
        }
    }

</script>
@endsection
