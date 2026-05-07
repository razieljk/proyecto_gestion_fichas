document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('buscar-aprendiz');
    const resultados = document.getElementById('resultados-busqueda');
    const formAgregar = document.getElementById('form-agregar');
    const aprendizSeleccionado = document.getElementById('aprendiz-seleccionado');

    if (!input) return;

    let timeout = null;

    input.addEventListener('input', function() {
        clearTimeout(timeout);
        const q = this.value.trim();

        if (q.length < 2) {
            resultados.innerHTML = '';
            resultados.style.display = 'none';
            return;
        }

        timeout = setTimeout(function() {
            fetch(window.buscarUrl + '?q=' + encodeURIComponent(q))
                .then(res => res.json())
                .then(data => {
                    resultados.innerHTML = '';

                    if (data.length === 0) {
                        resultados.innerHTML = '<div class="resultado-item sin-resultados">No se encontraron aprendices</div>';
                    } else {
                        data.forEach(function(a) {
                            const div = document.createElement('div');
                            div.className = 'resultado-item';
                            div.innerHTML = `<strong>${a.nombres_aprendiz} ${a.apellidos_aprendiz}</strong> <span>${a.numdoc_aprendiz}</span>`;
                            div.addEventListener('click', function() {
                                aprendizSeleccionado.value = a.id_aprendices;
                                formAgregar.submit();
                            });
                            resultados.appendChild(div);
                        });
                    }

                    resultados.style.display = 'block';
                });
        }, 300);
    });

    document.addEventListener('click', function(e) {
        if (!input.contains(e.target) && !resultados.contains(e.target)) {
            resultados.style.display = 'none';
        }
    });
});