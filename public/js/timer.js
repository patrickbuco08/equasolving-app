(() => {

    const timer = {
        minutes: 1,
        seconds: 15,
        timerLoop: null,
        init: function () {
            const countDownTimer = this.countDownTimer.bind(this);

            this.timerLoop = setInterval(countDownTimer, 1000);
            this.countDownTimer()
        },
        run: function () {
            clearInterval(this.timerLoop);
            const countDownTimer = this.countDownTimer.bind(this);
            this.timerLoop = setInterval(countDownTimer, 1000);
            timer.createDisplay();
        },
        countDownTimer: function () {
            let newSeconds = this.minutes * 60 + this.seconds;
            newSeconds--;

            this.seconds = newSeconds % 60;
            this.minutes = Math.floor(newSeconds / 60);

            this.createDisplay();
            console.log(`CountDownTimer | minute: ${this.minutes} | seconds: ${this.seconds}`)
        },
        createDisplay: function () {
            if (this.isGameOver()) {
                this.setGameOver();
                return;
            }

            if (this.seconds < 10) {
                if (this.seconds == 0) {
                    $('div.timer').html(`minute: ${this.minutes-1} | seconds: 6${this.seconds}`);
                    return;
                }
                $('div.timer').html(`minute: ${this.minutes} | seconds: 0${this.seconds}`);
                return;
            }

            $('div.timer').html(`minute: ${this.minutes} | seconds: ${this.seconds}`);
        },
        isGameOver: function () {
            return this.minutes <= 0 && this.seconds <= 0;
        },
        setGameOver: function () {
            $('div.timer').html(`Game Over`);
            clearInterval(this.timerLoop);
            console.log('END From set game cover')
        },
        addTime: function (additionalTime = 3) {
            if ((additionalTime + this.seconds) > 60) {
                console.log('fthis seconds', this.seconds)
                this.minutes += Math.floor((additionalTime + this.seconds) / 60)
                this.seconds = additionalTime % 60
            } else {
                console.log('from else', this.seconds)
                this.seconds = this.seconds + additionalTime
            }
            timer.run();
        },
        deductTime: function (deductionTime = 3) {

            if ((timer.seconds - deductionTime) < 0 && timer.minutes == 0) {
                timer.setGameOver();
                return;
            }

            if ((this.seconds - deductionTime) < 0) {
                this.seconds = 60 - (deductionTime - this.seconds)
                this.minutes = this.minutes - 1
                console.log('sec true', this.seconds)
            } else {
                this.seconds = this.seconds - deductionTime
                console.log('sec false', this.seconds)
            }
            timer.run();
        }

    };

    //initialize timer
    timer.init();

    $('button#add-time').click(function (e) {
        e.preventDefault();
        console.log('triggered add time')
        timer.addTime(3);
    });

    $('button#deduct-time').click(function (e) {
        e.preventDefault();
        const deductionTime = 3;
        timer.deductTime(deductionTime);
    });

})();
