@extends('admin.layout.dashboard')

<link rel="stylesheet" href="{{ asset('assets/css/sb-admin-2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Homestay</h1>
        <p>Homestay yang anda miliki</p>
        @if ($akun->no_telephone == 0)
            <div class="alert alert-primary" role="alert">
                Profile Anda belum lengkap, lengkapi terlebih dahulu dengan klik tombol dibawah
            </div>

            <a href="/profile_admin" class="btn btn-primary mb-4">Lengkapi Profil</a>
            {{-- <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#exampleModal">Lengkapi Profil</button> --}}
        @else
            <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#exampleModal">Tambah Homestay</button>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">List Homestay</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Harga</th>
                                    <th>Penjemputan</th>
                                    <th>Gambar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($homestays as $homestay)
                                    <tr>
                                        <td>{{ $homestay->nama }}</td>
                                        <td>{{ $homestay->alamat }}</td>
                                        <td>{{ $homestay->harga }}</td>
                                        <td>
                                            @if (count($transportasi) < 1)
                                                <p>belum ada transportasi</p>
                                                <button class="btn btn-outline-primary" data-toggle="modal"
                                                    data-target="#transportasi{{$homestay->id}}">Tambah Transportasi</button>

                                                {{-- modal transportasi --}}
                                                <div class="modal fade" id="transportasi{{$homestay->id}}" tabindex="-1"
                                                    aria-labelledby="transportasiLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="transportasiLabel">Tambah
                                                                    Transportasi</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="/transportasi/store"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="hidden" name="homestay_id"
                                                                        value="{{$homestay->id}}">
                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1">Nama Supir</label>
                                                                        <input type="text" class="form-control"
                                                                            id="exampleInputEmail1"
                                                                            aria-describedby="emailHelp" name="nama_supir">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="exampleFormControlSelect1">Nama
                                                                            transportasi</label>
                                                                        <select class="form-control"
                                                                            id="exampleFormControlSelect1"
                                                                            name="nama_transportasi">
                                                                            <option>Mobil</option>
                                                                            <option>Sepeda Motor</option>
                                                                            <option>Becak</option>
                                                                        </select>

                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="harga">Harga</label>
                                                                        <input type="number" class="form-control"
                                                                            id="harga" name="harga">
                                                                    </div>

                                                                    <div class="custom-file mb-3">
                                                                        <input type="file" class="custom-file-input"
                                                                            id="validatedCustomFile" required
                                                                            name="foto">
                                                                        <label class="custom-file-label"
                                                                            for="validatedCustomFile">Tambahkan foto
                                                                            transportasi</label>
                                                                    </div>
                                                                    <button type="submit"
                                                                        class="btn btn-primary btn-block">Submit</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <p>sudah memiliki transportasi</p>
                                                <a href="assets/images/{{ $transportasi[0]->foto }}">Gambar Transportasi</a> <br>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="assets/images/{{ $homestay->gambar }}">{{ $homestay->gambar }}</a> <br>
                                            @foreach ($homestay->foto as $item)
                                                <a href="assets/images/{{ $item['nama'] }}">{{ $item['nama'] }}</a> <br>
                                            @endforeach
                                            <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                                                data-target="#tambahfoto{{ $homestay->id }}">Tambah Foto</button>
                                        </td>
                                        <div class="modal fade" id="tambahfoto{{ $homestay->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Foto
                                                            {{ $homestay->nama }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="/homestay/foto/{{ $homestay->id }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <div id="product_image">
                                                                <div class="custom-file mb-3">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="validatedCustomFile" name="gambar[]">
                                                                    <label class="custom-file-label"
                                                                        for="validatedCustomFile">Choose file...</label>
                                                                </div>
                                                                <div class="custom-file mb-3">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="validatedCustomFile" name="gambar[]">
                                                                    <label class="custom-file-label"
                                                                        for="validatedCustomFile">Choose file...</label>
                                                                </div>
                                                                <div class="custom-file mb-3">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="validatedCustomFile" name="gambar[]">
                                                                    <label class="custom-file-label"
                                                                        for="validatedCustomFile">Choose file...</label>
                                                                </div>
                                                            </div>
                                                            <button type="submit"
                                                                class="btn btn-primary btn-block">Submit</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-4 mr-1">
                                                    <button type="button" class="btn btn-outline-success"
                                                        data-toggle="modal"
                                                        data-target="#exampleModal{{ $homestay->id }}">Edit</button>
                                                </div>
                                                <div class="col-md-6">
                                                    <form action="/homestay/destroy/{{ $homestay->id }}" method="post">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-outline-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                        <div class="modal fade" id="exampleModal{{ $homestay->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit
                                                            {{ $homestay->nama }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="/homestay/update/{{ $homestay->id }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Nama Homestay</label>
                                                                <input type="text" class="form-control"
                                                                    id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                    name="nama" value="{{ $homestay->nama }}">
                                                                <small id="emailHelp" class="form-text text-muted">Berikan
                                                                    nama yang bagus untuk homestay
                                                                    anda!</small>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="alamat">Alamat</label>
                                                                <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $homestay->alamat }}</textarea>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="harga">Harga</label>
                                                                <input type="number" class="form-control" id="harga"
                                                                    name="harga" value="{{ $homestay->harga }}">
                                                                <small id="emailHelp" class="form-text text-muted">Harga
                                                                    homestay perhari</small>
                                                            </div>

                                                            <div class="custom-file mb-5">
                                                                <input type="file" class="custom-file-input"
                                                                    id="validatedCustomFile" name="gambar">
                                                                <label class="custom-file-label"
                                                                    for="validatedCustomFile">Choose file...</label>
                                                                <small id="emailHelp"
                                                                    class="form-text text-muted">Optional</small>
                                                            </div>
                                                            <button type="submit"
                                                                class="btn btn-primary btn-block">Submit</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif



    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Homestay</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/homestay/store" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Homestay</label>
                            <input type="text" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" name="nama">
                            <small id="emailHelp" class="form-text text-muted">Berikan nama yang bagus untuk homestay
                                anda!</small>
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga">
                            <small id="emailHelp" class="form-text text-muted">Harga homestay perhari</small>
                        </div>

                        <div class="custom-file mb-3">
                            <input type="file" class="custom-file-input" id="validatedCustomFile" required
                                name="gambar">
                            <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

<script src="{{ asset('assets/js/table.js') }}"></script>
<script src="{{ asset('assets/js/table2.js') }}"></script>
