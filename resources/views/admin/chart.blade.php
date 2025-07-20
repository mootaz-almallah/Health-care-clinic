{{-- AdminController --}}

@extends('layouts.admin.app')



@section('header')
Dashboard Charts
@endsection

@section('styles')
<style>
    /* Custom responsive container for charts */
    .chart-container {
        position: relative;
        height: 300px; /* Set a fixed height for each chart container */
        width: 100%;
    }
    /* Optional: Improve card style */
    .card {
        border: none;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
    .card-body {
        padding: 1.5rem;
    }
    h5.card-title {
        font-weight: 600;
        margin-bottom: 1rem;
    }
    .download-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 100;
        background: #667eea;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .download-btn:hover {
        background: #764ba2;
        transform: translateY(-2px);
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <h3 class="text-center mb-4">Dashboard Overview</h3>

    <!-- Grid Layout -->
    <div class="row">
        <!-- Total Counts Chart -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title text-center">Total Counts</h5>
                    <button class="download-btn" onclick="downloadChart('totalCountChart', 'Total Counts')">
                        <i class="fas fa-download"></i> Download
                    </button>
                    <div class="chart-container">
                        <canvas id="totalCountChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart: Doctors by Specialization -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title text-center">Doctors by Specialization</h5>
                    <button class="download-btn" onclick="downloadChart('specializationPieChart', 'Doctors by Specialization')">
                        <i class="fas fa-download"></i> Download
                    </button>
                    <div class="chart-container">
                        <canvas id="specializationPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Horizontal Bar Chart: Top Specializations -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title text-center">Top Specializations</h5>
                    <button class="download-btn" onclick="downloadChart('topSpecializationsBarChart', 'Top Specializations')">
                        <i class="fas fa-download"></i> Download
                    </button>
                    <div class="chart-container" style="height: 350px;">
                        <canvas id="topSpecializationsBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medicines by Category Chart -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title text-center">Medicines by Category</h5>
                    <button class="download-btn" onclick="downloadChart('medicinesByCategoryChart', 'Medicines by Category')">
                        <i class="fas fa-download"></i> Download
                    </button>
                    <div class="chart-container">
                        <canvas id="medicinesByCategoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Categories Chart -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title text-center">Top Categories Distribution</h5>
                    <button class="download-btn" onclick="downloadChart('topCategoriesChart', 'Top Categories Distribution')">
                        <i class="fas fa-download"></i> Download
                    </button>
                    <div class="chart-container" style="height: 250px;">
                        <canvas id="topCategoriesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medicine Sales Chart -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title text-center">Top Medicine Sales</h5>
                    <button class="download-btn" onclick="downloadChart('medicineSalesChart', 'Top Medicine Sales')">
                        <i class="fas fa-download"></i> Download
                    </button>
                    <div class="chart-container" style="height: 250px;">
                        <canvas id="medicineSalesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js and html2canvas -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

<!-- Chart Scripts -->
<script>
    // Data passed from the controller
    const totalUsers = {{ $totalUsers }};
    const totalDoctors = {{ $totalDoctors }};
    const totalSpecializations = {{ $totalSpecializations }};
    const totalAppointments = {{ $totalAppointments }};
    const totalMedicines = {{ $totalMedicines }};
    const totalCategories = {{ $totalCategories }};

    const specializationCounts = @json($specializationCounts);
    const topSpecializations = @json($topSpecializations);
    const medicinesByCategory = @json($medicinesByCategory);
    const medicineSales = @json($medicineSales);

    // Total Counts Chart
    const totalCountChartCtx = document.getElementById('totalCountChart').getContext('2d');
    new Chart(totalCountChartCtx, {
        type: 'bar',
        data: {
            labels: ['Users', 'Doctors', 'Specializations', 'Appointments', 'Medicines', 'Categories'],
            datasets: [{
                label: 'Total Count',
                data: [totalUsers, totalDoctors, totalSpecializations, totalAppointments, totalMedicines, totalCategories],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Total Counts Overview' }
            },
            scales: { 
                y: { beginAtZero: true, ticks: { precision: 0 } } 
            }
        }
    });

    // Pie Chart: Doctors by Specialization
    const specializationPieChartCtx = document.getElementById('specializationPieChart').getContext('2d');
    new Chart(specializationPieChartCtx, {
        type: 'pie',
        data: {
            labels: specializationCounts.map(item => item.name),
            datasets: [{
                label: 'Doctors Count',
                data: specializationCounts.map(item => item.count),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(153, 102, 255, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'right' },
                title: { display: true, text: 'Doctors by Specialization' }
            }
        }
    });

    // Horizontal Bar Chart: Top Specializations
    const topSpecializationsBarChartCtx = document.getElementById('topSpecializationsBarChart').getContext('2d');
    new Chart(topSpecializationsBarChartCtx, {
        type: 'bar',
        data: {
            labels: topSpecializations.map(item => item.name),
            datasets: [{
                label: 'Number of Doctors',
                data: topSpecializations.map(item => item.count),
                backgroundColor: 'rgba(153, 102, 255, 0.6)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Top Specializations' }
            },
            scales: { 
                x: { beginAtZero: true, ticks: { precision: 0 } } 
            }
        }
    });

    // Medicines by Category Chart
    const medicinesByCategoryChartCtx = document.getElementById('medicinesByCategoryChart').getContext('2d');
    new Chart(medicinesByCategoryChartCtx, {
        type: 'doughnut',
        data: {
            labels: medicinesByCategory.map(item => item.name),
            datasets: [{
                label: 'Number of Medicines',
                data: medicinesByCategory.map(item => item.count),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'right' },
                title: { display: true, text: 'Medicines Distribution by Category' }
            }
        }
    });

    // Top Categories Chart
    const topCategoriesChartCtx = document.getElementById('topCategoriesChart').getContext('2d');
    new Chart(topCategoriesChartCtx, {
        type: 'bar',
        data: {
            labels: medicinesByCategory.map(item => item.name),
            datasets: [{
                label: 'Number of Medicines',
                data: medicinesByCategory.map(item => item.count),
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Medicines Distribution by Category' }
            },
            scales: { 
                y: { beginAtZero: true, ticks: { precision: 0 } } 
            }
        }
    });

    // Medicine Sales Chart
    const medicineSalesChartCtx = document.getElementById('medicineSalesChart').getContext('2d');
    new Chart(medicineSalesChartCtx, {
        type: 'bar',
        data: {
            labels: medicineSales.map(item => item.name),
            datasets: [{
                label: 'Total Sales',
                data: medicineSales.map(item => item.total_sales),
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Top Medicine Sales' }
            },
            scales: { 
                y: { 
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                } 
            }
        }
    });

    // Function to download chart as image
    function downloadChart(chartId, chartName) {
        const canvas = document.getElementById(chartId);
        html2canvas(canvas).then(canvas => {
            const link = document.createElement('a');
            link.download = `${chartName}.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();
        });
    }
</script>
@endsection
