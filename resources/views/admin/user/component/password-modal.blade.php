
{{-- Component Modal --}}
<div class="modal fade" id="modal-password">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="#" method="post" id="form-password">
                @csrf
                @method('put')
                <input type="hidden" name="user_id" id="user_id_form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Ubah Password</h4>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="newpassword">Password Baru</label>
                                <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="[Password Baru]" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="newpassword_confirmation" name="newpassword_confirmation" placeholder="[Konfirmasi Password Baru]" required>
                                @if($errors->password->has('newpassword'))
                                    <span class="text-red">{{ $errors->password->first('newpassword') }}</span>
                                @endif
                            </div>
                            
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Keluar</button>
                            <button type="submit" class="btn bg-black"><i class="fa fa-save"></i> Ubah Password</button>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->