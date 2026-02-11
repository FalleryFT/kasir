@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <style>

    </style>
    <section class="section">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i><svg width="60" height="60" viewBox="0 0 100 100" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.75 87.5C18.75 87.5 12.5 87.5 12.5 81.25C12.5 75 18.75 56.25 50 56.25C81.25 56.25 87.5 75 87.5 81.25C87.5 87.5 81.25 87.5 81.25 87.5H18.75ZM50 50C54.9728 50 59.7419 48.0246 63.2583 44.5083C66.7746 40.9919 68.75 36.2228 68.75 31.25C68.75 26.2772 66.7746 21.5081 63.2583 17.9917C59.7419 14.4754 54.9728 12.5 50 12.5C45.0272 12.5 40.2581 14.4754 36.7417 17.9917C33.2254 21.5081 31.25 26.2772 31.25 31.25C31.25 36.2228 33.2254 40.9919 36.7417 44.5083C40.2581 48.0246 45.0272 50 50 50Z"
                                    fill="white" />
                            </svg>
                        </i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Petugas</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalPetugas }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i><svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22.5 30C25.4837 30 28.3452 28.8147 30.455 26.705C32.5647 24.5952 33.75 21.7337 33.75 18.75C33.75 15.7663 32.5647 12.9048 30.455 10.795C28.3452 8.68526 25.4837 7.5 22.5 7.5C19.5163 7.5 16.6548 8.68526 14.545 10.795C12.4353 12.9048 11.25 15.7663 11.25 18.75C11.25 21.7337 12.4353 24.5952 14.545 26.705C16.6548 28.8147 19.5163 30 22.5 30ZM3.75 52.5C3.75 52.5 0 52.5 0 48.75C0 45 3.75 33.75 22.5 33.75C41.25 33.75 45 45 45 48.75C45 52.5 41.25 52.5 41.25 52.5H3.75ZM41.25 13.125C41.25 12.6277 41.4475 12.1508 41.7992 11.7992C42.1508 11.4475 42.6277 11.25 43.125 11.25H58.125C58.6223 11.25 59.0992 11.4475 59.4508 11.7992C59.8025 12.1508 60 12.6277 60 13.125C60 13.6223 59.8025 14.0992 59.4508 14.4508C59.0992 14.8025 58.6223 15 58.125 15H43.125C42.6277 15 42.1508 14.8025 41.7992 14.4508C41.4475 14.0992 41.25 13.6223 41.25 13.125ZM43.125 22.5C42.6277 22.5 42.1508 22.6975 41.7992 23.0492C41.4475 23.4008 41.25 23.8777 41.25 24.375C41.25 24.8723 41.4475 25.3492 41.7992 25.7008C42.1508 26.0525 42.6277 26.25 43.125 26.25H58.125C58.6223 26.25 59.0992 26.0525 59.4508 25.7008C59.8025 25.3492 60 24.8723 60 24.375C60 23.8777 59.8025 23.4008 59.4508 23.0492C59.0992 22.6975 58.6223 22.5 58.125 22.5H43.125ZM50.625 33.75C50.1277 33.75 49.6508 33.9475 49.2992 34.2992C48.9475 34.6508 48.75 35.1277 48.75 35.625C48.75 36.1223 48.9475 36.5992 49.2992 36.9508C49.6508 37.3025 50.1277 37.5 50.625 37.5H58.125C58.6223 37.5 59.0992 37.3025 59.4508 36.9508C59.8025 36.5992 60 36.1223 60 35.625C60 35.1277 59.8025 34.6508 59.4508 34.2992C59.0992 33.9475 58.6223 33.75 58.125 33.75H50.625ZM50.625 45C50.1277 45 49.6508 45.1975 49.2992 45.5492C48.9475 45.9008 48.75 46.3777 48.75 46.875C48.75 47.3723 48.9475 47.8492 49.2992 48.2008C49.6508 48.5525 50.1277 48.75 50.625 48.75H58.125C58.6223 48.75 59.0992 48.5525 59.4508 48.2008C59.8025 47.8492 60 47.3723 60 46.875C60 46.3777 59.8025 45.9008 59.4508 45.5492C59.0992 45.1975 58.6223 45 58.125 45H50.625Z" fill="white"/>
                            </svg>                            
                        </i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Pelanggan</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalPelanggan }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i><svg width="50" height="50" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M97.05 18.5813C97.9201 18.9285 98.6662 19.5286 99.192 20.3039C99.7179 21.0793 99.9993 21.9944 100 22.9313V77.0688C99.9993 78.0056 99.7179 78.9208 99.192 79.6961C98.6662 80.4715 97.9201 81.0715 97.05 81.4188L51.7375 99.5438C50.6201 99.9907 49.3736 99.9907 48.2563 99.5438L2.94375 81.4188C2.07481 81.0705 1.33003 80.4701 0.805378 79.6948C0.280723 78.9195 0.000217875 78.0049 0 77.0688L0 22.9313C0.000217875 21.9952 0.280723 21.0805 0.805378 20.3052C1.33003 19.53 2.07481 18.9295 2.94375 18.5813L46.5187 1.15003L46.5813 1.13128L48.2563 0.456282C49.3755 0.00773669 50.6245 0.00773669 51.7438 0.456282L53.425 1.13128L53.4875 1.15003L97.05 18.5813ZM65.025 12.5L26.5625 27.8813L11.5375 21.875L6.25 23.9938V26.4938L46.875 42.7438V92.2563L50 93.5063L53.125 92.2563V42.75L93.75 26.5V24L88.4625 21.8813L50 37.2563L34.975 31.25L73.4375 15.8688L65.025 12.5Z" fill="white"/>
                            </svg>                            
                        </i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Stock</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalStock }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i><svg width="50" height="50" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M55.4175 0.31875C55.6733 0.48989 55.8831 0.721385 56.0283 0.992798C56.1735 1.26421 56.2496 1.56719 56.25 1.875V30C56.2499 30.3745 56.1377 30.7403 55.9278 31.0504C55.718 31.3605 55.4201 31.6007 55.0725 31.74L55.0612 31.7438L55.0388 31.755L54.9525 31.7888C54.4596 31.985 53.9633 32.1725 53.4637 32.3512C52.4737 32.7075 51.0975 33.1875 49.5375 33.6638C46.4775 34.6088 42.4912 35.625 39.375 35.625C36.1987 35.625 33.57 34.575 31.2825 33.6563L31.1775 33.6188C28.8 32.6625 26.775 31.875 24.375 31.875C21.75 31.875 18.2325 32.7375 15.2363 33.6638C13.8949 34.0826 12.5657 34.539 11.25 35.0325V58.125C11.25 58.6223 11.0525 59.0992 10.7008 59.4508C10.3492 59.8025 9.87228 60 9.375 60C8.87772 60 8.40081 59.8025 8.04918 59.4508C7.69754 59.0992 7.5 58.6223 7.5 58.125V1.875C7.5 1.37772 7.69754 0.900806 8.04918 0.549175C8.40081 0.197544 8.87772 0 9.375 0C9.87228 0 10.3492 0.197544 10.7008 0.549175C11.0525 0.900806 11.25 1.37772 11.25 1.875V2.9325C12.0975 2.63625 13.11 2.295 14.2125 1.9575C17.2725 1.02 21.2625 0 24.375 0C27.525 0 30.09 1.03875 32.3288 1.94625L32.49 2.01375C34.8225 2.955 36.855 3.75 39.375 3.75C42 3.75 45.5175 2.8875 48.5138 1.96125C50.2207 1.42676 51.9081 0.831384 53.5725 0.17625L53.6438 0.15L53.6588 0.1425H53.6625" fill="white"/>
                            </svg>                            
                        </i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Reports</h4>
                        </div>
                        <div class="card-body">
                            {{ $totalLaporan }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafik Budget vs Sales --}}
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Penjualan Minggu ini</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" height="158"></canvas>
                    </div>
                </div>
            </div>

            {{-- Tabel Stock Barang --}}
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Stock Barang</h4>
                        <div class="card-header-action">
                            <a href="{{ route('produk.index') }}" class="btn btn-danger">View More <i
                                    class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive table-invoice">
                            <table class="table table-striped">
                                <tr>
                                    <th>Kode Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Harga Jual</th>
                                    <th>Stock</th>
                                </tr>
                                @foreach ($produkList as $p)
                                    <tr>
                                        <td>{{ $p->kode_produk }}</td>
                                        <td>{{ $p->nama_produk }}</td>
                                        <td>{{ number_format($p->harga_jual, 0, ',', '.') }}</td>
                                        <td>{{ $p->stock }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Script untuk Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var statistics_chart = document.getElementById("myChart").getContext('2d');

        var myChart = new Chart(statistics_chart, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!}, // Ambil label dari controller
                datasets: [{
                    label: 'Penjualan (Rp)',
                    data: {!! json_encode($data) !!}, // Ambil data dari controller
                    borderWidth: 5,
                    borderColor: '#6777ef',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#6777ef',
                    pointRadius: 4
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            stepSize: 500000 // Sesuaikan dengan range data penjualan
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            color: '#fbfbfb',
                            lineWidth: 2
                        }
                    }]
                },
            }
        });
    </script>
@endsection
