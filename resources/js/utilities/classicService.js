import $ from "jquery";
import sfx from '../sfx';

import {
    renderClassicSummary
} from "./request";

export const equation = {
    answers: [],
    level: 0,
    countArr: 0,
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
        if (this.level + 1 <= 10) {
            const rand = Math.random() * (this.operations.length - 2) | 0;
            return this.operations[rand];
        } else {
            const rand = Math.random() * this.operations.length | 0;
            return this.operations[rand];
        }
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
                if (this.level + 1 <= 5) {
                    a = this.randomNumber(1, 9);
                    b = this.randomNumber(1, 9);
                } else {
                    a = this.randomNumber(9, 90);
                    b = this.randomNumber(9, 90);
                }

                answer = a + b;
                break;

            case 'subtraction':
                if (this.level + 1 <= 5) {
                    a = this.randomNumber(1, 9);
                    b = this.randomNumber(a > 1 ? 1 : 0, a);
                } else {
                    a = this.randomNumber(10, 99);
                    b = this.randomNumber(a > 10 ? 10 : 0, a);
                }
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
            index = 1,
            htmlDOM = '';

        while (numberOfEquation) {
            let equation = this.generateEquation();

            equations = [...equations, equation];
            numberOfEquation--;

        }

        equations.forEach(equation => {
            let operation = '';

            switch (equation.operation) {
                case 'addition':
                    operation = '+';
                    break;
                case 'subtraction':
                    operation = '-';
                    break;
                case 'multiplication':
                    operation = 'x';
                    break;
                case 'division':
                    operation = '/';
                    break;
            }

            htmlDOM += `<div class="equation equation-${index}" data-answer=${equation.answer}>
            <span class="circle"></span>
            <span id="equation-1">${equation.a}${operation}${equation.b}=???</span>
            </div>`;
            index++;
        });
        htmlDOM += `<div class="big-square"></div>`;

        this.answers = []; //reset answer

        $('div.game-area').html(htmlDOM);
        this.level++;
        $('div.level span').html(`Level: ${this.level}`);
        console.log('what happened?');
    }

}

export const timer = {
    minutes: 0,
    seconds: 22,
    timerLoop: null,
    trophies: 0,
    trophiesCountDown: 5,
    init: function () {
        const countDownTimer = this.countDownTimer.bind(this);
        this.timerLoop = setInterval(countDownTimer, 1000);
        this.countDownTimer();
    },
    run: function () {
        clearInterval(this.timerLoop);
        const countDownTimer = this.countDownTimer.bind(this);
        this.timerLoop = setInterval(countDownTimer, 1000);
        this.createDisplay();
    },
    pause: function () {
        clearInterval(this.timerLoop);
        console.log("game pause");
    },
    continue: function () {
        this.init();
    },
    quit: function () {
        this.minutes = 0;
        this.seconds = 0;
        this.createDisplay();
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
            if (this.seconds == 0 && this.minutes > 0) {
                $('span#countdown-timer').text(`${this.minutes}: 0${this.seconds}`);
                setTimeout(() => {
                    $('span#countdown-timer').text(`${this.minutes}: ${this.seconds}`);
                }, 1000);
                return;
            }
            $('span#countdown-timer').text(`${this.minutes}: 0${this.seconds}`);
            return;
        }

        $('span#countdown-timer').text(`${this.minutes}: ${this.seconds}`);

        this.trophiesCountDown--;

        if (this.trophiesCountDown == 0) {
            this.trophies++; //add trophy
            this.trophiesCountDown = 5; //bring back the countdown
            $('span#trophies-holder').text(`${this.trophies} ${ this.trophies <= 1 ? 'pt' : 'pts' }`);
        }

    },
    isGameOver: function () {
        return this.minutes <= 0 && this.seconds <= 0;
    },
    setGameOver: async function () {
        clearInterval(this.timerLoop);
        sfx.classic.pause();
        sfx.win.play();

        const summaryUI = await renderClassicSummary(equation.level, this.trophies);
        $('div#root').html(summaryUI);
    },
    addTime: function (additionalTime = 3) {
        if ((additionalTime + this.seconds) > 60) {
            console.log('this seconds', this.seconds)
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
