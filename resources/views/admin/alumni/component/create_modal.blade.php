<style>
    .modal {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        overflow: hidden;
    }

    .modal-dialog {
        position: fixed;
        margin: 0;
        width: 100%;
        height: 100%;
        padding: 0;
    }

    .modal-content {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        border: 2px solid #3c7dcf;
        border-radius: 0;
        box-shadow: none;
    }

    .modal-header {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        height: 50px;
        padding: 10px;
        background: #3c8dbc;
        border: 0;
    }

    .modal-title {
        font-weight: 300;
        font-size: 2em;
        color: #fff;
        line-height: 30px;
    }

    .modal-body {
        position: absolute;
        top: 50px;
        bottom: 60px;
        width: 100%;
        font-weight: 300;
        overflow: auto;
    }

    .modal-footer {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        height: 60px;
        padding: 10px;
        background: #f1f3f5;
    }
    .select2{
        width: 100%!important;
    }
    .select2-selection{
        height: 35px!important;
        border-radius: 0!important;
        border-color: #d2d6de!important;
    }
    .select2, .select2-selection:focus{
        border-color: #66afe9!important;
    }

</style>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('alumni.store') }}" method="post" class="form" id="form">
                @csrf
                @method('POST')
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Tambah Alumni</h4>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Name<span class="text-red">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="[Nama]" required>
                                    @error('name')
                                        <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nim">NIM<span class="text-red">*</span></label>
                                    <input type="number" class="form-control" id="nim" name="nim" value="{{ old('nim') }}" placeholder="[NIM]" required>
                                    @error('nim')
                                        <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Password<span class="text-red">*</span></label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="[Password]" required>
                                    @error('password')
                                        <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Ulang Password<span class="text-red">*</span></label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="[Ulang password]" required>
                                    @error('password')
                                        <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Email<span class="text-red">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="[Email]" required>
                                    @error('email')
                                        <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="entry_year">Tahun Masuk</label>
                                    <input type="number" min="2000" max="3000" class="form-control" id="entry_year" name="entry_year" placeholder="[Tahun Masuk]">
                                </div>
                                <div class="form-group">
                                    <label for="graduation_year">Tahun Lulus</label>
                                    <input type="number" min="2000" max="3000" class="form-control" id="graduation_year" name="graduation_year" placeholder="[Tahun Lulus]">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="previous_job">Riwayat Pekerjaan</label>
                                    <textarea class="form-control" id="previous_job" name="previous_job" rows="3" placeholder="[Pekerjaan Sebelumnya]"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="workplace">Tempat Kerja</label>
                                    <select type="text" class="form-control select2" id="workplace" name="workplace" placeholder="[Tempat Kerja]">
                                        {{-- <option></option> --}}
                                    </select>
                                    <small class="text-grey">Kolom Tempat Kerja dapat dipilih atau di isi secara manual. Jika anda memilih Tempat Kerja berdasarkan daftar yang tersedia maka sistem akan secara otomatis melengkapi kolom Kota/Kabupaten dan mengatur Peta</small>
                                </div>
                                <div class="form-group">
                                    <label for="city_id">Kota/Kabupaten</label>
                                    <select min="2000" max="3000" class="form-control" id="city_id" name="city_id">
                                        <option>--- pilih Kota/Kabupaten ---</option>
                                        @foreach ($lokasi as $item)
                                        <option value="{{ $item->id }}">{{ $item->city_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="map">Peta Lokasi Tempat Kerja</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="number" step="any" class="form-control" id="latitude" name="latitude" placeholder="[Latitude]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="number" step="any" class="form-control" id="longitude" name="longitude" placeholder="[Longitude]">
                                        </div>
                                    </div>
                                </div>
                                <div id="map" style="height: 500px"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Keluar</button>
                    <button type="submit" onclick="document.getElementById('form').submit();" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
