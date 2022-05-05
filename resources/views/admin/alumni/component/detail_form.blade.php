
<div class="row">
    <div class="col-md-4">
        <div class="box box-widget widget-user">
            <div class="widget-user-header bg-red">
                {{-- <h3 class="widget-user-username">Alexander Pierce</h3>
                <h5 class="widget-user-desc">Founder &amp; CEO</h5> --}}
            </div>
            <div class="widget-user-image" style="margin-left: -70px; top:50px">
                <img class="img-circle" style="width: 140px; height: 140px" src="{{ asset('assets/img/no-profile-image.png') }}" alt="User Avatar">
            </div>
            <div class="box-footer">
                <div class="row" style="margin-top: 60px">
                    <div class="col-sm-12">
                        @if(request()->is('alumni*'))
                            
                        <form id="upload-image-form" action="" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="nim" id="h_nim">
                            <input type="file" name="photo" class="pull-left" required>
                            <button class="pull-right">Ubah</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="name">Name<span class="text-red">*</span></label>
            <input type="text" disabled class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="[Nama]" required>
            @error('name')
                <span class="text-red">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="nim">NIM<span class="text-red">*</span></label>
            <input type="number" disabled class="form-control" id="nim" name="nim" value="{{ old('nim') }}" placeholder="[NIM]" required>
            @error('nim')
                <span class="text-red">{{ $message }}</span>
            @enderror
        </div>
        {{-- <div class="form-group">
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
        </div> --}}
        <div class="form-group">
            <label for="email">Email<span class="text-red">*</span></label>
            <input type="email" disabled class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="[Email]" required>
            @error('email')
                <span class="text-red">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="entry_year">Tahun Masuk</label>
            <input type="number" disabled min="2000" max="3000" class="form-control" id="entry_year" name="entry_year" value="{{ old('entry_year') }}" placeholder="[Tahun Masuk]">
            @error('entry_year')
                <span class="text-red">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="graduation_year">Tahun Lulus</label>
            <input type="number" disabled min="2000" max="3000" class="form-control" id="graduation_year" name="graduation_year" value="{{ old('graduation_year') }}" placeholder="[Tahun Lulus]">
            @error('graduation_year')
                <span class="text-red">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label for="previous_job">Riwayat Pekerjaan</label>
            <textarea class="form-control" disabled id="previous_job" name="previous_job" rows="3" placeholder="[Pekerjaan Sebelumnya]">{{ old('previous_job') }}</textarea>
            @error('previous_job')
                <span class="text-red">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="workplace">Tempat Kerja</label>
            <input type="text" disabled class="form-control select2" id="workplace" name="workplace" placeholder="[Tempat Kerja]">
            @error('workplace')
                <span class="text-red">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="city">Kota/Kabupaten</label>
            <input type="text" disabled class="form-control" id="city" name="city">
            @error('city')
                <span class="text-red">{{ $message }}</span>
            @enderror
        </div>
        <label for="map">Peta Lokasi Tempat Kerja</label>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="number" disabled step="any" class="form-control" id="latitude" name="latitude" placeholder="[Latitude]">
                    @error('latitude')
                        <span class="text-red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="number" disabled step="any" class="form-control" id="longitude" name="longitude" placeholder="[Longitude]">
                    @error('longitude')
                        <span class="text-red">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div id="detail_map" class="map" style="height: 500px"></div>
    </div>
</div>