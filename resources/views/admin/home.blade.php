@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">Admin Dashboard</h1>
    
    <div class="row g-4">
        <!-- Users Card -->
        <div class="col-md-3">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body text-center">
                    <i class="bi bi-people fs-1 text-primary color-black"></i>
                    <h5 class="card-title mt-2">Users</h5>
                    <p class="fs-3 fw-bold text-primary">{{ $users->count() }}</p>
                    <p class="text-muted">Total Users</p>
                    <a href="{{ url('admin/users') }}" class="btn btn-outline-primary btn-sm">View Details</a>
                </div>
            </div>
        </div>
        
        <!-- Posts Card -->
        <div class="col-md-3">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body text-center">
                    <i class="bi bi-file-text fs-1 text-success"></i>
                    <h5 class="card-title mt-2">Posts</h5>
                    <p class="fs-3 fw-bold text-success">{{ $posts->count() }}</p>
                    <p class="text-muted">Total Posts</p>
                    <a href="{{ url('admin/posts') }}" class="btn btn-outline-success btn-sm">View Details</a>
                </div>
            </div>
        </div>
        
        <!-- Groups Card -->
        <div class="col-md-3">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body text-center">
                    <i class="bi bi-people-fill fs-1 text-info"></i>
                    <h5 class="card-title mt-2">Groups</h5>
                    <p class="fs-3 fw-bold text-info">{{ $groups->count() }}</p>
                    <p class="text-muted">Total Groups</p>
                    <a href="{{ url('admin/groups') }}" class="btn btn-outline-info btn-sm">View Details</a>
                </div>
            </div>
        </div>
        
        <!-- Reports Card -->
        <div class="col-md-3">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body text-center">
                    <i class="bi bi-flag fs-1 text-danger"></i>
                    <h5 class="card-title mt-2">Reports</h5>
                    <p class="fs-3 fw-bold text-danger">{{ $reports->count() }}</p>
                    <p class="text-muted">Total Reports</p>
                    <a href="{{ url('admin/reports') }}" class="btn btn-outline-danger btn-sm">View Details</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Chart Section -->
    <div class="mt-5">
        <h2 class="text-center mb-4">Statistics</h2>
        <div class="row">
            <div class="col-md-6">
                <canvas id="userGrowthChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="postActivityChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Add Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div id="chartData" 
     data-user-growth="{{ json_encode($userGrowthData) }}" 
     data-post-activity="{{ json_encode($postActivityData) }}">
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Obter os dados do elemento HTML
        const chartElement = document.getElementById('chartData');
        const userGrowthData = JSON.parse(chartElement.dataset.userGrowth);
        const postActivityData = JSON.parse(chartElement.dataset.postActivity);

        // Separar rótulos e valores
        const userGrowthLabels = Object.keys(userGrowthData);
        const userGrowthValues = Object.values(userGrowthData);

        const postActivityLabels = Object.keys(postActivityData);
        const postActivityValues = Object.values(postActivityData);

        // Inicializar Chart.js
        const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
        const postActivityCtx = document.getElementById('postActivityChart').getContext('2d');

        new Chart(userGrowthCtx, {
            type: 'line',
            data: {
                labels: userGrowthLabels,
                datasets: [{
                    label: 'User Growth',
                    data: userGrowthValues,
                    borderColor: '#007bff',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: { responsive: true }
        });

        new Chart(postActivityCtx, {
            type: 'bar',
            data: {
                labels: postActivityLabels,
                datasets: [{
                    label: 'Post Activity',
                    data: postActivityValues,
                    borderColor: '#28a745',
                    backgroundColor: '#28a745',
                    borderWidth: 2
                }]
            },
            options: { responsive: true }
        });
    });
</script>

@endsection
