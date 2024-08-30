document.addEventListener('DOMContentLoaded', function() {
    let isTimerRunning = localStorage.getItem('isTimerRunning') === 'true';
    let timerInterval;
    let seconds = parseInt(localStorage.getItem('seconds')) || 0;
    let minutes = parseInt(localStorage.getItem('minutes')) || 0;
    let hours = parseInt(localStorage.getItem('hours')) || 0;
    let hasInsertedRecord = localStorage.getItem('hasInsertedRecord') === 'true';
    let timerId = localStorage.getItem('timerId') || 0;

    function formatTime(unit) {
        return unit < 10 ? '0' + unit : unit;
    }

    function startTimer() {
        if (timerInterval) {
            clearInterval(timerInterval);
        }

        timerInterval = setInterval(function() {
            seconds++;
            if (seconds >= 60) {
                seconds = 0;
                minutes++;
                if (minutes >= 60) {
                    minutes = 0;
                    hours++;
                }
            }
            document.querySelector('.start-time-text').textContent = 
                `Running Timer: ${formatTime(hours)}:${formatTime(minutes)}:${formatTime(seconds)}`;
            localStorage.setItem('seconds', seconds);
            localStorage.setItem('minutes', minutes);
            localStorage.setItem('hours', hours);
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
                        // Reset the local timer values
                        seconds = 0;
                        minutes = 0;
                        hours = 0;
                        localStorage.setItem('seconds', seconds);
                        localStorage.setItem('minutes', minutes);
                        localStorage.setItem('hours', hours);
                        document.querySelector('.start-time-text').textContent = `Timer Stopped.`;
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
        if (!isTimerRunning && !hasInsertedRecord) {
            fetch('../method/time_log_timer.php?action=start')
                .then(response => response.json())
                
                .then(data => {
                    console.log(response);
                    if (data.success) {
                        timerId = data.timerId;
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
        } else if (isTimerRunning) {
            stopTimer();
            isTimerRunning = false;
            localStorage.setItem('isTimerRunning', 'false');
        }
    });

    if (isTimerRunning && timerId) {
        document.querySelector('.start-time-text').textContent = 
            `Running Timer: ${formatTime(hours)}:${formatTime(minutes)}:${formatTime(seconds)}`;
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
});
