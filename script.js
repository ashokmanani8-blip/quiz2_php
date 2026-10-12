function nextQuestion(currentIndex, totalQuestions) {
    document.getElementById('q-' + currentIndex).style.display = 'none';
    let nextIndex = currentIndex + 1;
    if (nextIndex < totalQuestions) {
        document.getElementById('q-' + nextIndex).style.display = 'block';
    }
}

function prevQuestion(currentIndex) {
    document.getElementById('q-' + currentIndex).style.display = 'none';
    let prevIndex = currentIndex - 1;
    document.getElementById('q-' + prevIndex).style.display = 'block';
}

// Timer 
window.onload = function() {
    let timerElement = document.getElementById('time');
    if (timerElement) {
        let duration = 60 * 10;
        let timer = duration, minutes, seconds;
        
        let interval = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            timerElement.textContent = minutes + ":" + seconds;

            if (--timer < 0) {
                clearInterval(interval);
                alert("Time is up! Submitting your quiz.");
                document.getElementById('quizForm').submit();
            }
        }, 1000);
    }
};