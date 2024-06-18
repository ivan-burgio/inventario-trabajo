document.addEventListener('DOMContentLoaded', () => {

    const input = document.querySelector('#input_func');
    const select_func = document.querySelector('#select_func');

    input.addEventListener('input', () => {

        const searchValue = input.value.toLowerCase();
        console.log(searchValue);

        Array.from(select_func.options).forEach(option => {

            const text = option.textContent.toLowerCase();

            if(text.includes(searchValue)) {

                option.selected = true;
            
            } else {

                option.hidden = true;
            }
        });
    });
})