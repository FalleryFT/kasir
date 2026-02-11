<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        .quantity-control {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            border-radius: 5px;
            padding: 3px;
        }

        .quantity-control button {
            border: none;
            background: transparent;
            font-size: 18px;
            padding: 5px 10px;
        }

        .search {
            border-radius: 6px;
            width: 60%;
            height: 40px;
        }

        .abu {
            color: #6b7175;
        }

        .SEbutton {
            border: 2px solid #E6E9EC;
            border-radius: 8px;
        }

        .SEbutton:hover {
            border: 2px solid black;
        }

        .Sbutton {
            border: 2px solid #E6E9EC;
            border-radius: 0 8px 8px 0;
        }

        .Sbutton:hover {
            border: 2px solid black;
        }

        .Ebutt {
            border: 1px solid #E6E9EC;
        }

        .Ebutt:hover {
            transform: scale(1.3);
        }

        h2 {
            font-size: 46px;
        }

        h4 {
            font-size: 36px;
        }

        .txt18 {
            font-size: 18;
        }

        .txt12 {
            font-size: 12px;
        }

        .bt {
            background-color: white;
            border: 2px solid white;
            border-radius: 8px;
            font-size: 24px;
        }

        .bt:hover {
            border: 2px solid black;
        }

        .form-control {
            border: 2px solid white;
        }

        .form-control:focus {
            border: 2px solid black;
            box-shadow: none;
        }

        .search:focus {
            border: 2px solid black;
        }
    </style>
</head>

<body style="font-family: 'Poppins', sans-serif; background-color: #f5f5f5;">
    <div class="row text-black" style="min-height: 100vh;">
        <div class="col-md-8 mt-4">
            <div class="ms-4 me-2">
                <h2 class=" d-flex justify-content-between"><b>Hallo, {{ auth()->user()->username }}</b>
                    <form id="logout-form" method="GET" action="{{ route('dashboard') }}">
                        @csrf
                        <button type="submit" class="btn btn-icon icon-left text-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                <path fill-rule="evenodd"
                                    d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                            </svg> Keluar
                        </button>
                    </form>                    
                </h2>

                <!-- Input ID Barang -->
                <form action="{{ route('kasir.addItem') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="search" class="form-label mt-2 txt18">ID Barang</label>
                        <div class="input-group">
                            <input type="text" name="id_barang" class="search border p-3" id="search"
                                placeholder="Masukkan ID Barang">
                            <button class="SEbutton ms-2" type="submit">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.8333 22.1667C17.988 22.1667 22.1667 17.988 22.1667 12.8333C22.1667 7.67868 17.988 3.5 12.8333 3.5C7.67868 3.5 3.5 7.67868 3.5 12.8333C3.5 17.988 7.67868 22.1667 12.8333 22.1667Z"
                                        stroke="black" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M24.5 24.5L19.425 19.425" stroke="black" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Detail Pembeli -->
                @if (session('member'))
                    <div class="card p-3 mb-3 border-none text-white rounded" style="background-color: #707ff7">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-0 txt18">#{{ session('member')->id }}</h6>
                            <span class="txt18">{{ now()->format('d F Y') }}</span>
                        </div>
                        <table class="w-100 text18">
                            <tr>
                                <td><strong>ID Pembeli</strong></td>
                                <td>:</td>
                                <td>#{{ session('member')->id }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nama Pembeli:</strong></td>
                                <td>:</td>
                                <td>{{ session('member')->nama_pelanggan }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tipe Pembeli:</strong></td>
                                <td>:</td>
                                <td>{{ session('member')->tipe }}</td>
                            </tr>
                            <tr>
                                <td><strong>Poin Pembeli:</strong></td>
                                <td>:</td>
                                <td>{{ session('member')->poin }}</td><br>
                            </tr>
                        </table>
                    </div>
                @endif

                <!-- Barang di Keranjang -->
                <h4 class="mb-3">Barang Di Keranjang</h4>
                <div class="container p-0">
                    <div class="row row-cols-2 row-cols-md-2 row-cols-lg-4 p-0 mb-4">
                        @foreach (session('cart', []) as $id => $item)
                            <div class="col mb-2">
                                <div class="card py-2 px-1 border h-100">
                                    <div class="card-body p-1">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-0 txt18">{{ $item['nama'] }}</h6>
                                            <span
                                                class="badge text-white bg-success">{{ $item['diskon'] > 0 ? $item['diskon'] . '%' : '' }}</span>
                                        </div>
                                        <p class="text-muted txt12 mb-1">#{{ $item['kode_produk'] ?? 'N/A' }}</p>

                                        @if ($item['diskon'] > 0)
                                            <p class="mb-1">
                                                <del
                                                    class="text-danger">Rp{{ number_format($item['harga_asli'], 0, ',', '.') }}</del>
                                                <br>
                                                <strong>RP {{ number_format($item['harga'], 0, ',', '.') }}</strong>
                                            </p>
                                        @else
                                            <p class="mb-1"><strong>RP
                                                    {{ number_format($item['harga'], 0, ',', '.') }}</strong></p>
                                        @endif
                                    </div>

                                    <!-- Bagian Quantity Control dipindahkan ke card-footer agar selalu menempel di bawah -->
                                    <div
                                        class="card-footer bg-white border-0 quantity-control d-flex justify-content-between align-items-center">
                                        <form
                                            action="{{ route('kasir.updateItem', ['id' => $id, 'action' => 'increment']) }}"
                                            method="POST">
                                            @csrf
                                            <button class="btn Ebutt" type="submit">
                                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12.8081 5.49677V19.4968" stroke="black" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M5.80811 12.4968H19.8081" stroke="black" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </button>
                                        </form>
                                        <span>{{ $item['jumlah'] }}</span>
                                        <form
                                            action="{{ route('kasir.updateItem', ['id' => $id, 'action' => 'decrement']) }}"
                                            method="POST">
                                            @csrf
                                            <button class="btn Ebutt" type="submit">
                                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5.80811 12.2125H19.8081" stroke="black" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Pembayaran -->
        <div class="col-md-4 rounded text-white mt-3 mb-4" style="background-color: #6777EF">
            <div class="p-4 border-none sticky-top text18">
                <h4>Detail Pembelian</h4>

                <!-- Input ID Member -->
                <form action="{{ route('kasir.setMember') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="id_member" class="form-control" placeholder="ID Member">
                        <button class="Sbutton" type="submit" style="width: 50px">
                            <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.8081 5.49677V19.4968" stroke="black" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M5.80811 12.4968H19.8081" stroke="black" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Checkbox Gunakan Poin -->
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" id="use_poin">
                    <label class="form-check-label" for="use_poin">Gunakan semua poin</label>
                </div>

                <h4 class="mt-4 mb-2">Rincian Pembelian</h4>
                <table class="w-100">
                    <tr>
                        <td>Items</td>
                        <td class="text-end">{{ array_sum(array_column(session('cart', []), 'jumlah')) }}</td>
                    </tr>
                    <tr>
                        <td>SubTotal</td>
                        <td class="text-end">RP
                            {{ number_format(array_sum(array_map(fn($item) => $item['harga_asli'] * $item['jumlah'], session('cart', []))), 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Diskon Produk</td>
                        <td class="text-end">-RP
                            {{ number_format(array_sum(array_map(fn($item) => ($item['harga_asli'] - $item['harga']) * $item['jumlah'], session('cart', []))), 0, ',', '.') }}
                        </td>
                    </tr>

                    <tr id="poin_row" style="display: none;">
                        <td>Poin Belanja</td>
                        <td class="text-end">-RP <span id="poin_discount">0</span></td>
                    </tr>

                    <tr>
                        <td>Pajak PPN 12%</td>
                        <td class="text-end">RP
                            {{ number_format(array_sum(array_map(fn($item) => $item['harga'] * $item['jumlah'], session('cart', []))) * 0.12, 0, ',', '.') }}
                        </td>
                    </tr>
                </table>

                <hr class="mb-1" style="border: 2px solid white">
                <table class="w-100">
                    <tr>
                        <th>Total</th>
                        <th class="text-end">RP <span id="total_harga">
                                {{ number_format(array_sum(array_map(fn($item) => $item['harga'] * $item['jumlah'], session('cart', []))) * 1.12, 0, ',', '.') }}
                            </span></th>
                    </tr>
                </table>
                <form action="{{ route('kasir.checkout') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="bayar" class="form-label mt-3 fw-semibold">Jumlah Uang</label>
                        <div class="input-group input-group-md">
                            <span class="input-group-text">Rp.</span>
                            <input type="text" id="bayar" name="pembayaran" class="form-control currency"
                                placeholder="Masukkan jumlah uang">
                        </div>
                        <div class="mt-2 p-2 bg-light rounded shadow-sm">
                            <h6 class="mb-0 text-black fw-bold">
                                Kembalian : <span class="text-dark">Rp</span>
                                <input type="text" id="kembalian" name="kembalian" class="form-control currency"
                                    readonly
                                    style="display: inline-block; width: auto; border: none; background: none; padding: 0;">
                            </h6>
                        </div>
                    </div>


                    <input type="hidden" name="poin_use" id="poin_use_input" value="0">
                    <button class="bt p-1 w-100 mt-3 abu" type="submit"><b>Bayar Sekarang</b></button>
                </form>
            </div>
        </div>
    </div>

    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const usePoinCheckbox = document.getElementById("use_poin");
            const poinRow = document.getElementById("poin_row");
            const poinDiscountSpan = document.getElementById("poin_discount");
            const totalHargaSpan = document.getElementById("total_harga");
            const poinUseInput = document.getElementById("poin_use_input");

            // Simulasi nilai poin pembeli (seharusnya diambil dari session/member)
            let maxPoin = {{ session('member')->poin ?? 0 }};
            let totalHarga = parseInt(totalHargaSpan.innerText.replace(/\D/g, ""));

            usePoinCheckbox.addEventListener("change", function() {
                if (this.checked) {
                    let poinDiscount = Math.min(maxPoin * 1, totalHarga); // 1 poin = Rp 1
                    poinRow.style.display = "table-row";
                    poinDiscountSpan.innerText = poinDiscount.toLocaleString("id-ID");
                    totalHargaSpan.innerText = (totalHarga - poinDiscount).toLocaleString("id-ID");
                    poinUseInput.value = poinDiscount;
                } else {
                    poinRow.style.display = "none";
                    totalHargaSpan.innerText = totalHarga.toLocaleString("id-ID");
                    poinUseInput.value = 0;
                }
            });

            
        });

        document.getElementById('bayar').addEventListener('input', function() {
            let totalHarga = parseInt(document.getElementById('total_harga').innerText.replace(/\./g, '')) || 0;
            let jumlahBayar = parseInt(this.value.replace(/\D/g, '')) || 0;
            let kembalian = jumlahBayar - totalHarga;

            document.getElementById('kembalian').value = kembalian > 0 ? kembalian.toLocaleString('id-ID') : 0;
        });

        src = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    </script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Alert untuk error
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}'
        });
    @endif
</script>
</body>
</html>
