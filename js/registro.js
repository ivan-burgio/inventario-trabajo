
document.addEventListener('DOMContentLoaded', () => {

    const select = document.querySelector('#select');
    const form = document.querySelector('#form');
    const submit = document.querySelector('#submit');

    function addForm() {

        if(select.value === 'torre') {

            let labelPro = document.createElement('label');
            labelPro.setAttribute('for', 'proce');
            labelPro.textContent = "Procesador";

            let labelRam = document.createElement('label');
            labelRam.setAttribute('for', 'ram');
            labelRam.textContent = "Ram";

            let labelAlmace = document.createElement('label');
            labelAlmace.setAttribute('for', 'almace');
            labelAlmace.textContent = "Almacenamiento";
    
            let inputPro = document.createElement('input');
            inputPro.setAttribute('type', 'text');
            inputPro.setAttribute('name', 'proce');
            inputPro.setAttribute('id', 'proce');

            let inputRam = document.createElement('input');
            inputRam.setAttribute('type', 'text');
            inputRam.setAttribute('name', 'ram');
            inputRam.setAttribute('id', 'ram');

            let inputAlmace = document.createElement('input');
            inputAlmace.setAttribute('type', 'text');
            inputAlmace.setAttribute('name', 'almace');
            inputAlmace.setAttribute('id', 'almace');
    
            form.insertBefore(labelPro, submit);
            form.insertBefore(inputPro, submit);
            form.insertBefore(labelRam, submit);
            form.insertBefore(inputRam, submit);
            form.insertBefore(labelAlmace, submit);
            form.insertBefore(inputAlmace, submit);
    
        } else {

            const inputPro = document.querySelector('#proce');
            const labelPro = document.querySelector('label[for="proce"]');
            const inputRam = document.querySelector('#ram');
            const labelRam = document.querySelector('label[for="ram"]');
            const inputAlmace = document.querySelector('#almace');
            const labelAlmace = document.querySelector('label[for="almace"]');

            if(inputPro && labelPro && inputRam && labelRam && inputAlmace && labelAlmace) {

                inputPro.remove();
                labelPro.remove();
                inputRam.remove();
                labelRam.remove();
                inputAlmace.remove();
                labelAlmace.remove();
            };
        }
    }

    select.addEventListener('change', addForm);

});