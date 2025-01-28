
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('searchInput');
    const resultsContainer = document.getElementById('autocompleteResults');

    input.addEventListener('input', () => {
        const query = input.value.trim();

        // Solo busca si hay al menos una letra
        if (query.length >= 1) {
            fetch(`/doctors/search?name=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    resultsContainer.innerHTML = '';
                    if (data.length === 0) {
                        resultsContainer.textContent = 'No se encontraron resultados.';
                        return;
                    }

                    data.forEach(doctor => {

                        const option = document.createElement('div');
                        option.innerHTML = `<i class="bi-geo-alt me-2">${doctor.id}</i> ${doctor.name} - ${doctor.specialty}  <i class="bi bi-globe"></i>`;
                        option.classList.add('autocomplete-item');
                        // option.textContent = `${doctor.name} - ${doctor.specialty}`;
                        // option.classList.add('autocomplete-item');

                        // Permitir seleccionar un doctor
                        option.addEventListener('click', () => {
                            input.value = doctor.name;
                            resultsContainer.innerHTML = '';
                        });

                        resultsContainer.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching doctors:', error));
        } else {
            resultsContainer.innerHTML = '';
        }
    });
});