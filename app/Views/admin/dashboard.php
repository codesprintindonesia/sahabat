<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="">
    <div class="row">
        <h3><?= $title ?></h3>
        <hr>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card ">
                <div class="card-header">Pengunjung Hari Ini</div>
                <div class="card-body text-center">
                    <div class="" style="font-size: 40px;"><?= $todayVisitors ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Total Hit Hari Ini</div>
                <div class="card-body text-center">
                    <div class="" style="font-size: 40px;"><?= $todayCounters ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Total Pengunjung</div>
                <div class="card-body text-center">
                    <div class="" style="font-size: 40px;"><?= $totalVisitors ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Total Hit</div>
                <div class="card-body text-center">
                    <div class="" style="font-size: 40px;"><?= $totalCounter ?></div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Pengunjung</div>
                </div>
                <div class="card-body">
                    <canvas id="sevenDaysVisitorsChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Hit</div>
                </div>
                <div class="card-body">
                    <canvas id="sevenDaysCounterChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- Tambahkan elemen canvas untuk chart -->

    <!-- Tambahkan elemen canvas untuk chart counter -->


</div>

<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
    /* Tambahkan CSS kustom jika diperlukan */
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Tambahkan skrip Moment.js -->
<script src="https://cdn.jsdelivr.net/npm/moment"></script>
<!-- Tambahkan skrip Chart.js dengan adapter waktu Moment.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment"></script>

<!-- Tambahkan skrip untuk membuat chart -->
<script>
    // Ambil data chart dari PHP dan ubah format
    var chartVisitorData = <?= json_encode($sevenDaysVisitors); ?>;

    // Ubah format data untuk digunakan oleh Chart.js
    var visitorLabels = chartVisitorData.map(function(item) {
        return item.date;
    });

    var visitorData = chartVisitorData.map(function(item) {
        return item.total;
    });

    // Tambahkan label untuk 7 hari ke belakang
    var currentDate = moment(); // Gunakan moment.js
    for (var i = 1; i <= 7; i++) {
        var previousDate = currentDate.clone().subtract(i, 'days').format('YYYY-MM-DD');
        if (!visitorLabels.includes(previousDate)) {
            visitorLabels.unshift(previousDate);
            visitorData.unshift(0); // Atur jumlah pengunjung/visitor ke 0 untuk tanggal yang tidak memiliki data
        }
    }

    // Buat line chart visitor menggunakan Chart.js dengan adapter waktu Moment.js
    var visitorCtx = document.getElementById('sevenDaysVisitorsChart').getContext('2d');
    var sevenDaysVisitorChart = new Chart(visitorCtx, {
        type: 'line',
        data: {
            labels: visitorLabels,
            datasets: [{
                label: 'Pengunjung',
                data: visitorData,
                borderColor: 'rgba(192, 7, 192, 1)',
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'time', // Menggunakan skala waktu
                    time: {
                        unit: 'day',
                        displayFormats: {
                            day: 'MMM D'
                        }
                    }
                },
                y: {
                    beginAtZero: true
                }
            }
        },
        legend: {
            display: false // Menyembunyikan legend
        }
    });
</script>

<script>
    // Ambil data chart counter dari PHP dan ubah format
    var chartCounterData = <?= json_encode($sevenDaysCounter); ?>;

    // Ubah format data untuk digunakan oleh Chart.js
    var counterLabels = chartCounterData.map(function(item) {
        return item.date;
    });

    var counterData = chartCounterData.map(function(item) {
        return item.total_counter;
    });

    // Tambahkan label untuk 7 hari ke belakang
    var currentDate = moment(); // Gunakan moment.js
    for (var i = 1; i <= 7; i++) {
        var previousDate = currentDate.clone().subtract(i, 'days').format('YYYY-MM-DD');
        if (!counterLabels.includes(previousDate)) {
            counterLabels.unshift(previousDate);
            counterData.unshift(0); // Atur jumlah pengunjung/counter ke 0 untuk tanggal yang tidak memiliki data
        }
    }

    // Buat line chart counter menggunakan Chart.js dengan adapter waktu Moment.js
    var counterCtx = document.getElementById('sevenDaysCounterChart').getContext('2d');
    var sevenDaysCounterChart = new Chart(counterCtx, {
        type: 'line',
        data: {
            labels: counterLabels,
            datasets: [{
                label: 'Hit ',
                data: counterData,
                borderColor: 'rgba(192, 15, 93, 1)',
                borderWidth: 1,
                fill: false
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'time', // Menggunakan skala waktu
                    time: {
                        unit: 'day',
                        displayFormats: {
                            day: 'MMM D'
                        }
                    }
                },
                y: {
                    beginAtZero: true
                }
            },
            legend: {
                display: false // Menyembunyikan legend
            }
        }
    });
</script>
<?= $this->endSection() ?>