const form = document.querySelector('.form');
const message = document.querySelector('.message');
const submit = document.querySelector('.submit');

// Keyboard shortcuts
message.addEventListener('keydown', function (event) {

    if (event.ctrlKey && (event.keyCode === 13 || event.keyCode === 10)) {
        // Ctrl+Enter
        event.preventDefault();
        send();
    }

});

// Send message
function send() {

    submit.disabled = true;
    submit.innerText = 'Sending...';

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
        })
        .catch(() => {
            alert('Failed to contact the server');
        })
        .finally(() => {
            message.focus();
            submit.disabled = false;
            submit.innerText = 'Send';
        });

}

form.addEventListener('submit', function (event) {
    event.preventDefault();
    send();
});
