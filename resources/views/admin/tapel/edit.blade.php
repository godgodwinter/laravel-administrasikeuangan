@extends('layouts.layoutadmin1')

@section('title','Tahun Pelajaran')
@section('halaman','Tapel')

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

 

{{-- <div class="section-header">
    <h1>Typography</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="#">Bootstrap Components</a></div>
      <div class="breadcrumb-item">Typography</div>
    </div>
  </div> --}}


  <div class="section-body">
    {{-- <h2 class="section-title">Hi, {{ Auth::user()->name }}!</h2>
    <p class="section-lead">
     Berikut beberapa Informasi tetang data di Sistem Ini.
    </p> --}}

    <div class="row mt-sm-4">
      <div class="col-12 col-md-12 col-lg-5">
        <div class="card profile-widget">
          <div class="profile-widget-header">
            <img alt="image" src="{{ asset("assets/") }}/img/products/product-3-50.png" class="rounded-circle profile-widget-picture">
            <div class="profile-widget-items">
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Tabel </div>
                <div class="profile-widget-item-value">@yield('title')</div>
                {{-- <h4>Simple Table</h4> --}}
              </div>
              <div class="profile-widget-item">
                <div class="profile-widget-item-label">Jumlah Data</div>
                <div class="profile-widget-item-value">{{ $jmldata }} Data</div>
              </div>
            </div>
          </div>

           
        
                  
                    <div class="card-body -mt-5">
                      <div class="table-responsive">
                        <table class="table table-bordered table-md">
                          <tr>
                            <th width="5%" class="text-center">#</th>
                            <th>Tahun Pelajaran</th>
                            <th width="20%" class="text-center">Aksi</th>
                          </tr>

                        @foreach ($datas as $data)
                          <tr>
                            <td>{{ ($loop->index)+1 }}</td>
                            <td>{{ $data->nama }}</td>
                          
                            <td>
                              <a href="/admin/{{ $pages }}/{{$data->id}}" class="btn btn-icon btn-warning"><i class="fas fa-edit"></i></a>
                              {{-- <a href="#" class="btn btn-icon btn-danger"><i class="fas fa-trash"></i></a> --}}
                              <form action="/admin/{{ $pages }}/{{$data->id}}" method="post" class="d-inline">
                                  @method('delete')
                                  @csrf
                                  <button class="btn btn-icon btn-danger"
                                      onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"><span
                                          class="pcoded-micon"> <i class="fas fa-trash"></i></span></button>
                              </form>
                            </td>
                          </tr>
                          @endforeach
                        
                        </table>
                      </div>
                    </div>
                    {{-- <div class="card-footer text-right">
                      <nav class="d-inline-block">
                        <ul class="pagination mb-0">
                          <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                          </li>
                          <li class="page-item active"><a class="page-link" href="#">1 <span class="sr-only">(current)</span></a></li>
                          <li class="page-item">
                            <a class="page-link" href="#">2</a>
                          </li>
                          <li class="page-item"><a class="page-link" href="#">3</a></li>
                          <li class="page-item">
                            <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                          </li>
                        </ul>
                      </nav>
                    </div> --}}
            
       
      
        </div>


     
      </div>
      <div class="col-12 col-md-12 col-lg-7">

        <div class="card">
          <form action="/admin/{{  $pages }}/{{ $tapel->id}}" method="post">
              @method('put')
              @csrf
          <div class="card-header">
            <span class="btn btn-icon btn-light"><i class="fas fa-edit"></i> EDIT</span>
            {{-- <h4>Edit </h4> --}}
          </div>
          <div class="card-body">
              <div class="row">
                <div class="form-group col-md-12 col-12">
                  <label for="nama">Tahun Pelajaran</label>
                  <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Ex, 2020/2021" value="{{ $tapel->nama }}" required>
                  @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                  @enderror
                 
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
            <form action="/admin/{{ $pages }}" method="post">
                @csrf
            <div class="card-header">
              <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> TAMBAH</span>
            </div>
            <div class="card-body">
                <div class="row">
                  
                  <div class="form-group col-md-12 col-12">
                    <label for="nama">Tahun Pelajaran</label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Ex, 2020/2021" value="{{old('nama')}}" required>
                    @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
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
