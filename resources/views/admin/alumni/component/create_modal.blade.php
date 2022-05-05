{{-- Modal Style --}}
<link rel="stylesheet" href="{{asset('assets/app-css/modal.css')}}">

{{-- Component Modal --}}
<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{-- <form action="{{ route('alumni.import') }}" method="post" class="form" id="form"> --}}
                {{-- @csrf --}}
                {{-- @method('POST') --}}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Tambah Alumni</h4>
                </div>
                <div class="modal-body">
                    <div class="container">
                        @include('admin.alumni.component.form')
                    </div>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Keluar</button>
                    <button type="submit" onclick="return formSubmit()" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                </div> --}}
            {{-- </form> --}}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
