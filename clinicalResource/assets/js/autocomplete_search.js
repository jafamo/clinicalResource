// document.addEventListener('DOMContentLoaded', () => {
//     const input = document.getElementById('searchInput');
//     const resultsContainer = document.getElementById('autocompleteResults');
//
//     input.addEventListener('input', () => {
//         const query = input.value.trim();
//
//         if (query.length >= 1) {
//             fetch(`/doctors/search?name=${encodeURIComponent(query)}`)
//                 .then(response => response.json())
//                 .then(data => {
//                     resultsContainer.innerHTML = '';
//
//                     if (data.length === 0) {
//                         resultsContainer.textContent = 'No se encontraron resultados.';
//                         updateMarkers([]);
//                         return;
//                     }
//
//                     data.forEach(doctor => {
//                         const option = document.createElement('div');
//                         option.classList.add('autocomplete-item', 'position-relative');
//
//                         // Contenido principal
//                         option.innerHTML = `
//                             <i class="bi bi-geo-alt me-2"></i>
//                             ${doctor.name} - ${doctor.specialty}
//                             <a href="https://www.google.es" target="_blank" class="ms-2">
//                                 <i class="bi bi-globe"></i>
//                             </a>
//                         `;
//
//                         // Crear el tooltip manualmente
//                         const tooltip = document.createElement('div');
//                         tooltip.classList.add('custom-tooltip');
//                         tooltip.innerHTML = `
//                             <strong>Especialidad:</strong> ${doctor.specialty} <br>
//                             <strong>Centro Médico:</strong> ${doctor.medicalCenter}
//                         `;
//                         tooltip.style.display = 'none';
//
//                         // Agregar tooltip al contenedor
//                         option.appendChild(tooltip);
//
//                         // Evento para mostrar/ocultar tooltip
//                         let tooltipVisible = false;
//
//                         option.addEventListener('click', () => {
//                             if (!tooltipVisible) {
//                                 tooltip.style.display = 'block';
//                                 tooltipVisible = true;
//
//                                 // Cerrar automáticamente después de 5 segundos si no se interactúa
//                                 setTimeout(() => {
//                                     if (tooltipVisible) {
//                                         tooltip.style.display = 'none';
//                                         tooltipVisible = false;
//                                     }
//                                 }, 5000);
//                             } else {
//                                 tooltip.style.display = 'none';
//                                 tooltipVisible = false;
//                             }
//                         });
//
//                         // Permitir copiar texto dentro del tooltip sin cerrarlo
//                         tooltip.addEventListener('click', (event) => {
//                             event.stopPropagation();
//                         });
//
//                         resultsContainer.appendChild(option);
//                     });
//
//                     updateMarkers(data);
//                 })
//                 .catch(error => console.error('Error fetching doctors:', error));
//         } else {
//             resultsContainer.innerHTML = '';
//             updateMarkers([]);
//         }
//     });
// });


document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('searchInput');
    const resultsContainer = document.getElementById('autocompleteResults');

    input.addEventListener('input', () => {
        const query = input.value.trim();

        if (query.length >= 1) {
            fetch(`/doctors/search?name=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    resultsContainer.innerHTML = '';

                    if (data.length === 0) {
                        resultsContainer.textContent = 'Not found results.';
                        updateMarkers([]);
                        return;
                    }

                    // ID único para el grupo de acordeones
                    const accordionGroupId = "doctorAccordion";

                    data.forEach((doctor, index) => {
                        const option = document.createElement('div');
                        option.classList.add('autocomplete-item');

                        // Identificador único para cada acordeón
                        const accordionId = `accordion-${index}`;
                        const headingId = `heading-${index}`;

                        let details = '';

                        if (doctor.phone) {
                            details += `<strong>Phone:</strong> ${doctor.phone} <br>`;
                        }
                        if (doctor.openingTimes) {
                            details += `<strong>Opening Times:</strong> ${doctor.openingTimes} <br>`;
                        }
                        if (doctor.specialty) {
                            details += `<strong>Speciality:</strong> ${doctor.specialty} <br>`;
                        }
                        if (doctor.notes) {
                            details += `<strong>Notes:</strong> ${doctor.notes} <br>`;
                        }

                        if (doctor.medicalCenter || doctor.address || doctor.genericPhone) {
                            details += `<hr> <i class="fa-regular fa-hospital"></i> <strong>Medical Center</strong> <br>`;

                            if (doctor.medicalCenter) {
                                details += `<strong>Name:</strong> ${doctor.medicalCenter} <br>`;
                            }
                            if (doctor.address) {
                                details += `<i class="fa-regular fa-address-book"></i><strong>Address:</strong> ${doctor.address} <br>`;
                            }
                            if (doctor.genericPhone) {
                                details += `<i class="fa-solid fa-phone"></i><strong>Phone Medical Center:</strong> ${doctor.genericPhone} <br>`;
                            }
                        }

                        // Contenido del doctor + botón para abrir el acordeón
                        option.innerHTML = `
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="${headingId}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#${accordionId}" aria-expanded="false" aria-controls="${accordionId}">
                                        <i class="fa-regular fa-eye me-2"></i> ${doctor.name} - ${doctor.specialty}
                                        <a href="https://www.google.es" target="_blank" class="ms-2">
                                            <i class="fa-regular fa-circle-down"></i>
                                        </a>
                                    </button>
                                </h2>
                                <div id="${accordionId}" class="accordion-collapse collapse" aria-labelledby="${headingId}" data-bs-parent="#${accordionGroupId}">
                                    <div class="accordion-body">     
                                    ${details}                                                                                                            
                                    </div>
                                </div>
                            </div>
                        `;

                        resultsContainer.appendChild(option);
                    });

                    // Agregar el contenedor principal del acordeón al HTML
                    if (resultsContainer.childElementCount > 0) {
                        resultsContainer.innerHTML = `<div class="accordion" id="doctorAccordion">${resultsContainer.innerHTML}</div>`;
                    }

                    // Actualizar el mapa con las marcas de los doctores
                    updateMarkers(data);
                })
                .catch(error => console.error('Error fetching doctors:', error));
        } else {
            resultsContainer.innerHTML = '';
            updateMarkers([]);
        }
    });
});