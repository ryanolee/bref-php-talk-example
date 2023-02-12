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

        fetch(form.attributes.action.value, {
            method: form.attributes.method.value,
            body: JSON.stringify(requestPayload),
            headers: {
                "Content-Type": "application/json"
            }
        }).then(response => {
            return response.json()
        }).then(data => {
            submitAwsS3PostForm(data.data, form)
        }).catch(error => {
            console.log(error)
        }).finally(() => {
            console.log('finally')
            submitButton.removeAttribute('disabled');
            submitButton.removeAttribute('aria-busy');
        })
    })
}

function submitAwsS3PostForm(responseData, form){
    const nameInput = document.querySelector('*[name="name"]')
    const descriptionInput = document.querySelector('*[name="description"]')

    if(nameInput !== null){
        nameInput.remove()
    }

    if(descriptionInput !== null){
        descriptionInput.remove()
    }


    const imagePrefix = responseData.filePrefix
    const formAttributes = responseData.imageUploadAttributes
    const imageUploadInputs = responseData.imageUploadInputs

    // Set Form attributes
    Object.keys(formAttributes).forEach(key => {
        form.setAttribute(key, formAttributes[key])
    })

    Object.keys(imageUploadInputs)
        .filter((item) => item !== "key")
        .forEach(key => {
            const input = getHiddenInput(key, imageUploadInputs[key])
            form.insertAdjacentElement('afterbegin', input)
        })

    const formData = new FormData(form)

    const file = formData.get('file')
    const fileExtension = file.name.split('.').pop()
    const redirectInput = getHiddenInput('success_action_redirect', window.location.origin)
    const keyInput = getHiddenInput('key', imagePrefix + "image." + fileExtension)
    form.insertAdjacentElement('afterbegin', keyInput)
    form.insertAdjacentElement('afterbegin', redirectInput)
    form.submit()
}

function getHiddenInput(name, value) {
    const input = document.createElement('input')
    input.setAttribute('type', 'hidden')
    input.setAttribute('name', name)
    input.setAttribute('value', value)

    return input
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#elephpant-form');
    if(form !== null){
        handleForm(form);
    }
})