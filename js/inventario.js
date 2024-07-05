document.addEventListener('DOMContentLoaded', () => {

    const input_search = document.querySelector('#search');
    const tables = document.querySelectorAll('table'); // Seleccionar todas las tablas

    input_search.addEventListener('input', e => {
        const searchValue = input_search.value.trim().toLowerCase();
        tables.forEach(table => {
            searchProducts(table, searchValue); // Llamar a searchProducts para cada tabla
        });
    });

    function searchProducts(table, searchValue) {
        const bodies = table.getElementsByTagName('tbody');
        
        for (let j = 0; j < bodies.length; j++) {
            const rows = bodies[j].getElementsByTagName('tr');
            
            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const nameColumnOne = row.getElementsByTagName('td')[0]; // Cambiar el índice según la estructura real de tu tabla
                const nameColumnTwo = row.getElementsByTagName('td')[1]; // Cambiar el índice según la estructura real de tu tabla
                const nameColumnThree = row.getElementsByTagName('td')[2]; // Cambiar el índice según la estructura real de tu tabla
    
                if (nameColumnOne && nameColumnTwo && nameColumnThree) {
                    const productNameOne = nameColumnOne.textContent.toLowerCase();
                    const productNameTwo = nameColumnTwo.textContent.toLowerCase();
                    const productNameThree = nameColumnThree.textContent.toLowerCase();
    
                    if (productNameOne.includes(searchValue ) || productNameTwo.includes(searchValue) || productNameThree.includes(searchValue)) {
                        table.style.display = '';
                    } else {
                        table.style.display = 'none';
                    }
                }
            }
        }
    }

});
