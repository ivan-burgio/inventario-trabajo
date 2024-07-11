document.addEventListener('DOMContentLoaded', () => {

//-------------------------VARIABLES------------------------------


    const input_func_altas = document.querySelector('#id_func');
    const table_baja = document.querySelectorAll('#table_baja');
    const table_prod = document.querySelectorAll('#table_prod');
    const btn_func = document.querySelectorAll('.btn_func');
    const product_func = document.querySelector('.product_func');

//-------------------------EVENTOS--------------------------------

    input_func_altas.addEventListener('input', e => {
        const searchValue = input_func_altas.value.trim().toLowerCase();
        table_baja.forEach(table => {
            searchProducts(table, searchValue); // Llamar a searchProducts para cada tabla
        });
    });

    btn_func.forEach(btn => {

        btn.addEventListener('click', () => {

            product_func.style.display = 'block';
            showProduct(btn);
        });
    });
//-------------------------FUNCIONES------------------------------

    function showProduct(btn) {
        const btnValue = btn.value.trim().toLowerCase(); // Valor del botón clickeado

        table_prod.forEach(table => {
            const tableCells = table.getElementsByTagName('td');

            // Iterar sobre todas las celdas de la tabla actual
            for (let i = 0; i < tableCells.length; i++) {
                const cellContent = tableCells[i].textContent.trim().toLowerCase();
                console.log(cellContent);

                // Comparar el contenido de la celda con el valor del botón
                if (cellContent === btnValue) {
                    table.style.display = ''; // Mostrar la tabla actual
                    break; // Salir del bucle una vez que se encuentre la coincidencia
                } else {
                    table.style.display = 'none'; // Ocultar la tabla actual si no hay coincidencia
                }
            }
        });
    }

    function searchProducts(table, searchValue) {
        const bodies = table.getElementsByTagName('tbody');
        
        for (let j = 0; j < bodies.length; j++) {
            const rows = bodies[j].getElementsByTagName('tr');
            
            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const nameColumnOne = row.getElementsByTagName('td')[0]; // Cambiar el índice según la estructura real de tu tabla
                const nameColumnTwo = row.getElementsByTagName('td')[1]; // Cambiar el índice según la estructura real de tu tabla
    
                if (nameColumnOne && nameColumnTwo) {
                    const productNameOne = nameColumnOne.textContent.toLowerCase();
                    const productNameTwo = nameColumnTwo.textContent.toLowerCase();
    
                    if (productNameOne.includes(searchValue ) || productNameTwo.includes(searchValue)) {
                        table.style.display = '';
                    } else {
                        table.style.display = 'none';
                    }
                }
            }
        }
    }
});