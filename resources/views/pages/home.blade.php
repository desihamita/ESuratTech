<x-Layouts.main.app :title="$title">
    <div class="content-header">
        <x-breadcrumb :title="$title" :breadcrumbs="$breadcrumbs" />
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <section class="col-lg-8 connectedSortable">
          <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="text-primary">{{ $greeting }}, {{ Auth::user()->name }}!</h1>
                        <h5>{{ $today }}</h5>
                        <p><small>Laporan hari ini</small></p>
                    </div>
                    <div>
                        <img src="{{ asset('assets/dist/img/freepik.png') }}" alt="Admin Image" style="width: 150px;">
                    </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Sales</h3>
                    <a href="javascript:void(0);">View Report</a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex">
                    <p class="d-flex flex-column">
                      <span class="text-bold text-lg">$18,230.00</span>
                      <span>Sales Over Time</span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right">
                      <span class="text-success">
                        <i class="fas fa-arrow-up"></i> 33.1%
                      </span>
                      <span class="text-muted">Since last month</span>
                    </p>
                  </div>

                  <div class="position-relative mb-4">
                    <canvas id="sales-chart" height="200"></canvas>
                  </div>

                  <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                      <i class="fas fa-square text-primary"></i> This year
                    </span>

                    <span>
                      <i class="fas fa-square text-gray"></i> Last year
                    </span>
                  </div>
                </div>
              </div>
          </section>
          <section class="col-lg-4 connectedSortable">
              <x-small-box 
              :countletterin="$countLeters_in" 
              :countletterout="$countLeters_out" 
              :useraktif="$useraktif"
              />
          </section>

        </div>
      </div>
    </section>
</x-Layouts.main.app>
