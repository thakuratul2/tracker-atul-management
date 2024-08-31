let isTimerRunning = localStorage.getItem('isTimerRunning') === 'true';
let timerInterval;
let seconds = parseInt(localStorage.getItem('seconds')) || 0;
let minutes = parseInt(localStorage.getItem('minutes')) || 0;
let hasInsertedRecord = localStorage.getItem('hasInsertedRecord') === 'true';
let timerId = localStorage.getItem('timerId') || 0; // Store timer ID

function formatTime(unit) {
    return unit < 10 ? '0' + unit : unit;
}

function startTimer() {
    // Clear existing interval if any
    if (timerInterval) {
        clearInterval(timerInterval);
    }

    timerInterval = setInterval(function() {
        seconds++;
        if (seconds >= 60) {
            seconds = 0;
            minutes++;
        }
        // Update the display
        document.querySelector('.start-time-text').textContent = 
            `Running Timer: ${formatTime(minutes)}:${formatTime(seconds)}`;
        
        // Store the updated time in localStorage
        localStorage.setItem('seconds', seconds);
        localStorage.setItem('minutes', minutes);
    }, 1000);
}

function stopTimer() {
    clearInterval(timerInterval);
    localStorage.setItem('isTimerRunning', 'false');

    if (timerId) {
        // Store the end time in the database
        fetch(`../method/time_log_timer.php?action=stop&timer_id=${timerId}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    // Reset timer variables and localStorage
                    seconds = 0;
                    minutes = 0;
                    localStorage.setItem('seconds', seconds);
                    localStorage.setItem('minutes', minutes);
                    document.querySelector('.start-time-text').textContent = 
                        `Timer Stopped.`;
                    // Reset record insertion flag
                    localStorage.setItem('hasInsertedRecord', 'false');
                    timerId = 0;
                    localStorage.setItem('timerId', timerId);
                } else {
                    alert('Error stopping timer.');
                }
            })
            .catch(error => console.error('Error:', error));
    } else {
        console.error('Timer ID is missing');
    }
}

document.querySelector('.clock-icon').addEventListener('click', function() {
    if (!isTimerRunning) {
        // Start Timer
        fetch('../method/time_log_timer.php?action=start')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    timerId = data.timerId; // Retrieve timerId from response
                    localStorage.setItem('timerId', timerId);
                    localStorage.setItem('hasInsertedRecord', 'true');
                    startTimer();
                    isTimerRunning = true;
                    localStorage.setItem('isTimerRunning', 'true');
                    alert('Timer started');
                } else {
                    alert('Error starting timer.');
                }
            })
            .catch(error => console.error('Error:', error));
    } else {
        stopTimer();
        isTimerRunning = false;
        localStorage.setItem('isTimerRunning', 'false');
    }
});

// If the timer was running before the page reload, resume it
if (isTimerRunning && timerId) {
    document.querySelector('.start-time-text').textContent = 
        `Running Timer: ${formatTime(minutes)}:${formatTime(seconds)}`;
    startTimer();
}

document.getElementById('logout-btn').addEventListener('click', function(e) {
    e.preventDefault(); 

    if (isTimerRunning) {
        alert('Error: Timer is running. Please stop the timer before logging out.');
    } else {
        window.location.href = '../method/logout_method.php';
    }
});
