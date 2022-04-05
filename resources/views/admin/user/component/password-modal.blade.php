
{{-- Component Modal --}}
<div class="modal fade" id="modal-password">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('user.store') }}" method="post">
                @csrf
                @method('post')
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
                                <label for="new_password">Password Baru</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="[Password Baru]" required>
                                @error('new_password')
                                    <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="[Konfirmasi Password Baru]" required>
                                @error('new_password_confirmation')
                                    <span class="text-red">{{ $message }}</span>
                                @enderror
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