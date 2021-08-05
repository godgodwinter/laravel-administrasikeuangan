@extends('layouts.layoutadmin1')

@section('title','Siswa')
@section('halaman','siswa')

@section('csshere')
@endsection

@section('jshere')
@endsection


@section('notif')


@if (session('tipe'))
        @php
        $tipe=session('tipe');    
        @endphp
@else
        @php
            $tipe='light';
        @endphp
@endif

@if (session('icon'))
        @php
        $icon=session('icon');    
        @endphp
@else
        @php
            $icon='far fa-lightbulb';
        @endphp
@endif

@if (session('status'))

  <div class="alert alert-{{ $tipe }} alert-has-icon alert-dismissible show fade">
    <div class="alert-icon"><i class="{{ $icon }}"></i></div>
                      <div class="alert-body">
                        <div class="alert-title">{{ Str::ucfirst($tipe) }}</div>
                        <button class="close" data-dismiss="alert">
                          <span>&times;</span>
                        </button>
                        {{ session('status') }}
                      </div>
                    </div>
@endif
@endsection 

@section('container')

  <div class="section-body">

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
                            <th>Nama</th>
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
            
       
      
        </div>


     
      </div>
      <div class="col-12 col-md-12 col-lg-7">
        <div class="card">
            <form action="/admin/{{ $pages }}" method="post">
                @csrf
            <div class="card-header">
                <span class="btn btn-icon btn-light"><i class="fas fa-feather"></i> TAMBAH {{ Str::upper($pages) }}</span>
            </div>
            <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-6 col-6">
                    <label for="nis">NIS <code>*)</code></label>
                    <input type="number" name="nis" id="nis" class="form-control @error('nis') is-invalid @enderror" value="{{old('nis')}}" required>
                    @error('nis')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>
                 
                  <div class="form-group col-md-6 col-6">
                    <label for="nama">Nama <code>*)</code></label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama')}}" required>
                    @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>
                 
                  <div class="form-group col-md-6 col-6">
                    <label for="tempatlahir">Tempat Lahir <code>*)</code></label>
                    <input type="text" name="tempatlahir" id="tempatlahir" class="form-control @error('tempatlahir') is-invalid @enderror" value="{{old('tempatlahir')}}" required>
                    @error('tempatlahir')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label>Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tgllahir" @error('tgllahir') is-invalid @enderror" value="{{old('tgllahir')}}" >
                    @error('tgllahir')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label>Agama <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="agama"> 
                      @if (old('agama'))
                      <option>{{old('agama')}}</option>                        
                      @endif
                      <option>Islam</option>
                      <option>Kristen</option>
                      <option>Katholik</option>
                      <option>Hindu</option>
                      <option>Budha</option>
                      <option>Konghucu</option>
                      <option>Lain-lain</option>
                    </select>
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="alamat">Alamat <code>*)</code></label>
                    <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{old('alamat')}}" required>
                    @error('alamat')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>


                  <div class="form-group col-md-6 col-6">
                    <label>Tahun Pelajaran <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="tapel_nama">  
                          @if (old('tapel_nama'))
                          <option>{{old('tapel_nama')}}</option>                        
                          @endif
                      @foreach ($tapel as $t)
                          <option>{{ $t->nama }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label>Kelas <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="kelas_nama">
                          @if (old('kelas_nama'))
                          <option>{{old('kelas_nama')}}</option>                        
                          @endif
                      @foreach ($kelas as $k)
                          <option>{{ $k->nama }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group col-md-12 col-12">
                    <label for="email">Email <code>*)</code></label>
                    <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" onblur="duplicateEmail(this)"  required>
                    @error('email')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="password">Password <code>*)</code></label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="password2">Konfirmasi Password <code>*)</code></label>
                    <input type="password" name="password2" id="password2" class="form-control @error('password2') is-invalid @enderror"  required>
                    @error('password2')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
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
