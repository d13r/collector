const confirmation = document.querySelector('.confirmation');
const form = document.querySelector('.form');
const message = document.querySelector('.message');
const submit = document.querySelector('.submit');
const targets = document.querySelector('.targets');
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

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
    } else if (event.altKey && event.code === 'ArrowUp') {
        // Alt+Up = Move line up
        event.preventDefault();
        moveLine(-1);
    } else if (event.altKey && event.code === 'ArrowDown') {
        // Alt+Down = Move line down
        event.preventDefault();
        moveLine(+1);
    } else if (event.ctrlKey && event.shiftKey && event.code === 'KeyZ') {
        // Ctrl+Shift+Z = Retrieve previous message
        event.preventDefault();
        if (!message.value) {
            message.value = localStorage.getItem('last-message');
            updatedValue();
        }
    }

});

// Targets
targets.addEventListener('click', function (event) {
    if (event.target.matches('.target input')) {
        message.focus();
    }

    updateTarget();
});

function rotateTarget(offset) {
    const inputs = targets.querySelectorAll('.target input');

    let selectedIndex = 0;
    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].checked) {
            selectedIndex = i;
            break;
        }
    }

    const newIndex = (selectedIndex + offset + inputs.length) % inputs.length;
    inputs[newIndex].checked = true;
    updateTarget();
}

function updateTarget() {
    let target = document.querySelector('.target input:checked');

    document.title = `To: ${target.dataset.to.replace(/"/g, '')}`;

    message.placeholder = `To: ${target.dataset.to.replace(/"/g, '')}`;
    message.dataset.target = target.value;
}

updateTarget();

// Page title - first line of the message
function updatedValue() {
    // Note: [^] is equivalent to "." with the "s" (dotall) flag, but works in Firefox
    //document.title = message.value.trim().replace(/[\r\n][^]*$/, '').trim() || 'Collector';

    if (message.value) {
        message.classList.remove('placeholder');
    } else {
        message.classList.add('placeholder');
    }
}

message.addEventListener('input', updatedValue);
updatedValue();

// Move lines
function positionToLineAndCol(lines, position) {
    let passed = 0;

    for (let lineNum = 0; lineNum < lines.length; lineNum++) {
        const lineLen = lines[lineNum].length;

        if (passed + lineLen >= position) {
            return [lineNum, position - passed];
        }

        passed += lineLen + 1;
    }

    return [lines.length, lines[lines.length - 1].length];
}

function lineAndColToPosition(lines, line, col)
{
    let passed = 0;

    for (let lineNum = 0; lineNum < line; lineNum++) {
        passed += lines[lineNum].length + 1;
    }

    return passed + col;
}

function moveLine(offset) {
    const lines = message.value.split('\n');

    let [startLine, startCol] = positionToLineAndCol(lines, message.selectionStart);
    let [endLine, endCol] = positionToLineAndCol(lines, message.selectionEnd);

    if (endCol === 0 && endLine > startLine) {
        [endLine, endCol] = positionToLineAndCol(lines, message.selectionEnd - 1)
    }

    if (startLine + offset < 0 || endLine + offset > lines.length - 1) {
        return;
    }

    const movedLines = lines.splice(startLine, endLine - startLine + 1);
    lines.splice(startLine + offset, 0, ...movedLines);

    message.value = lines.join('\n');

    message.selectionStart = lineAndColToPosition(lines, startLine + offset, startCol);
    message.selectionEnd = lineAndColToPosition(lines, endLine + offset, endCol);
}

// Send message
function send() {

    const text = message.value;

    submit.disabled = true;
    submit.innerText = 'Sending...';

    fetch('/send', {
        body: new FormData(form),
        credentials: 'same-origin',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        },
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
                updatedValue();
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
    if (message.value && message.value !== message.defaultValue) {
        localStorage.setItem('last-message', message.value);
        event.preventDefault();
        return '';
    }
};
