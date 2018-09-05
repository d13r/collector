const confirmation = document.querySelector('.confirmation');
const form = document.querySelector('.form');
const message = document.querySelector('.message');
const submit = document.querySelector('.submit');
const targets = document.querySelector('.targets');

// Keyboard shortcuts
message.addEventListener('keydown', function (event) {

    // console.log(event);

    if (event.ctrlKey && event.key === 'Enter') {
        // Ctrl+Enter
        event.preventDefault();
        send();
    } else if (event.altKey && event.key === 'ArrowLeft') {
        // Alt+Left
        event.preventDefault();
        rotateTarget(-1);
    } else if (event.altKey && event.key === 'ArrowRight') {
        // Alt+Right
        event.preventDefault();
        rotateTarget(+1);
    }

});

// Targets
targets.addEventListener('click', function (event) {
    if (event.target.matches('.target input')) {
        message.focus();
    }
});

function rotateTarget(offset) {
    let inputs = targets.querySelectorAll('.target input');

    let selectedIndex = 0;
    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].checked) {
            selectedIndex = i;
            break;
        }
    }

    let newIndex = (selectedIndex + offset + inputs.length) % inputs.length;
    inputs[newIndex].checked = true;
}

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
                confirmation.innerText = json.success;
                confirmation.classList.remove('show');
                setTimeout(() => confirmation.classList.add('show'), 0);
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

// Warn before leaving if a message has been entered but not sent
window.onbeforeunload = function(event) {
    if (message.value) {
        event.preventDefault();
        return '';
    }
};
