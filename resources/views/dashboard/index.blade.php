@extends('layouts.dashboard.dashboard')
@section('content')
<div class="col-lg-12">
    <div class="row">
        {{-- Users Card --}}
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Users <span>| Count</span></h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-lines-fill"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $userCount }}</h6>
                            <span class="text-muted small pt-2 ps-1">Total users</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        {{-- Role Card --}}
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">
                <div class="card-body">
                    <h5 class="card-title">Role <span>| Count</span></h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-fill-gear"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $roleCount }}</h6>
                            <span class="text-muted small pt-2 ps-1">Total role</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Jurusan Card -->
        <div class="col-xxl-4 col-xl-12">
            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Jurusan <span>| Count</span></h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-bounding-box"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{ $jurusanCount }}</h6>
                            <span class="text-muted small pt-2 ps-1">Total jurusan</span>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Graphic Chart --}}
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Barang Diajukan <span>/ Minggu</span></h5>

                    <!-- Line Chart -->
                    <div id="barangChart"></div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        fetch("{{ route('chart-barang') }}")
            .then(response => response.json())
            .then(data => {
                drawChart(data);
                console.log(data);
            })
            .catch(error => console.error(error));

        function drawChart(data) {
            let options = {
                chart: {
                    type: 'line',
                    zoom: {
                        enabled: false,
                    },
                },
                series: [{
                    name: 'Total Barang',
                    data: data.map(item => item.total_barang)
                }],
                title: {
                    text: 'Total Barang Diajukan / Minggu',
                    align: 'center'
                },
                stroke: {
                    curve: 'smooth'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'],
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: data.map(item => item.date),
                },
            };

            let chart = new ApexCharts(document.querySelector('#barangChart'), options)
            chart.render();
        }
    });

</script>
@endsection
