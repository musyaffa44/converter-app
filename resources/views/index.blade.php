<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- arrow icon -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- hamburger icon -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body class="antialiased">
    <div class="d-flex flex-column justify-content-center align-items-center pt-5">

        @isset($status)
            @if ($status)
                <div class="alert alert-success alert-dismissible fade show" style="width: 40%;" role="alert">
                    Konversi <strong>berhasil</strong> dilakukan!.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @else
                <div class="alert alert-danger alert-dismissible fade show" style="width: 40%;" role="alert">
                    Konversi <strong>gagal</strong> karena
                    @if ($jenis == 'ke_produk')
                        bahan baku
                    @elseif ($jenis == 'ke_bahan')
                        jumlah produk yang ingin dikonversi
                    @endif
                    tidak mencukupi.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        @endisset
        <div class="card border-primary mt-1" style="width: 40%">
            <div class="card-header text-center fw-bold fs-4">
                Konversi
            </div>
            <div class="card-body">
                <form action="/konversi" class="needs-validation" method="POST" novalidate>
                    @csrf
                    <div class="my-3 row">
                        <label for="jenis" class="col-sm-4 col-form-label">Jenis Konversi</label>
                        <div class="col-sm-8">
                            <select name="jenis" class="form-select form-select-sm" aria-label=".form-select-sm" id="jenis"
                                required>
                                <option selected disabled value="">Pilih jenis konversi</option>
                                <option value="ke_produk">
                                    Ke Produk
                                </option>
                                <option value="ke_bahan">
                                    Ke Bahan Baku
                                </option>
                            </select>
                            <div class="invalid-feedback">
                                Silhakan pilih <strong>jenis konversi</strong> terlebih dahulu
                            </div>
                        </div>
                    </div>
                    <div class="my-3 row">
                        <label for="produk" class="col-sm-4 col-form-label">Produk</label>
                        <div class="col-sm-8">
                            <select name="produk" class="form-select form-select-sm"
                                aria-label=".form-select-sm example" id="produk" required>
                                <option selected disabled value="">Pilih produk</option>
                                @foreach ($produk as $item)
                                    <option value={{ $item->id }}> {{ $item->nama_produk }} </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Silhakan pilih <strong>produk</strong> terlebih dahulu
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jumlah" class="col-sm-4 col-form-label">Jumlah</label>
                        <div class="col-sm-8">
                            <input type="number" name="jumlah" class="form-control" id="jumlah" required>
                            <div class="invalid-feedback">
                                Silhakan isi <strong>jumlah yang ingin dikonversi</strong> terlebih dahulu
                            </div>
                        </div>
                    </div>
                    <div class="d-grid mt-4">
                        <button class="btn btn-primary" type="submit">Konversi</button>
                    </div>
                </form>
            </div>
        </div>
        @if (isset($status) && $status)
            <div class="card border-info mt-3" style="width: 40%;">
                <div class="card-header text-center fw-bold fs-5">
                    Detail
                </div>
                <div class="card-body">
                    <p class="card-text">
                    <table>
                        @if ($jenis == 'ke_bahan')
                            @foreach ($result as $item)
                                <div class="row text-center">
                                    <div class="col-4 text-start text-capitalize">
                                        {{ $item['nama_bahan_baku'] }}
                                    </div>
                                    <div class="col-1">
                                        :
                                    </div>
                                    <div class="col-3">
                                        {{ $item['stok'] }}
                                    </div>
                                    <div class="col-1">
                                        <img src="{{ asset('/img/arrow.svg') }}" alt="" height="20px">
                                    </div>
                                    <div class="col-3">
                                        {{ $item['stok'] + $item['totalkeb'] }}
                                    </div>
                                </div>
                            @endforeach
                        @elseif ($jenis == 'ke_produk')
                            <div class="row text-center">
                                <div class="col-4 text-start text-capitalize">
                                    {{ $result['nama_produk'] }}
                                </div>
                                <div class="col-1">
                                    :
                                </div>
                                <div class="col-3">
                                    {{ $result['stok_sebelum'] }}
                                </div>
                                <div class="col-1">
                                    <img src="{{ asset('/img/arrow.svg') }}" alt="" height="20px">
                                </div>
                                <div class="col-3">
                                    {{ $result['stok_setelah'] }}
                                </div>
                            </div>
                        @endif
                    </table>
                    </p>
                </div>
            </div>
        @endif
    </div>
    <div id="detail"></div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script>
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>

</html>
