<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold leading-tight text-primary">
            {{ __('Beranda') }}
        </h2>
    </x-slot>

    <div class="mx-auto max-w-screen-2xl sm:px-6 lg:px-8">
    <div class="py-12 p-4 space-y-4 sm:p-6 sm:space-y-6">
        <!-- Header with Quick Stats -->
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-2 lg:grid-cols-4 sm:gap-4">
            @foreach($performanceMetrics as $metric => $value)
            @if($metric !== 'recent_reporters')
            <div class="rounded-lg shadow-md transition-shadow stat bg-base-100 hover:shadow-lg">
                <div class="text-xs stat-title sm:text-sm">{{ Str::title(str_replace('_', ' ', $metric)) }}</div>
                <div class="text-sm stat-value sm:text-lg md:text-xl">
                    {{ is_numeric($value) ? number_format($value, 0, ',', '.') : $value }}
                </div>
                @if ($metric === 'pengguna_online')
                    <div class="text-xs stat-desc">Sekarang</div>
                @elseif ($metric !== 'total_reports')
                    <div class="text-xs stat-desc">{{ now()->format('F Y') }}</div>
                @endif
            </div>
            @endif
            @endforeach
        </div>

        <!-- Recent Reporters -->
        <div class="mt-6">
            @if(($performanceMetrics['recent_reporters']))
                <h2 class="text-lg font-semibold">Report Terbaru</h2>
            @endif
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-4 mt-4">
                @foreach($performanceMetrics['recent_reporters'] as $reporter)
                <div class="flex items-center p-4 bg-primary/25 rounded-lg shadow-md cursor-pointer" onclick="window.location.href='{{ url('daily-reports') }}'">
                    <div class="avatar">
                        <div class="mask mask-squircle w-16">
                            <img src="{{ $reporter['photo'] }}" alt="{{ $reporter['name'] }}" />
                        </div>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-semibold">{{ $reporter['report_date'] ?? '-' }}</div>
                        <div class="text-sm font-semibold">{{ $reporter['name'] }}</div>
                        <div class="text-xs text-gray-500">Report: {{ $reporter['task_count'] }}</div>
                        <div class="text-xs text-gray-500">{{ $reporter['report_time'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>


        <!-- Time Period Selector -->
        <div class="flex flex-col lg:flex-row gap-4 mb-4 justify-between">
            <div class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">
                <select id="timePeriod" class="select select-bordered w-full sm:max-w-xs" onchange="updateCharts(this.value)">
                    <option value="week">Mingguan</option>
                    <option value="month">Bulanan</option>
                    <option value="year">Tahunan</option>
                    <option value="custom">Sesuikan tanggal</option>
                </select>
                
                <div id="dateRangeInputs" class="flex flex-col sm:flex-row gap-2 w-full" style="display: none;">
                    <input type="date" id="startDate" class="input input-bordered w-full" value="{{ date('Y-m-d') }}">
                    <input type="date" id="endDate" class="input input-bordered w-full" value="{{ date('Y-m-d') }}">
                    <button onclick="updateCustomRange()" class="btn btn-primary w-full sm:w-auto">Terapkan</button>
                </div>
            </div>
            <form action="{{ route('daily-reports.export') }}" method="GET" class="w-full lg:w-auto">
                <div class="flex flex-col sm:flex-row gap-2">
                    <input type="date" name="start_date" class="input input-bordered w-full" placeholder="Start Date" value="{{ date('Y-m-d') }}" required />
                    <input type="date" name="end_date" class="input input-bordered w-full" placeholder="End Date" value="{{ date('Y-m-d') }}" required />
                    <button type="submit" class="btn btn-primary w-full sm:w-auto">
                        <i class="fas fa-file-excel mr-2"></i>Export Excel
                    </button>
                </div>
            </form>
        </div>


<!-- Category Cards with Responsive Tabs -->
<div class="w-full px-16 mx-auto">
    @php
        $groupedCategories = $categories->groupBy(function($category) {
            return explode(' ', $category->name)[0];
        });
    @endphp

    <!-- Mobile Dropdown for Small Screens -->
    <div class="lg:hidden w-full mb-4">
        <select class="select select-bordered w-full" id="mobile-tab-select">
            @foreach($groupedCategories as $group => $items)
            @if($items->contains(function($category) { 
                return $category->has_batch || $category->has_claim || $category->has_sheets || $category->has_form || $category->has_email;
            }))
            <option value="{{ Str::slug($group) }}">
                {{ $group }} ({{ $items->count() }})
            </option>
            @endif
            @endforeach
        </select>
    </div>

    <!-- Desktop Tabs for Larger Screens -->
    <div class="hidden lg:block">
        <div role="tablist" class="tabs tabs-lifted overflow-x-auto">
            @foreach($groupedCategories as $group => $items)
                @if($items->contains(function($category) { 
                    return $category->has_batch || $category->has_claim || $category->has_sheets || $category->has_form || $category->has_email;
                }))
                <input 
                    type="radio" 
                    name="category_tabs" 
                    role="tab" 
                    class="tab"
                    aria-label="{{ $group }}"
                    {{ $loop->first ? 'checked' : '' }}
                    id="tab-{{ Str::slug($group) }}"
                />
                @endif
            @endforeach        </div>
    </div>

    <!-- Tabs Content -->
    <div class="mt-4">
        @foreach($groupedCategories as $group => $items)
            <div role="tabpanel" 
                 class="hidden tab-content bg-base-100 border-base-300 rounded-box p-2 sm:p-4 lg:p-6 {{ $loop->first ? 'block' : '' }}"
                 id="content-{{ Str::slug($group) }}"
            >

                <!-- Cards Grid -->
                <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-2 sm:gap-4">
                    @foreach($items as $category)
                        @if($category->has_batch || $category->has_claim || $category->has_sheets || $category->has_form || $category->has_email)
                        <div 
                            class="card bg-base-200 hover:bg-base-300 transition-all duration-300 shadow hover:shadow-lg cursor-pointer category-card"
                            id="category-card-{{ $category->name }}"
                            onclick="switchCategory('{{ $category->name }}')"
                            data-name="{{ strtolower($category->name) }}"
                        >
                            <div class="card-body p-2 sm:p-4">
                                <h3 class="card-title text-xs sm:text-sm font-semibold line-clamp-2">{{ $category->name }}</h3>
                                
                                <div class="flex flex-wrap gap-1 sm:gap-2 mt-2">
                                    @if($category->has_batch)
                                        <span class="badge badge-primary badge-sm">Batch</span>
                                    @endif
                                    @if($category->has_claim)
                                        <span class="badge badge-secondary badge-sm">Claim</span>
                                    @endif
                                    @if($category->has_sheets)
                                        <span class="badge badge-accent badge-sm">Sheet</span>
                                    @endif
                                    @if($category->has_email)
                                        <span class="badge badge-info badge-sm">Email</span>
                                    @endif
                                    @if($category->has_form)
                                        <span class="badge badge-success badge-sm">Form</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
    
        <!-- Chart Area -->
        <div class="shadow-md card bg-base-100">
            <div class="p-3 card-body sm:p-4">
                <h2 class="text-sm card-title sm:text-base">Data Chart</h2>
                <div class="h-60 sm:h-80">
                    <canvas id="taskChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile dropdown handling
    const mobileSelect = document.getElementById('mobile-tab-select');
    if (mobileSelect) {
        mobileSelect.addEventListener('change', function() {
            showContent(this.value);
            // Update desktop tab if visible
            const desktopTab = document.getElementById(`tab-${this.value}`);
            if (desktopTab) desktopTab.checked = true;
        });
    }

    // Desktop tabs handling
    const tabs = document.querySelectorAll('input[name="category_tabs"]');
    tabs.forEach(tab => {
        tab.addEventListener('change', function() {
            const groupId = this.id.replace('tab-', '');
            showContent(groupId);
            // Update mobile select if visible
            if (mobileSelect) mobileSelect.value = groupId;
        });
    });

    // Debounced resize handler for responsive adjustments
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(handleResize, 250);
    });

    function handleResize() {
        const isMobile = window.innerWidth < 1024;
        const mobileSelect = document.getElementById('mobile-tab-select');
        const desktopTabs = document.querySelector('.tabs');

        if (mobileSelect && desktopTabs) {
            mobileSelect.style.display = isMobile ? 'block' : 'none';
            desktopTabs.parentElement.style.display = isMobile ? 'none' : 'block';
        }
    }

    function showContent(groupId) {
        // Hide all content
        document.querySelectorAll('.tab-content').forEach(content => {
            content.style.display = 'none';
        });
        
        // Show selected content
        const selectedContent = document.getElementById(`content-${groupId}`);
        if (selectedContent) {
            selectedContent.style.display = 'block';
        }
    }

    // Initial resize handle
    handleResize();
});

        let chart;
        let chartData = {};

        function createChart(data, selectedCategory = 'all') {
            const ctx = document.getElementById('taskChart').getContext('2d');
            
            if (chart) {
                chart.destroy();
            }
            
            let filteredData = [];
            if (selectedCategory === 'all') {
                Object.values(data).forEach(categoryData => {
                    filteredData.push(...categoryData);
                });
            } else {
                filteredData = data[selectedCategory] || [];
            }

            const labels = [...new Set(filteredData.map(item => item.date))].sort();

            const totals = {
                batch: filteredData.reduce((sum, item) => sum + (Number(item.batch_count) || 0), 0),
                claim: filteredData.reduce((sum, item) => sum + (Number(item.claim_count) || 0), 0),
                sheet: filteredData.reduce((sum, item) => sum + (Number(item.sheet_count) || 0), 0),
                email: filteredData.reduce((sum, item) => sum + (Number(item.email) || 0), 0),
                form: filteredData.reduce((sum, item) => sum + (Number(item.form) || 0), 0)
            };

    const datasets = [
    {
        label: `Batch (Total: ${totals.batch})`,
        borderColor: '#EF4444',
        backgroundColor: '#EF444420',
        data: labels.map(date => {
            return filteredData
                .filter(item => item.date === date)
                .reduce((sum, item) => sum + (Number(item.batch_count) || 0), 0);
        }),
        tension: 0.4,
        fill: true
    },
    {
        label: `Claim (Total: ${totals.claim})`,
        borderColor: '#3B82F6',
        backgroundColor: '#3B82F620',
        data: labels.map(date => {
            return filteredData
                .filter(item => item.date === date)
                .reduce((sum, item) => sum + (Number(item.claim_count) || 0), 0);
        }),
        tension: 0.4,
        fill: true
    },
    {
        label: `Sheet (Total: ${totals.sheet})`,
        borderColor: '#22C55E',
        backgroundColor: '#22C55E20',
        data: labels.map(date => {
            return filteredData
                .filter(item => item.date === date)
                .reduce((sum, item) => sum + (Number(item.sheet_count) || 0), 0);
        }),
        tension: 0.4,
        fill: true
    },
    {
        label: `Email (Total: ${totals.email})`,
        borderColor: '#EAB308',
        backgroundColor: '#EAB30820',
        data: labels.map(date => {
            return filteredData
                .filter(item => item.date === date)
                .reduce((sum, item) => sum + (Number(item.email) || 0), 0);
        }),
        tension: 0.4,
        fill: true
    },
    {
        label: `Form (Total: ${totals.form})`,
        borderColor: '#9333EA',
        backgroundColor: '#9333EA20',
        data: labels.map(date => {
            return filteredData
                .filter(item => item.date === date)
                .reduce((sum, item) => sum + (Number(item.form) || 0), 0);
        }),
        tension: 0.4,
        fill: true
    }
].filter(dataset => {
    const total = dataset.label.match(/\(Total: (\d+)\)/)[1];
    return Number(total) > 0;
});
chart = new Chart(ctx, {
    type: 'line',
    data: { labels, datasets },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            intersect: false,
            mode: 'index'
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    drawBorder: false,
                    color: '#E5E7EB40'
                },
                ticks: {
                    precision: 0
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        },
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    padding: 20
                }
            },
            tooltip: {
                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                titleColor: '#1F2937',
                bodyColor: '#1F2937',
                borderColor: '#E5E7EB',
                borderWidth: 1,
                padding: 12,
                displayColors: true,
                callbacks: {
                    label: function(context) {
                        const label = context.dataset.label.split(' (')[0];
                        return `${label}: ${context.parsed.y}`;
                    },
                    afterLabel: function(context) {
                        const categoryName = selectedCategory === 'all' ? 'All Categories' : selectedCategory;
                        return `${categoryName}`;
                    }
                }
            }
        }
    }
});
}

function switchCategory(category) {
// Update tab active state
document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('tab-active'));
event.target.classList.add('tab-active');

// Update category cards highlighting
document.querySelectorAll('[id^="category-card-"]').forEach(card => {
    card.classList.remove('ring-2', 'ring-primary');
});

if (category !== 'all') {
    const card = document.getElementById(`category-card-${category}`);
    if (card) {
        card.classList.add('ring-2', 'ring-primary');
    }
}

// Update chart
createChart(chartData, category);
}

function updateCharts(period) {
// Show/hide date inputs for custom period
const dateRangeInputs = document.getElementById('dateRangeInputs');
dateRangeInputs.style.display = period === 'custom' ? 'flex' : 'none';

if (period === 'custom') {
    return; // Don't fetch data yet for custom period
}

// Visual feedback during loading
const canvas = document.getElementById('taskChart');
canvas.style.opacity = '0.5';

// Fetch and update chart data
fetch(`/chart-data/${period}`)
    .then(response => response.json())
    .then(data => {
        canvas.style.opacity = '1';
        if (Object.keys(data).length > 0) {
            chartData = data;
            createChart(data, 'all');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        canvas.style.opacity = '1';
        // You might want to show an error message to the user here
    });
}

function updateCustomRange() {
const startDate = document.getElementById('startDate').value;
const endDate = document.getElementById('endDate').value;

if (!startDate || !endDate) {
    alert('Please select both start and end dates');
    return;
}

if (new Date(startDate) > new Date(endDate)) {
    alert('Start date must be before or equal to end date');
    return;
}

const canvas = document.getElementById('taskChart');
canvas.style.opacity = '0.5';

fetch(`/chart-data/custom/${startDate}/${endDate}`)
    .then(response => response.json())
    .then(data => {
        canvas.style.opacity = '1';
        if (Object.keys(data).length > 0) {
            chartData = data;
            createChart(data, 'all');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        canvas.style.opacity = '1';
        alert('Error fetching data for the selected date range');
    });
}

// Initialize charts when page loads
document.addEventListener('DOMContentLoaded', () => {
const initialPeriod = document.getElementById('timePeriod').value;
updateCharts(initialPeriod);

// Event listener for period changes
document.getElementById('timePeriod').addEventListener('change', function(e) {
    updateCharts(e.target.value);
});
});
</script>
</x-app-layout>