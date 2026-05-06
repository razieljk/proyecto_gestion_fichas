document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('fichas_cursos_idfichas_cursos');
    if (!select) return;

    const fichasData = JSON.parse(select.dataset.fichas);

    select.addEventListener('change', function() {
        const fichaId = this.value;
        const container = document.getElementById('aprendices-container');
        const lista = document.getElementById('aprendices-lista');

        lista.innerHTML = '';

        if (!fichaId || !fichasData[fichaId]) {
            container.style.display = 'none';
            return;
        }

        const aprendices = fichasData[fichaId].aprendices;

        if (aprendices.length === 0) {
            lista.innerHTML = '<p style="color:#aaa;font-size:14px">Esta ficha no tiene aprendices registrados</p>';
        } else {
            aprendices.forEach(function(a) {
                lista.innerHTML += `
                    <label class="aprendiz-check">
                        <input type="checkbox" name="aprendices[]" value="${a.id}">
                        <span>${a.nombre}</span>
                    </label>
                `;
            });
        }

        container.style.display = 'block';
    });
});