document.addEventListener('DOMContentLoaded', () => {

    //------------------------VARIABLES--------------------------------

    const form_altas = document.querySelector('#form');
    const input = document.querySelector('#input_func');
    const input_prod = document.querySelector('#input_prod');
    const select_prod = document.querySelector('#select_prod');
    const select_func = document.querySelector('#select_func');
    const select_ubic = document.querySelector('#ubic');
    const label_area = document.querySelector('#label_area');

    //-------------------------EVENTOS----------------------------------

    input_prod.addEventListener('input', getProduct); //Se llama la función cada vez que hayan cambios en el select
    input.addEventListener('input', getEmployee); //Se llama la función cada vez que se escriba sobre el input
    select_ubic.addEventListener('change', addForm); //Se llama la función cada vez que hayan cambios en el select


    //----------------------------FUNCIONES-----------------------------
    
    function getProduct() {

        const searchValue_prod = input_prod.value.toLowerCase(); //Se toma el valor que se ingresa en el input y se quitan las mayúsculas

        Array.from(select_prod.options).forEach(option => { //Convierte los valores de los options en array y los recorre

            const text = option.textContent.toLowerCase(); //Se guarda en una variable el valor del option y se quitan las mayúsculas

            if(text.includes(searchValue_prod)) { //Si el valor del option incluye el valor del input al option correspodiente se le aplica selected

                option.selected = true;
            
            } else {

                option.hidden = true; //Sino, se oculta el valor
            }
        });
    }

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
        const label_box_exist = document.querySelector('label[for="box"]');
        const input_box_exist = document.querySelector('#box');
    
        if (label_direccion_exist) {
            form_altas.removeChild(label_direccion_exist);
        }
        if (input_direccion_exist) {
            form_altas.removeChild(input_direccion_exist);
        }
        if (label_box_exist) {
            form_altas.removeChild(label_box_exist);
        }
        if (input_box_exist) {
            form_altas.removeChild(input_box_exist);
        }
    
        // Obtener el valor seleccionado en el select con id 'ubic'
        const ubicValue = select_ubic.value.trim();

        switch (ubicValue) {

            case 'home':

                let label_direccion = document.createElement('label');
                let input_direccion = document.createElement('input');
    
                label_direccion.setAttribute('for', 'direc');
                label_direccion.textContent = 'Domicilio';
    
                input_direccion.setAttribute('type', 'text');
                input_direccion.setAttribute('id', 'direc');
                input_direccion.setAttribute('name', 'direc');
    
                form_altas.insertBefore(label_direccion, label_area);
                form_altas.insertBefore(input_direccion, label_area);
                break;
    
            case 'plataforma':

                let label_box = document.createElement('label');
                let input_box = document.createElement('input');
    
                label_box.setAttribute('for', 'box');
                label_box.textContent = 'N° de BOX y sector o departamento';
    
                input_box.setAttribute('type', 'text');
                input_box.setAttribute('id', 'box');
                input_box.setAttribute('name', 'box');
    
                form_altas.insertBefore(label_box, label_area);
                form_altas.insertBefore(input_box, label_area);
                break;
    
            default:
                // En caso de otro valor, no se añaden campos adicionales
                break;
        };
    };

});