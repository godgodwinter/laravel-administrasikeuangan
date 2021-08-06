@extends('layouts.layoutadmin1')

@section('title','Pengeluaran')
@section('halaman','pengeluaran')

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

<div class="row ">
  <div class="col-12 col-md-12 col-lg-12">
    <div class="card">
      <div class="card-body">
        <form action="{{ route('pengeluaran.cari') }}" method="GET">
          <div class="row">
              <div class="form-group col-md-2 col-2 mt-1 text-right">
                <input type="text" name="cari" id="cari" class="form-control form-control-sm @error('cari') is-invalid @enderror" value="{{$request->cari}}"  placeholder="Cari...">
                @error('cari')<div class="invalid-feedback"> {{$message}}</div>
                @enderror
              </div>

              <div class="form-group col-md-2 col-2 mt-1 text-right">
            
              <input type="month" class="form-control form-control-sm" name="yearmonth"  value="{{$request->yearmonth}}">
              </div>
              <div class="form-group  col-md-2 col-2 text-right">
         
              <select class="form-control form-control-sm" name="kategori_nama">  
                <option>{{$request->kategori_nama}}</option>
             
            @foreach ($kategori as $t)
                <option>{{ $t->nama }}</option>
            @endforeach
          </select>
              </div>
          <div class="form-group   text-right">
     
          <button type="submit" value="CARI" class="btn btn-icon btn-info btn-sm mt-1" ><span
          class="pcoded-micon"> <i class="fas fa-search"></i> Pecarian</span></button>

              </div>
           
         
        </form>
        <div class="form-group col-md-4 col-4 mt-1 text-right">
          {{-- <button type="submit" value="CARI" class="btn btn-icon btn-success btn-sm"><span
            class="pcoded-micon"> <i class="far fa-file-pdf"></i> Cetak PDF</span></button>

          <button type="submit" value="CARI" class="btn btn-icon btn-success btn-sm"><span
            class="pcoded-micon"> <i class="fas fa-upload"></i> Import</span></button>

          <button type="submit" value="CARI" class="btn btn-icon btn-success btn-sm"><span
            class="pcoded-micon"> <i class="fas fa-download"></i> Export </span></button> --}}



          </div>
      </div>
    </div>
  </div>
</div>
</div>
        
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
            </div>
          </div>

           
        
                  
                    <div class="card-body -mt-5">
                      <div class="table-responsive">
                        <table class="table table-bordered table-md">
                          <tr>
                            <th width="5%" class="text-center">#</th>
                            <th>Nama</th>
                            <th>Nominal</th>
                            <th width="100px" class="text-center">Aksi</th>
                          </tr>

                        @foreach ($datas as $data)
                          <tr>
                            <td>{{ ($loop->index)+1 }}</td>
                            <td>{{ $data->nama }}</td>
                            <td>@currency($data->nominal)</td>
                          
                            <td class="text-center">
                                <a href="/admin/{{ $pages }}/{{$data->id}}" class="btn btn-icon btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                {{-- <a href="#" class="btn btn-icon btn-danger"><i class="fas fa-trash"></i></a> --}}
                                <form action="/admin/{{ $pages }}/{{$data->id}}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-icon btn-danger btn-sm"
                                        onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"><span
                                            class="pcoded-micon"> <i class="fas fa-trash"></i></span></button>
                                </form>
                            </td>
                          </tr>
                          @endforeach
                        
                        </table>
                      </div>
                      <div class="card-footer text-right">
                        {{ $datas->links() }}
                      <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item"><i class="far fa-file"></i> Halaman ke-{{ $datas->currentPage() }}</li>
                          <li class="breadcrumb-item"><i class="fas fa-paste"></i> {{ $datas->total() }} Total Data</li>
                          <li class="breadcrumb-item active" aria-current="page"><i class="far fa-copy"></i> {{ $datas->perPage() }} Data Perhalaman</li>
                        </ol>
                      </nav>
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
                    <label for="nama">Nama <code>*)</code></label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama')}}" required>
                    @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  @if (old('nominal'))
                      @php                    
                        $nominal=old('nominal');
                      @endphp
                  @else
                      @php
                      $nominal=0;
                      @endphp                    
                  @endif
                  <div class="form-group col-md-6 col-6">
                    <label for="nominal">Nominal <code>*)</code> </label>
                    <input type="text" name="labelrupiah" min="0" id="labelrupiah" class="form-control-plaintext" readonly="" value="Rp 0,00" >
                    <input type="number" name="nominal" min="0" id="rupiah" class="form-control @error('nominal') is-invalid @enderror" value="{{ $nominal }}" required>
                    @error('nominal')<div class="invalid-feedback"> {{$message}}</div>
                    @enderror
                  </div>

                  <script type="text/javascript">
                    
                    var rupiah = document.getElementById('rupiah');
                    var labelrupiah = document.getElementById('labelrupiah');
                    rupiah.addEventListener('keyup', function(e){
                      // tambahkan 'Rp.' pada saat form di ketik
                      // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                      // rupiah.value = formatRupiah(this.value, 'Rp. ');
                      labelrupiah.value = formatRupiah(this.value, 'Rp. ');
                    });
                
                    /* Fungsi formatRupiah */
                    function formatRupiah(angka, prefix){
                      var number_string = angka.replace(/[^,\d]/g, '').toString(),
                      split   		= number_string.split(','),
                      sisa     		= split[0].length % 3,
                      rupiah     		= split[0].substr(0, sisa),
                      ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
                
                      // tambahkan titik jika yang di input sudah menjadi angka ribuan
                      if(ribuan){
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                      }
                
                      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                      return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
                    }
                  </script>
                 


                  <div class="form-group col-md-6 col-6">
                    <label>Kategori <code>*)</code></label>
                    <select class="form-control form-control-lg" required name="kategori_nama">  
                          @if (old('kategori_nama'))
                          <option>{{old('kategori_nama')}}</option>                        
                          @endif
                      @foreach ($kategori as $t)
                          <option>{{ $t->nama }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group col-md-6 col-6">
                    <label for="catatan">Catatan <code>*)</code></label>
                    <input type="text" name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror" value="{{old('catatan')}}" required>
                    @error('catatan')<div class="invalid-feedback"> {{$message}}</div>
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
