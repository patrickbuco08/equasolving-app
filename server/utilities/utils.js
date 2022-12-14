const { JSDOM } = require( "jsdom" );
const { window } = new JSDOM( "" );
const $ = require( "jquery" )( window );

const equation = {
    answers: [],
    operations: ['addition', 'subtraction', 'multiplication', 'division'],
    setAnswer: function (answer) {
        this.answers.push(answer)
    },
    numberMapper: function (min, max, type) {
        const numberMap = {};

        if (type == 'random-symmetry') {
            const symmetry = ['odd', 'even'];
            type = symmetry[Math.floor(Math.random() * 2)];
        }

        const numbers = this.generateNumbers(min, max, type);


        for (let i = 0; i < numbers.length; i++) {
            numberMap[numbers[i]] = [];
            for (let j = 2; j < numbers[i]; j++) {
                if (numbers[i] % j == 0) {
                    numberMap[numbers[i]] = [...numberMap[numbers[i]], j]
                }
            }
        }

        for (const key in numberMap) {
            if (numberMap[key].length <= 0) {
                delete numberMap[key]
            }
        }
        return numberMap;
    },
    generateNumbers: function (min, max, type) {
        let numbers = [],
            symmetry = type == 'odd' ? 1 : 0;

        for (min; min <= max; min++) {
            if (min % 2 == symmetry) {
                numbers = [...numbers, min]
            }
        }
        return numbers;
    },
    randomOperation: function () {
        const rand = Math.random() * this.operations.length | 0;
        return this.operations[rand];
    },
    randomNumber: function (min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    },
    generateEquation: function () {
        let a = 0,
            b = 0,
            answer = 0,
            operation = this.randomOperation();

        switch (operation) {

            case 'addition':
                // lower the number
                a = this.randomNumber(1, 9);
                b = this.randomNumber(1, 9);

                // a = this.randomNumber(9, 90);
                // b = this.randomNumber(9, 90);
                answer = a + b;
                break;

            case 'subtraction':
                // lower the number
                a = this.randomNumber(1, 9);
                b = this.randomNumber(a > 1 ? 1 : 0, a);

                // a = this.randomNumber(10, 99);
                // b = this.randomNumber(a > 10 ? 10 : 0, a);
                answer = a - b;
                break;

            case 'multiplication':
                a = this.randomNumber(3, 20);
                b = this.randomNumber(2, 10);
                answer = a * b;
                break;

            case 'division':
                const obj = this.numberMapper(3, 99, 'random-symmetry');
                const keys = Object.keys(obj);
                const dividend = parseInt(keys[equation.randomNumber(0, keys.length - 1)]);
                const divisor = obj[dividend][this.randomNumber(0, obj[dividend].length - 1)]

                a = dividend;
                b = divisor;
                answer = a / b;
                break;
        }

        return {
            a,
            b,
            operation,
            answer
        };

    },
    isAnswerSorted: function sorted(answers) {
        let second_index;
        for (let first_index = 0; first_index < this.answers.length; first_index++) {
            second_index = first_index + 1;
            if (this.answers[second_index] - this.answers[first_index] < 0) return false;
        }
        return true;
    },
    generateDOM: function () {
        let equations = [],
            numberOfEquation = 4,
            htmlDOM = '';

        while (numberOfEquation) {
            let equation = this.generateEquation();

            equations = [...equations, equation];
            numberOfEquation--;

        }

        this.answers = []
        return equations;
    }

}

const timer = {
    minutes: 3,
    seconds: 60,
    timerLoop: null,
    fx: {
        success: 'animated bounce',
        failed: 'animated headShake',
        ends: 'animationend AnimationEnd mozAnimationEnd webkitAnimationEnd'
    },
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
                $('div span#timer').text(`${this.minutes-1}: 6${this.seconds}`);
                return;
            }
            $('div span#timer').text(`${this.minutes}: 0${this.seconds}`);
            return;
        }

        $('div span#timer').text(`${this.minutes}: ${this.seconds}`);
    },
    isGameOver: function () {
        return this.minutes <= 0 && this.seconds <= 0;
    },
    setGameOver: function () {
        $('div.equation-container').remove();
        $('div.reset').remove();
        $('div.timer').addClass('full-screen animated zoomIn').one(this.fxEnds, function () {
            $('div.timer').removeClass('animated zoomIn');
            $('div.timer').addClass('animated hinge');
        });
        // setTimeout(() => { 

        //  }, 3000)
        $('div span#timer').text(`Game Over`);
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

module.exports = equation