document.addEventListener('DOMContentLoaded', () => {

//-------------------------VARIABLES------------------------------

    const select_func_altas = document.querySelector('#select_func_altas');
    const input_func_altas = document.querySelector('#input_func_altas');

//-------------------------EVENTOS--------------------------------

    input_func_altas.addEventListener('input', getEmployee_altas);

//-------------------------FUNCIONES------------------------------

    function getEmployee_altas() { //Se muestran los empleados a través de un select cuando se busca por el input con id 'input_func'

        const searchValue = input_func_altas.value.toLowerCase(); //Se toma el valor que se ingresa en el input y se quitan las mayúsculas

        Array.from(select_func_altas.options).forEach(option => { //Convierte los valores de los options en array y los recorre

            const text = option.textContent.toLowerCase(); //Se guarda en una variable el valor del option y se quitan las mayúsculas

            if(text.includes(searchValue)) { //Si el valor del option incluye el valor del input al option correspodiente se le aplica selected

                option.selected = true;
            
            } else {

                option.hidden = true; //Sino, se oculta el valor
            }
        });
    };
});