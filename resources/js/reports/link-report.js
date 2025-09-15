import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function() {
    const { labels, data, clicksPerDay, deviceStats, browserStats } = window.linkReportData;

    function createChart(elId, type, chartData, options = {}) {
        const el = document.getElementById(elId);
        if (!el) return null;
        return new Chart(el.getContext('2d'), {
            type,
            data: chartData,
            options: { responsive: true, maintainAspectRatio: false, ...options }
        });
    }

    // Distribuição de Cliques
    const clicksChart = createChart('clicksChart', 'doughnut', {
        labels,
        datasets: [{
            data,
            backgroundColor: ['#2ECC71','#3498DB','#9B59B6','#E74C3C','#F1C40F'],
            borderWidth: 1
        }]
    });

    // Cliques por Dia
    createChart('clicksPerDayChart', 'line', {
        labels: clicksPerDay.map(i => i.date),
        datasets: [{
            label: 'Cliques',
            data: clicksPerDay.map(i => i.total),
            borderColor: '#2ECC71',
            backgroundColor: 'rgba(46,204,113,0.2)',
            fill: true,
            tension: 0.3
        }]
    });

    // Dispositivos
    createChart('devicesChart', 'doughnut', {
        labels: Object.keys(deviceStats),
        datasets: [{ data: Object.values(deviceStats), backgroundColor: ['#2ECC71','#3498DB','#F1C40F'] }]
    });

    // Navegadores
    createChart('browsersChart', 'bar', {
        labels: Object.keys(browserStats),
        datasets: [{ label: 'Cliques', data: Object.values(browserStats), backgroundColor: '#9B59B6' }]
    }, { indexAxis: 'y' });

    // Laravel Echo
    if (window.Echo) {
        window.Echo.channel('links')
            .listen('LinkClicksUpdated', e => {
                if (clicksChart) {
                    clicksChart.data.labels = e.labels;
                    clicksChart.data.datasets[0].data = e.data;
                    clicksChart.update();
                }
            });

        window.Echo.channel('links-log')
            .listen('LinkAccessed', e => {
                const logContainer = document.getElementById('log-container');
                if (!logContainer) return;
                const placeholder = document.getElementById('log-placeholder');
                if (placeholder) placeholder.remove();

                const logItem = document.createElement('div');
                logItem.className = 'p-3 rounded-lg bg-gray-50 hover:bg-gray-100 shadow-sm transition';
                const truncate = (str, max = 50) => str.length > max ? str.slice(0,max) + '...' : str;

                logItem.innerHTML = `
                    <div class="flex justify-between mb-1">
                        <h5 class="font-semibold text-gray-700">${truncate(e.short_code)}</h5>
                        <small class="text-gray-400">${e.time}</small>
                    </div>
                    <p class="text-gray-600 text-sm">URL: ${truncate(e.original_url)}</p>
                `;
                logContainer.prepend(logItem);
            });
    }
});
