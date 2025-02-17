document.addEventListener('DOMContentLoaded', () => {

    //------------------------VARIABLES--------------------------------

    const form_altas = document.querySelector('#form');
    const input = document.querySelector('#input_func');
    const input_prod = document.querySelector('#input_prod');
    const tables_prod = document.querySelectorAll('#table_prod');
    const select_func = document.querySelector('#select_func');
    const select_ubic = document.querySelector('#ubic');
    const label_area = document.querySelector('#label_area');
    const input_submit = document.querySelector('#submit');
    const select_sect = document.querySelector('#select_sect');

    //-------------------------EVENTOS----------------------------------

    input.addEventListener('input', getEmployee); //Se llama la función cada vez que se escriba sobre el input
    select_ubic.addEventListener('change', addForm); //Se llama la función cada vez que hayan cambios en el select

    input_prod.addEventListener('input', e => { //Itera sobre cada fila de la tabla siempre que se escriba en el input
        const searchValue = input_prod.value.trim().toLowerCase();
        tables_prod.forEach(table_prod => {
            searchProducts(table_prod, searchValue); // Llamar a searchProducts para cada tabla
        });
    });

    form_altas.addEventListener('submit', inputDisable);

    
    //----------------------------FUNCIONES-----------------------------

    function getEmployee() { //Se muestran los empleados a través de un select cuando se busca por el input con id 'input_func'

        const searchValue = input.value.toLowerCase(); //Se toma el valor que se ingresa en el input y se quitan las mayúsculas

        Array.from(select_func.options).forEach(option => { //Convierte los valores de los options en array y los recorre

            const text = option.textContent.toLowerCase(); //Se guarda en una variable el valor del option y se quitan las mayúsculas

            if(text.includes(searchValue)) { //Si el valor del option incluye el valor del input al option correspodiente se le aplica selected

                option.selected = true;
            
            } else {

                option.hidden = true; //Sino, se oculta el valor
            }
        });
    };

    function addForm() { //Se agregan campos según el valor del select con id 'ubic'

        // Eliminar cualquier elemento existente relacionado con 'direc' o 'box'
        const label_direccion_exist = document.querySelector('label[for="direc"]');
        const input_direccion_exist = document.querySelector('#direc');
        const label_sect_exist = document.querySelector('label[for="sect"]');
        const select_sect_exist = document.querySelector('#sect');
        const label_box_exist = document.querySelector('label[for="box"]');
        const input_box_exist = document.querySelector('#box');
        const label_precinto_exist = document.querySelector('label[for="precinto"]');
        const input_precinto_exist = document.querySelector('#precinto');
    
        if (label_direccion_exist) {
            form_altas.removeChild(label_direccion_exist);
        }
        if (input_direccion_exist) {
            form_altas.removeChild(input_direccion_exist);
        }
        if (label_sect_exist) {
            form_altas.removeChild(label_sect_exist);
        }
        if (select_sect_exist) {
            form_altas.removeChild(select_sect_exist);
        }
        if (label_box_exist) {
            form_altas.removeChild(label_box_exist);
        }
        if (input_box_exist) {
            form_altas.removeChild(input_box_exist);
        }
        if (label_precinto_exist) {
            form_altas.removeChild(label_precinto_exist);
        }
        if (input_precinto_exist) {
            form_altas.removeChild(input_precinto_exist);
        }
    
        // Obtener el valor seleccionado en el select con id 'ubic'
        const ubicValue = select_ubic.value.trim();

        switch (ubicValue) {

            case 'home':

                let label_direccion = document.createElement('label');
                let input_direccion = document.createElement('input');
                let label_precinto = document.createElement('label');
                let input_precinto = document.createElement('input');
    
                label_direccion.setAttribute('for', 'direc');
                label_direccion.textContent = 'Domicilio';

                label_precinto.setAttribute('for', 'precinto');
                label_precinto.textContent = 'Precinto';

                select_sect.style.display = 'none';
    
                input_direccion.setAttribute('type', 'text');
                input_direccion.setAttribute('id', 'direc');
                input_direccion.setAttribute('name', 'direc');

                input_precinto.setAttribute('type', 'text');
                input_precinto.setAttribute('id', 'precinto');
                input_precinto.setAttribute('name', 'precinto');
    
                form_altas.insertBefore(label_direccion, label_area);
                form_altas.insertBefore(input_direccion, label_area);

                form_altas.insertBefore(label_precinto, label_area);
                form_altas.insertBefore(input_precinto, label_area);
                break;
    
            case 'plataforma':

                let label_sect = document.createElement('label');
                let label_box = document.createElement('label');
                let input_box = document.createElement('input');
    
                label_sect.setAttribute('for', 'sect');
                label_sect.textContent = 'Sector';

                select_sect.style.display = 'block';

                label_box.setAttribute('for', 'box');
                label_box.textContent = 'Puesto';

                input_box.setAttribute('type', 'text');
                input_box.setAttribute('id', 'box');
                input_box.setAttribute('name', 'box');
    
                form_altas.insertBefore(label_sect, select_sect);
                form_altas.insertBefore(label_box, label_area);
                form_altas.insertBefore(input_box, label_area);

                break;
    
            default:
                // En caso de otro valor, no se añaden campos adicionales
                select_sect.style.display = 'none';
                break;
        };
    };

    function searchProducts(table_prod, searchValue) { //Te permite realizar una busqueda dinamica de los elementos disponibles para dar de alta
        const bodies = table_prod.getElementsByTagName('tbody');
        
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
                        table_prod.style.display = '';
                    } else {
                        table_prod.style.display = 'none';
                    }
                }
            }
        }
    };

    function inputDisable() { 

        input_submit.disabled = true;
    };



});