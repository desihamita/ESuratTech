<div class="row">
  <!-- Card 1: Surat Masuk -->
  <div class="col-lg-6 col-6">
    <div class="small-box bg-white" style=" border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
      <div class="small-box-footer bg-white d-flex justify-content-between align-items-center" style="font-size: 20px; padding: 10px;">
        <i class="fas fa-envelope text-success"></i>
        <a href="#" class="text-dark" style="text-align: right;">
            <i class="fas fa-ellipsis-v"></i>
        </a>
      </div>
      <div class="inner">
        <h3>{{ $countletterin }}</h3>
        <p>Surat Masuk *</p>
        <span class="text-success">
            <i class="fas fa-arrow-up"></i> 12.5%
        </span>
      </div>
    </div>
  </div>

  <!-- Card 2: Surat Keluar -->
  <div class="col-lg-6 col-6">
    <div class="small-box bg-white" style="text-align:left; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
      <div class="small-box-footer bg-white d-flex justify-content-between align-items-center" style="font-size: 20px; padding: 10px;">
        <i class="fas fa-envelope-open text-danger"></i>
        <a href="#" class="text-dark" style="text-align: right;">
            <i class="fas fa-ellipsis-v"></i>
        </a>
      </div>
      <div class="inner">
        <h3>{{ $countletterout }}</h3>
        <p>Surat Keluar *</p>
        <span class="text-success">
            <i class="fas fa-arrow-up"></i> 12.5%
        </span>
      </div>
    </div>
  </div>

  <!-- Card 3: Surat Disposisi -->
  <div class="col-lg-6 col-6">
    <div class="small-box bg-white" style="border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
      <div class="small-box-footer bg-white d-flex justify-content-between align-items-center" style="font-size: 20px; padding: 10px;">
        <i class="fas fa-file-alt text-primary"></i>
        <a href="#" class="text-dark" style="text-align: right;">
            <i class="fas fa-ellipsis-v"></i>
        </a>
      </div>
      <div class="inner">
        <h3>15</h3>
        <p>Surat Disposisi *</p>
        <span class="text-success">
            <i class="fas fa-arrow-up"></i> 12.5%
        </span>
      </div>
    </div>
  </div>

  <!-- Card 4: Pengguna Aktif -->
  <div class="col-lg-6 col-6">
    <div class="small-box bg-white" style=" border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
      <div class="small-box-footer bg-white d-flex justify-content-between align-items-center" style="font-size: 20px; padding: 10px;">
        <i class="fas fa-user text-info"></i>
        <a href="#" class="text-dark" style="text-align: right;">
            <i class="fas fa-ellipsis-v"></i>
        </a>
      </div>
      <div class="inner">
        <h3>{{ $useraktif }}</h3>
        <p>Pengguna Aktif</p>
        <span class="text-success">
            <i class="fas fa-arrow-up"></i> 12.5%
        </span>
      </div>
    </div>
  </div>
</div>
