@extends('layouts.layoutadmin1')

@section('title','Beranda')
@section('halaman','Index')

@section('csshere')
@endsection

@section('jshere')
@endsection
{{-- 
@section('headernav')
@endsection

@section('notif')
@endsection --}}

@section('container')

{{-- HEADER-START --}}
<div class="section-header">
    <h1>@yield('title')</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        {{-- <div class="breadcrumb-item"><a href="#">Bootstrap Components</a></div> --}}
      <div class="breadcrumb-item">@yield('halaman')</div>
    </div>
  </div>
  {{-- HEADER-END --}}

{{-- <div class="section-header">
    <h1>Typography</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="#">Bootstrap Components</a></div>
      <div class="breadcrumb-item">Typography</div>
    </div>
  </div> --}}


  <div class="section-body">
    <h2 class="section-title">Hi, {{ Auth::user()->name }}!</h2>
    <p class="section-lead">
     Berikut beberapa Informasi tetang data di Sistem Ini.
    </p>

    <div class="row mt-sm-4">
      <div class="col-12 col-md-12 col-lg-5">
        <div class="card profile-widget">
          <div class="profile-widget-header">
            <img alt="image" src="../assets/img/products/product-3-50.png" class="rounded-circle profile-widget-picture">
            <div class="profile-widget-items">
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Kelas</div>
                <div class="profile-widget-item-value">187</div>
              </div>
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Siswa</div>
                <div class="profile-widget-item-value">6,8K</div>
              </div>
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Lunas</div>
                <div class="profile-widget-item-value">2,1K</div>
              </div>
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Belum Lunas</div>
                <div class="profile-widget-item-value">2,1K</div>
              </div>
            </div>
          </div>

          <div class="card-footer text-center">
            <div class="font-weight-bold mb-2">Lihat Selengkapnya</div>
            <a href="#" class="btn btn-info mr-1">
              <i class="fas fa-angle-double-right"></i>
            </a>
            
          </div>
       
      
        </div>


        <div class="card profile-widget mt-5">
            <div class="profile-widget-header">
              <img alt="image" src="../assets/img/products/product-4-50.png" class="rounded-circle profile-widget-picture">
              <div class="profile-widget-items">
             
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Pemasukan</div>
                  <div class="profile-widget-item-value">2,1K</div>
                </div>
                <div class="profile-widget-item">
                  <div class="profile-widget-item-label">Pengeluaran</div>
                  <div class="profile-widget-item-value">2,1K</div>
                </div>
              </div>
            </div>
            <div class="card-footer text-center">
                <div class="font-weight-bold mb-2">Lihat Selengkapnya</div>
                <a href="#" class="btn btn-info mr-1">
                  <i class="fas fa-angle-double-right"></i>
                </a>
                
              </div>
        
          </div>
      </div>
      <div class="col-12 col-md-12 col-lg-7">
        <div class="card">
          <form method="post" class="needs-validation" novalidate="">
            <div class="card-header">
              <h4>Pemasukan</h4>
            </div>
            <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-6 col-12">
                    <label>Nama Transaksi</label>
                    <input type="text" class="form-control" value="Dana BOS ke-1" required="">
                    <div class="invalid-feedback">
                      Please fill in the first name
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-12">
                    <label>Nominal</label>
                    <input type="text" class="form-control" value="Rp 10.000.000" required="">
                    <div class="invalid-feedback">
                      Please fill in the last name
                    </div>
                  </div>
                </div>
             
           
                <div class="row">
                  <div class="form-group mb-0 col-12">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" id="newsletter">
                  
                      
                    </div>
                  </div>
                </div>
            </div>
            <div class="card-footer text-right">
              <button class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>


        <div class="card">
            <form method="post" class="needs-validation" novalidate="">
              <div class="card-header">
                <h4>Pengeluaran</h4>
              </div>
              <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-6 col-12">
                      <label>Nama Transaksi</label>
                      <input type="text" class="form-control" value="Dana Perbaikan Pagar" required="">
                      <div class="invalid-feedback">
                        Please fill in the first name
                      </div>
                    </div>
                    <div class="form-group col-md-6 col-12">
                      <label>Nominal</label>
                      <input type="text" class="form-control" value="Rp 2.000.000" required="">
                      <div class="invalid-feedback">
                        Please fill in the last name
                      </div>
                    </div>
                  </div>
               
             
                  <div class="row">
                    <div class="form-group mb-0 col-12">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" id="newsletter">
                    
                        
                      </div>
                    </div>
                  </div>
              </div>
              <div class="card-footer text-right">
                <button class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>

      </div>
    </div>
  </div>
@endsection
