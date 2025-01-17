
    /** SEARCH **/
    // document.querySelector('.search_icon').addEventListener('click', function (event) {
    //     event.preventDefault(); // Evita el comportamiento predeterminado del enlace
    //     const tableDiv = document.getElementById('hiddenTable');
    //     if (tableDiv.style.display === 'none') {
    //         tableDiv.style.display = 'block';
    //     } else {
    //         tableDiv.style.display = 'none';
    //     }
    //     console.log('Entra en table_search');
    // });



    document.querySelector('.search_icon').addEventListener('click', function (event) {
        event.preventDefault();
        const tableDiv = document.getElementById('hiddenTable');

        if (tableDiv.style.display === 'none') {
            tableDiv.style.display = 'block';
            const listItems = document.querySelectorAll('#dominoList .list-group-item');
            let delay = 0;

            listItems.forEach((item) => {
                setTimeout(() => {
                    item.classList.add('visible');
                }, delay);
                delay += 300;
            });
        } else {
            tableDiv.style.display = 'none';
        }
    });