const confirmation = document.querySelector('.confirmation');
const form = document.querySelector('.form');
const message = document.querySelector('.message');
const submit = document.querySelector('.submit');
const targets = document.querySelector('.targets');

// Keyboard shortcuts
message.addEventListener('keydown', function (event) {

    // console.log(event);

    if (event.ctrlKey && event.code === 'Enter') {
        // Ctrl+Enter = Send
        event.preventDefault();
        send();
    } else if (event.altKey && event.code === 'ArrowLeft') {
        // Alt+Left = Previous target
        event.preventDefault();
        rotateTarget(-1);
    } else if (event.altKey && event.code === 'ArrowRight') {
        // Alt+Right = Next target
        event.preventDefault();
        rotateTarget(+1);
    } else if (event.ctrlKey && event.shiftKey && event.code === 'KeyZ') {
        // Ctrl+Shift+Z = Retrieve previous message
        event.preventDefault();
        if (!message.value) {
            message.value = localStorage.getItem('last-message');
            updateTitle();
        }
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

// Page title - first line of the message
function updateTitle() {
    document.title = message.value.trim().replace(/[\r\n].*$/, '').trim() || 'Collector';
}

message.addEventListener('input', updateTitle);

// Send message
function send() {

    let text = message.value;

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
                localStorage.setItem('last-message', text);
                confirmation.innerText = json.success;
                confirmation.classList.remove('show');
                setTimeout(() => confirmation.classList.add('show'), 0);
                message.value = '';
                updateTitle();
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

// Warn before leaving and save the unsent message in local storage
window.onbeforeunload = function (event) {
    if (message.value) {
        localStorage.setItem('last-message', message.value);
        event.preventDefault();
        return '';
    }
};
