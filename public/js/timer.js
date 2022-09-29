(() => {

    let timer = {
        minutes: 1,
        seconds: 30,
    };

    //initialize timer
    let timerLoop = setInterval(countDownTimer, 1000);
    countDownTimer();

    function countDownTimer() {
        let newSeconds = timer.minutes * 60 + timer.seconds; //
        newSeconds--; //64

        timer = {
            ...timer,
            seconds: newSeconds % 60,
            minutes: Math.floor(newSeconds / 60)
        };

        createDisplay();
        console.log(`minute: ${timer.minutes} | seconds: ${timer.seconds}`)
    }

    function createDisplay() {
        if (isGameOver()) {
            setGameOver();
            return;
        }

        if (timer.seconds > 10) {
            $('div.timer').html(`minute: ${timer.minutes} | seconds: ${timer.seconds}`);
            return;
        }

        if (timer.seconds < 10) {
            if (timer.seconds == 0) {
                $('div.timer').html(`minute: ${timer.minutes-1} | seconds: 6${timer.seconds}`);
                return;
            }
            $('div.timer').html(`minute: ${timer.minutes} | seconds: 0${timer.seconds}`);
        }
    }

    function isGameOver() {
        return timer.minutes <= 0 && timer.seconds <= 0;
    }

    function setGameOver() {
        $('div.timer').html(`Game Over`);
        clearInterval(timerLoop);
        console.log('END')
    }

    function addTime(additionalTime = 3) {
        if ((additionalTime + timer.seconds >= 60)) {
            timer = {
                ...timer,
                seconds: additionalTime % 60,
                minutes: Math.floor((additionalTime + timer.seconds) / 60)
            }
        } else {
            timer = {
                ...timer,
                seconds: timer.seconds + additionalTime
            };
        }
    }

    function deductTime(deductionTime = 3) {
        if ((timer.seconds - deductionTime) < 0 && timer.minutes == 0) {
            setGameOver()
            return;
        }

        if ((timer.seconds - deductionTime) < 0) {
            timer = {
                ...timer,
                seconds: 60 - (deductionTime - timer.seconds),
                minutes: timer.minutes - 1
            };
            console.log('sec true', timer.seconds)
        } else {
            timer = {
                ...timer,
                seconds: timer.seconds - deductionTime
            }
            console.log('sec false', timer.seconds)
        }
    }

    function reRunTimer() {
        clearInterval(timerLoop);
        timerLoop = setInterval(countDownTimer, 1000);
    }


    $('button#add-time').click(function (e) {
        e.preventDefault();
        console.log('triggered add time')
        addTime(3);
        reRunTimer();
        createDisplay();
    });

    $('button#deduct-time').click(function (e) {
        e.preventDefault();
        deductTime(3);
        reRunTimer();
        createDisplay();
    });

})();
