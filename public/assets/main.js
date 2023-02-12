function handleForm(form){
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const form = e.target;
        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.setAttribute('disabled', 'true');
        submitButton.setAttribute('aria-busy', 'true')

        const data = new FormData(event.target)
        const requestPayload = {
            name: data.get('name'),
            description: data.get('description'),
        }
        debugger
        fetch(form.attributes.action.value, {
            method: form.attributes.method.value,
            body: JSON.stringify(requestPayload),
        })
    })
}


document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#elephpant-form');
    if(form !== null){
        handleForm(form);
    }
})