import './bootstrap';

// Plugin Chart.js global — Filament lit window.filamentChartJsPlugins avant chaque new Chart().
// Pour les graphiques marqués data-chart-clickable : on dispatche un CustomEvent 'chart-click'
// sur l'élément Alpine, qui le capture via x-on:chart-click et appelle $wire.handleChartClick.
window.filamentChartJsPlugins = [
    {
        id: 'canvas-instance-store',
        beforeInit(chart) {
            // Filament force Chart.defaults.animation.duration = 0 à chaque initChart().
            // Il faut donc écraser explicitement (=) — ??= ne fonctionnerait pas car 0 ≠ null/undefined.
            if (chart.options.animation !== false) {
                if (typeof chart.options.animation !== 'object') {
                    chart.options.animation = {};
                }
                chart.options.animation.duration = 800;
                chart.options.animation.easing   = 'easeOutQuart';
            }

            // Délai progressif barre par barre
            if (chart.config.type === 'bar') {
                chart.options.animation.delay = (ctx) =>
                    ctx.dataIndex !== undefined ? ctx.dataIndex * 35 : 0;
            }

            // Réponse hover instantanée
            if (!chart.options.transitions) chart.options.transitions = {};
            if (!chart.options.transitions.active) chart.options.transitions.active = {};
            if (!chart.options.transitions.active.animation) chart.options.transitions.active.animation = {};
            chart.options.transitions.active.animation.duration = 120;
        },
        afterInit(chart) {
            chart.canvas._filamentChart = chart;

            const alpineEl = chart.canvas.closest('[data-chart-clickable]');
            if (!alpineEl) return;

            chart.canvas.addEventListener('click', function (event) {
                const points = chart.getElementsAtEventForMode(event, 'nearest', { intersect: true }, true);
                if (!points.length) return;

                const { index, datasetIndex } = points[0];
                const label = String(chart.data.labels?.[index] ?? '');

                alpineEl.dispatchEvent(new CustomEvent('chart-click', {
                    detail: { index, datasetIndex, label },
                    bubbles: false,
                }));
            });

            chart.canvas.addEventListener('mousemove', function (event) {
                const points = chart.getElementsAtEventForMode(event, 'nearest', { intersect: true }, true);
                chart.canvas.style.cursor = points.length ? 'pointer' : '';
            });
        },
        afterDestroy(chart) {
            if (chart.canvas) {
                delete chart.canvas._filamentChart;
            }
        },
    },
];
