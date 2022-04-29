<style>
    .select2{
        width: 100% !important;
    }
    .select2-selection{
        height: 34px !important;
        border-radius: 0!important;
        border-color: #d2d6de!important;
    }
</style>
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
            <input type="number" min="2000" max="3000" class="form-control" id="entry_year" name="entry_year" value="{{ old('entry_year') }}" placeholder="[Tahun Masuk]">
            @error('entry_year')
                <span class="text-red">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="graduation_year">Tahun Lulus</label>
            <input type="number" min="2000" max="3000" class="form-control" id="graduation_year" name="graduation_year" value="{{ old('graduation_year') }}" placeholder="[Tahun Lulus]">
            @error('graduation_year')
                <span class="text-red">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label for="previous_job">Riwayat Pekerjaan</label>
            <textarea class="form-control" id="previous_job" name="previous_job" rows="3" placeholder="[Pekerjaan Sebelumnya]">{{ old('previous_job') }}</textarea>
            @error('previous_job')
                <span class="text-red">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="workplace">Tempat Kerja</label>
            <select type="text" class="form-control select2" id="workplace" name="workplace" placeholder="[Tempat Kerja]">
                {{-- <option></option> --}}
            </select>
            @error('workplace')
                <span class="text-red">{{ $message }}</span>
            @enderror
            <small class="text-grey">Kolom Tempat Kerja dapat dipilih atau di tambah secara manual. Jika anda memilih Tempat Kerja berdasarkan daftar yang tersedia maka sistem akan secara otomatis melengkapi kolom Kota/Kabupaten dan mengatur Peta</small>
        </div>
        <div class="form-group">
            <label for="city_id">Kota/Kabupaten</label>
            <select min="2000" max="3000" class="form-control" id="city_id" name="city_id">
                <option>--- pilih Kota/Kabupaten ---</option>
                @foreach ([] as $item)
                <option value="{{ $item->id }}">{{ $item->city_name }}</option>
                @endforeach
            </select>
            @error('city_id')
                <span class="text-red">{{ $message }}</span>
            @enderror
        </div>
        <label for="map">Peta Lokasi Tempat Kerja</label>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="number" step="any" class="form-control" id="latitude" name="latitude" placeholder="[Latitude]">
                    @error('latitude')
                        <span class="text-red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="number" step="any" class="form-control" id="longitude" name="longitude" placeholder="[Longitude]">
                    @error('longitude')
                        <span class="text-red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div id="map" style="height: 500px"></div>
    </div>
</div>