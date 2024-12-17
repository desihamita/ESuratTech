<x-Layouts.main.app :title="$title"> 
  <div class="content-header">
    <x-breadcrumb :title="$title" :breadcrumbs="$breadcrumbs" />
  </div>
  <section class="content">
    <div class="container-fluid">
      <div class="row mr-3 ml-3">
        <div class="col-md-3">
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center position-relative">
                <!-- Gambar Lembaga -->
                <img class="profile-user-img px-3 py-4"
                     src="{{ $lembaga->logo ? asset('uploads/lembaga/' . $lembaga->logo) : asset('assets/dist/img/default.png') }}"
                     alt="Lembaga logo" style="position: relative;">
                
                <!-- Label Ikon Kamera -->
                <label for="file-input" 
                       style="position: absolute; bottom: 0; right: 30px;  white; border-radius: 50%; padding: 10px; cursor: pointer; margin-bottom:80px; font-size: 25px;">
                  <i class="fa fa-camera "></i>
                </label>
                
                <!-- Form untuk Update Foto -->
                <form action="{{ route('lembaga.updateLogo') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <input id="file-input" type="file" name="logo" accept="image/*" onchange="this.form.submit()" style="display: none;">
                </form>
                
                <h1 class="profile-username text-center mt-5">{{ $lembaga->nama_lembaga }}</h1>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              
              <!-- Notifications -->
              <x-alert />

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <form action="{{ route('lembaga.update') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')

                  <input type="hidden" name="id" value="{{ $lembaga->id }}">
                  <h5 class="mt-2 mb-3"><i class="fas fa-solid fa-school mr-2"></i>Informasi Lembaga</h1>
                    <div class="row">
                      <!-- Input Nama Lembaga -->
                      <div class="form-group col-md-6">
                        <label for="inputName">Nama Lembaga</label>
                        <input type="text" class="form-control" id="inputName" name="nama_lembaga" value="{{ $lembaga->nama_lembaga }}" placeholder="Nama Lembaga">
                      </div>

                      <!-- Input Telepon -->
                      <div class="form-group col-md-6">
                        <label for="telepon">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" value="{{ $lembaga->telepon }}" placeholder="Telepon">
                      </div>
                    </div>

                    <div class="row">
                      <!-- Input Email -->
                      <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $lembaga->email }}" placeholder="Email">
                      </div>

                      <!-- Input Website -->
                      <div class="form-group col-md-6">
                        <label for="website">Website</label>
                        <input type="text" class="form-control" id="website" name="website" value="{{$lembaga->website}}" placeholder="Website">
                      </div>
                    </div>

                    <!-- Input Alamat -->
                    <div class="form-group col-md-12">
                      <label for="alamat">Alamat</label>
                      <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat">{{ $lembaga->alamat}}</textarea>
                    </div>

                    <div class="row">
                      <!-- Input Tahun -->
                      <div class="form-group col-md-4">
                        <label for="tahun">Tahun</label>
                        <input type="text" class="form-control" id="tahun" name="tahun" value="{{ $lembaga->tahun }}" placeholder="Tahun">
                      </div>

                      <!-- Input Kota -->
                      <div class="form-group col-md-4">
                        <label for="kota">Kota</label>
                        <input type="text" class="form-control" id="kota" name="kota" value="{{ $lembaga->kota }}" placeholder="Kota">
                      </div>

                      <!-- Input Provinsi -->
                      <div class="form-group col-md-4">
                        <label for="provinsi">Provinsi</label>
                        <input type="text" class="form-control" id="provinsi" name="provinsi" value="{{ $lembaga->provinsi }}" placeholder="Provinsi">
                      </div>
                    </div>

                    <h5 class="mt-2 mb-3"><i class="fas fa-solid fa-user-tie mr-2"></i>Informasi Kepala Lembaga</h1>
                    <div class="row">
                      <!-- Input Kepala -->
                      <div class="form-group col-md-4">
                        <label for="kepala">Kepala</label>
                        <input type="text" class="form-control" id="kepala" name="kepala" value="{{ $lembaga->kepala }}" placeholder="Kepala">
                      </div>

                      <!-- Input NIP -->
                      <div class="form-group col-md-4">
                        <label for="nip">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip" value="{{ $lembaga->nip }}" placeholder="NIP">
                      </div>

                      <!-- Input Jabatan -->
                      <div class="form-group col-md-4">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $lembaga->jabatan }}" placeholder="Jabatan">
                      </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mt-4">Submit</button>
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</x-Layouts.main.app>
