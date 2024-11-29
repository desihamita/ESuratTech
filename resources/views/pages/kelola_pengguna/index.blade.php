<x-Layouts.main.app :title="$title">
  <div class="content-header">
    <x-breadcrumb :title="$title" :breadcrumbs="$breadcrumbs" />
  </div>
  <section class="content">
    <div class="container-fluid">
      <!-- Notifikasi -->
     <x-alert/>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header m-2">
              <a class="btn btn-primary" data-toggle="modal" data-target="#modal-add">
                <i class="fas fa-solid fa-plus mr-2"></i>Add
              </a>
            </div>
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Photo</th>
                    <th>NIP</th>
                    <th>Nama Lengkap</th>
                    <th>Jabatan</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody id="data-container">
                @php
                  $no = 1;
                @endphp

                @foreach ($data as $d)
                  @if ($d->level !== 'admin')
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>
                        @if ($d->profile_picture)
                        <img src="{{ asset('uploads/profile/'. $d->profile_picture) }}" width="20em">
                        @else
                          <img src="{{ asset('uploads/profile/user-default.png') }}" width="50em" alt="">
                        @endif
                      </td>
                      <td>{{ $d->nip }}</td>
                      <td>{{ $d->name }}</td>
                      <td>{{ $d->jabatan }}</td>
                      <td>
                        @if ($d->division)
                          {{ $d->division->nama }}
                        @else
                          -
                        @endif
                      </td>
                      <td>
                        @if ($d->status === 'inactive')
                          <button class="btn btn-sm btn-danger">Inactive</button>
                        @elseif ($d->status === 'active')
                          <button class="btn btn-sm btn-success">Active</button>
                        @endif
                      </td>
                      <td>
                        <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $d->id }}" data-toggle="modal" data-target="#modal-edit{{ $d->id }}">
                          <i class="fas fa-edit"></i>
                        </button>

                        <button class="btn btn-sm btn-info detail-btn" data-id="{{ $d->id }}" data-toggle="modal" data-target="#modal-detail{{ $d->id }}">
                          <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $d->id }}" data-toggle="modal" data-target="#modal-delete{{ $d->id }}">
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  @endif
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
          
          <!-- modal tambah data -->
          <div class="modal fade" id="modal-add">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"><i class="fas fa-solid fa-user mr-2"></i>Tambah User</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <h5 class="font-weight-bold mb-0">Informasi Umum</h5>
                    <span class="d-block mb-2">Lengkapi informasi</span>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIP</label>
                                <input type="text" name="nip" class="form-control" placeholder="Masukkan NIP">
                                @error('nip')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" placeholder="Masukkan Nama Lengkap">
                                @error('nama')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Jabatan</label>
                                <input type="text" name="jabatan" class="form-control" placeholder="Masukkan Jabatan">
                                @error('jabatan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Masukkan Email">
                                @error('Email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan Password">
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Level</label>
                          <select name="division_kode" class="form-control">
                            <option value="">--Pilih Level--</option>
                              @foreach ($divisions as $d)
                                  <option value="{{ $d->kode }}">{{ $d->nama }}</option>
                              @endforeach
                          </select>
                          @error('division_kode')
                            <small class="text-danger">{{ $message }}</small>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Status</label>
                          <select name="status" class="form-control">
                            <option value="">--Pilih Status--</option>
                            <option value="inactive">Inactive</option>
                            <option value="active">Active</option>
                          </select>
                          @error('status')
                            <small class="text-danger">{{ $message }}</small>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="mr-4 ml-2">
                      <button type="submit" class="btn btn-info" id="btnSimpan">Simpan</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          
          <!-- modal Edit data -->
          @foreach ($data as $d)
          <div class="modal fade" id="modal-edit{{ $d->id }}">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Edit Data Pengguna</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('user.update', $d->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                
                    <h5 class="font-weight-bold mb-0">Informasi Umum</h5>
                    <span class="d-block mb-2">Lengkapi informasi pada s.</span>
                    <div class="row mb-4">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>NIP</label>
                          <input type="text" value="{{ $d->nip }}" name="nip" class="form-control" placeholder="Masukkan NIP">
                          @error('nip')
                          <small class="text-danger">{{ $message }}</small>
                          @enderror
                        </div>
                
                        <div class="form-group">
                          <label>Nama Lengkap</label>
                          <input type="text" name="name" value="{{ $d->name }}" class="form-control" placeholder="Masukkan Nama Lengkap">
                          @error('nama')
                          <small class="text-danger">{{ $message }}</small>
                          @enderror
                        </div>
                
                        <div class="form-group">
                          <label>Jabatan</label>
                          <input type="text" value="{{ $d->jabatan }}" name="jabatan" class="form-control" placeholder="Masukkan Jabatan">
                          @error('jabatan')
                          <small class="text-danger">{{ $message }}</small>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Email</label>
                          <input type="email" value="{{ $d->email }}" name="email" class="form-control" placeholder="Masukkan Email">
                          @error('Email')
                          <small class="text-danger">{{ $message }}</small>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label>Password</label>
                          <input type="password" name="password" class="form-control" placeholder="Masukkan nama password">
                          @error('password')
                          <small class="text-danger">{{ $message }}</small>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Level</label>
                          <select name="division_kode" class="form-control">
                            <option value="">Pilih Level</option>
                            @foreach ($divisions as $dv)
                            <option value="{{ $dv->kode }}" {{ $d->division_kode == $dv->kode ? 'selected' : '' }}>
                              {{ $dv->nama }}
                            </option>
                            @endforeach
                          </select>
                          @error('division_kode')
                          <small class="text-danger">{{ $message }}</small>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Status</label>
                          <select name="status" class="form-control">
                            <option value="">--Pilih Status--</option>
                            <option value="inactive">Inactive</option>
                            <option value="active">Active</option>
                          </select>
                          @error('status')
                          <small class="text-danger">{{ $message }}</small>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="mr-4 ml-2">
                      <button type="submit" class="btn btn-info" id="btnSimpan">Simpan</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">batal</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          @endforeach
          
          <!-- modal detail data -->
          <div class="modal fade" id="modal-detail{{ $d->id }}">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Detail User</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td><strong>NIP</strong></td>
                      <td id="nip">{{ $d->nip }}</td>
                    </tr>
                    <tr>
                      <td><strong>Nama</strong></td>
                      <td id="nama">{{ $d->name }}</td>
                    </tr>
                    <tr>
                      <td><strong>Jabatan</strong></td>
                      <td id="jabatan">{{ $d->jabatan }}</td>
                    </tr>
                    <tr>
                      <td><strong>Nama Divisi</strong></td>
                      <td id="nama_divisi">{{ $d->division_kode }}</td>
                    </tr>
                    <tr>
                      <td><strong>Email</strong></td>
                      <td id="email">{{ $d->email }}</td>
                    </tr>
                    <tr>
                      <td><strong>Status</strong></td>
                      <td id="status" class="badge {{ $d->status === 'active' ? 'badge-success' : ($d->status === 'inactive' ? 'badge-danger' : '') }} badge-pill text-sm py-2 px-3 m-2">{{ $d->status }}</td>
                    </tr>
                  </tbody>
                </table>
                </div>
              </div>
            </div>
          </div>
          <!-- modal delett data -->
          @foreach ($data as $d)
          <div class="modal fade" id="modal-delete{{ $d->id }}">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Hapus User</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td><strong>Nama</strong></td>
                      <td>{{ $d->name }}</td>
                    </tr>
                    <tr>
                      <td><strong>Jabatan</strong></td>
                      <td>{{ $d->jabatan }}</td>
                    </tr>
                  </tbody>
                </table>
                <form action="{{ route('user.delete', $d->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Hapus</button>
                  <button type="button" class="btn btn-info" data-dismiss="modal">batal</button>
                </form>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>
</x-Layouts.main.app>

