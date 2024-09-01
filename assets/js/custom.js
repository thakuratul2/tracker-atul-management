let isTimerRunning = localStorage.getItem('isTimerRunning') === 'true';
let timerInterval;
let timerId = localStorage.getItem('timerId') || 0;
let startTime = parseInt(localStorage.getItem('startTime')) || 0;

function formatTime(unit) {
    return unit < 10 ? '0' + unit : unit;
}

function getElapsedTime() {
    const currentTime = Math.floor(Date.now() / 1000);
    return currentTime - startTime;
}

function startTimer() {
    if (timerInterval) {
        clearInterval(timerInterval);
    }

    timerInterval = setInterval(function () {
        const elapsed = getElapsedTime();
        const minutes = Math.floor(elapsed / 60);
        const seconds = elapsed % 60;
        
        document.querySelector('.start-time-text').textContent =
            `Running Timer: ${formatTime(minutes)}:${formatTime(seconds)}`;
    }, 1000);
}

function stopTimer() {
    clearInterval(timerInterval);
    localStorage.setItem('isTimerRunning', 'false');

    if (timerId) {
        fetch(`../method/time_log_timer.php?action=stop&timer_id=${timerId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    startTime = 0;
                    localStorage.setItem('startTime', startTime);
                    document.querySelector('.start-time-text').textContent = 
                        `Timer Stopped.`;
                    localStorage.setItem('timerId', 0);
                } else {
                    alert('Error stopping timer.');
                }
            })
            .catch(error => console.error('Error:', error));
    } else {
        console.error('Timer ID is missing');
    }
}

document.querySelector('.clock-icon').addEventListener('click', function () {
    if (!isTimerRunning) {
        fetch('../method/time_log_timer.php?action=start')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    timerId = data.timerId;
                    localStorage.setItem('timerId', timerId);
                    startTime = Math.floor(Date.now() / 1000);
                    localStorage.setItem('startTime', startTime);
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

// Resume the timer after page reload
if (isTimerRunning && timerId) {
    startTimer();
}

// Prevent logout if the timer is running
document.getElementById('logout-btn').addEventListener('click', function (e) {
    e.preventDefault();

    if (isTimerRunning) {
        alert('Error: Timer is running. Please stop the timer before logging out.');
    } else {
        window.location.href = '../method/logout_method.php';
    }
});
