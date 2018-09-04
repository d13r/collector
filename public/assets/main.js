const form = document.querySelector('.form');
const message = document.querySelector('.message');
const submit = document.querySelector('.submit');

form.addEventListener('submit', function (event) {

    event.preventDefault();

    submit.disabled = true;

    fetch('/send.php', {
        body: new FormData(form),
        credentials: 'same-origin',
        method: 'POST',
    })
        .then(response => response.json())
        .then(json => {
            if (json.error) {
                alert(json.error);
            } else if (json.success) {
                alert(json.success);
                message.value = '';
            } else {
                alert('Received an invalid response from the server');
            }

            submit.disabled = false;
            message.focus();
        })
        .catch(() => {
            alert('Failed to contact the server');
            submit.disabled = false;
        });

});
