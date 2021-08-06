@extends('layouts.layoutadmin1')

@section('title','Tagihan Siswa')
@section('halaman','tagihansiswa')

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
    <p class="section-lead">
     Menu untuk Melakukan Pembayaran Tagihan siswa.
    </p>

    <div class="row mt-sm-4">
      <div class="col-12 col-md-12 col-lg-12">
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
              <div class="profile-widget-item">
                <form action="/admin/{{ $pages }}/sync" method="post" class="d-inline">
                  @csrf
                  <button 
                      onclick="return  confirm('Anda yakin melakukan sinkronisasi data ? Y/N')" class="btn btn-icon icon-left btn-primary" data-toggle="tooltip" data-placement="top" title="Akan mengambil data siswa dan tagihan atur yang belum dimasukkan kedalam tagihan siswa!"><i class="fas fa-retweet"></i> Sinkronisasi Data</button>
              </form>
{{--                
                <div class="profile-widget-item-label">Jumlah Data</div>
                <div class="profile-widget-item-value">{{ $jmldata }} Data</div> --}}
              </div>
            </div>
          </div>

           
        
                  
                    <div class="card-body -mt-5">
                      <div class="table-responsive">
                        <table class="table table-bordered table-md">
                          <tr>
                            <th width="5%" class="text-center">#</th>
                            <th width="5%" >Bayar</th>
                            <th>Nama</th>
                            <th>Tahun</th>
                            <th>Kelas</th>
                            <th>Nominal Tagihan</th>
                            <th>Terbayar</th>
                            <th>Kurang</th>
                            <th width="10%"  class="text-center">%</th>
                            {{-- <th width="15%" class="text-center">Aksi</th> --}}
                          </tr>

                        @foreach ($datas as $data)
                        @php
                          $sumdetailbayar = DB::table('tagihansiswadetail')
                            ->where('tagihansiswa_id', '=', $data->id)
                            ->sum('nominal');
                            $kurang=$data->nominaltagihan-$sumdetailbayar;
                            $persen=number_format(($sumdetailbayar/$data->nominaltagihan*100),2);
                              $warna='light';
                              $icon='fas fa-times';
                            if($persen=='100'){
                              $warna='success';
                              $icon='fas fa-check';
                            }
                       @endphp
                          <tr>
                            <td  class="text-center">{{ ($loop->index)+1 }}</td>
                            <td class="text-center">
                              <button class="btn btn-icon btn-{{ $warna }}" data-toggle="modal" data-target="#modalbayar{{ $data->id }}" ><i class="far fa-money-bill-alt"></i></button>
                            </td>
                            <td class="text-left">{{ $data->siswa_nis }} - {{ $data->siswa_nama }}</td>
                            <td class="text-left">{{ $data->tapel_nama }}</td>
                            <td class="text-left">{{ $data->kelas_nama }}</td>
                            <td class="text-left">@currency($data->nominaltagihan)</td>
                            <td class="text-left">@currency($sumdetailbayar)</td>
                            <td>@currency($kurang)</td>
                            <td class="text-center">

                      <span class="btn btn-icon icon-left btn-{{ $warna }}"><i class="{{ $icon }}"></i> {{ $persen }} %</span>
                             
                            </td>
                          
                            {{-- <td class="text-center">
                                <a href="/admin/{{ $pages }}/{{$data->id}}"  class="btn btn-icon icon-left btn-info"><i class="fas fa-edit"></i> Detail</a>
                              <form action="/admin/{{ $pages }}/{{$data->id}}" method="post" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-icon btn-danger"
                                        onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"><span
                                            class="pcoded-micon"> <i class="fas fa-trash"></i></span></button>
                                </form>
                            </td> --}}
                          </tr>
                          @endforeach
                        
                        </table>
                      </div>
                    </div>
            
       
      
        </div>


     
      </div>

    </div>
  </div>
@endsection


@section('container-modals')

@foreach ($datas as $data)
@php
$sumdetailbayar = DB::table('tagihansiswadetail')
  ->where('tagihansiswa_id', '=', $data->id)
  ->sum('nominal');
  $kurang=$data->nominaltagihan-$sumdetailbayar;
  $persen=number_format(($sumdetailbayar/$data->nominaltagihan*100),2);
@endphp
    <div class="modal fade" tabindex="-1" role="dialog" id="modalbayar{{ $data->id }}">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Pembayaran "{{ $data->siswa_nis }} - {{ $data->siswa_nama }}"</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            {{-- <p>Modal body text goes here.</p> --}}

            <form action="/admin/{{ $pages }}/bayartagihan/{{ $data->id }}" method="post">
              @csrf
            <div class="form-group">

              @if (old('nominal'))
              @php                    
                $nominal=old('nominal');
              @endphp
          @else
              @php
              $nominal=0;
              @endphp                    
          @endif

          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">Sisa Tagihan :
              </div>
            </div>  
             <input type="text" class="form-control-plaintext" readonly="" value="@currency($kurang)" >
          </div>
          <div class="input-group">
            <div class="input-group-prepend">
              <div class="input-group-text">Nominal Bayar:
              </div>
            </div>  
             <input type="text" name="labelrupiah" min="0" id="labelrupiah{{ $data->id }}" class="form-control-plaintext" readonly="" value="@currency($nominal)" >
          </div>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="far fa-money-bill-alt""></i>
                  </div>
                </div>
                <input type="number" class="form-control  @error('nominal') is-invalid @enderror" name="nominal" id="rupiah{{ $data->id }}" value="{{ $nominal }}"  required>

                  @error('nominal')<div class="invalid-feedback"> {{$message}}</div>
                  @enderror
              </div>

            </div>


          <script type="text/javascript">
            
            var rupiah{{ $data->id }} = document.getElementById('rupiah{{ $data->id }}');
            var labelrupiah{{ $data->id }} = document.getElementById('labelrupiah{{ $data->id }}');
            rupiah{{ $data->id }}.addEventListener('keyup', function(e){
              // tambahkan 'Rp.' pada saat form di ketik
              // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
              // rupiah.value = formatRupiah(this.value, 'Rp. ');
              labelrupiah{{ $data->id }}.value = formatRupiah(this.value, 'Rp. ');
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
        
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Bayar</button>
            </form>
          </div>
          <div class="modal-body">
            {{-- <p>Modal body text goes here.</p> --}}
            <div class="table-responsive">
              <table class="table table-bordered table-md">
                <tr>
                  <th width="5%" class="text-center">Pembayaran ke-</th>
                  <th>Nominal</th>
                  <th width="5%" class="text-center">Aksi</th>
                </tr>
                @php
                    $detailbayar = DB::table('tagihansiswadetail')
                      ->where('tagihansiswa_id', '=', $data->id)
                      ->get();
                @endphp
                @foreach ($detailbayar as $db)
                    
                <tr>
                  <td  class="text-center">{{ ($loop->index)+1 }}</td>
                  <td class="text-left">
                    @currency($db->nominal)</td>
                  <td class="text-center"> 
                    <form action="/admin/{{ $pages }}/bayartagihan/{{$db->id}}/hapus  " method="post" class="d-inline">
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
    </div>
  @endforeach

@endsection
