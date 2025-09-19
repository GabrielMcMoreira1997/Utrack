import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function () {
    let clickCounter = 0;
    const clickCounterEl = document.getElementById('click-counter');
    const logEl = document.getElementById('access-log');
    const maxLogItems = 100; // Limite de itens no log

    if (window.Echo) {
        console.log('Listening for real-time updates...');

        window.Echo.channel('links-log')
            .listen('LinkAccessed', e => {
                const d = e.data ?? e;

                // Incrementa contador
                clickCounter++;
                clickCounterEl.textContent = clickCounter;

                // Cria novo item de log
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-start';
                li.innerHTML = `
                    <div>
                        <strong title="${d.original_url ?? 'URL desconhecida'}">${d.original_url ?? 'URL desconhecida'}</strong><br>
                        <small class="text-muted">${d.time} — ${d.city ?? '??'}, ${d.country ?? ''}</small><br>
                        <small class="text-muted">${d.device ?? ''} (${d.os ?? ''} ${d.os_version ?? ''}) | ${d.browser ?? ''} ${d.browser_version ?? ''} | IP: ${d.ip ?? ''}</small>
                    </div>
                `;

                // Adiciona destaque temporário
                li.classList.add('bg-light');
                setTimeout(() => li.classList.remove('bg-light'), 3000);

                logEl.prepend(li);

                // Limita número de itens no log
                while (logEl.children.length > maxLogItems) {
                    logEl.removeChild(logEl.lastChild);
                }

                // Mantém scroll no topo
                logEl.scrollTop = 0;
            });
    }
});