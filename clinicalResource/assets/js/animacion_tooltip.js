// Animacion tooltip
document.querySelectorAll('.tooltip-container').forEach((tooltip) => {
    tooltip.addEventListener('mouseenter', () => {
        tooltip.classList.add('tooltip-visible');

        // Ocultar después de 5 segundos
        setTimeout(() => {
            tooltip.classList.remove('tooltip-visible');
        }, 5000);
    });
});


//efecto dominio de la lista de resultados
document.addEventListener('DOMContentLoaded', () => {
    const listItems = document.querySelectorAll('#dominoList .list-group-item');
    let delay = 0;

    listItems.forEach((item) => {
        setTimeout(() => {
            item.classList.add('visible');
        }, delay);
        delay += 300; // Incremento del retraso para el efecto dominó
    });
});