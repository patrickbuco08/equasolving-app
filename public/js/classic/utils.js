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
        if(this.level + 1 <= 10){
            const rand = Math.random() * (this.operations.length - 2) | 0;
            return this.operations[rand];
        }
        else {
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
                if(this.level + 1 <= 5){
                    a = this.randomNumber(1, 9);
                    b = this.randomNumber(1, 9);
                }
                else {
                    a = this.randomNumber(9, 90);
                    b = this.randomNumber(9, 90);
                }
                
                answer = a + b;
                break;

            case 'subtraction':
                if(this.level + 1 <= 5){
                    a = this.randomNumber(1, 9);
                    b = this.randomNumber(a > 1 ? 1 : 0, a);
                }
                else {
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
            htmlDOMLvl = '',
            htmlDOM = '';

        while (numberOfEquation) {
            let equation = this.generateEquation();

            equations = [...equations, equation];
            numberOfEquation--;

        }
        let countOfData = 1;
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
            if(countOfData == 2){
                htmlDOM += `<div class="row-${countOfData}-${countOfData+1}">`;
            }
            htmlDOM += `<div class="row" id="row-${countOfData}"><span class="data" id="data-${countOfData}" data-answer=${equation.answer} >${equation.a}${operation}${equation.b}=?</span></div>`;
            
            if(countOfData == 3){
                htmlDOM += `</div>`;
            }
            
            countOfData++;
        });
        this.answers = []
        $('div.game-grid').html(htmlDOM);
        this.level++;
        htmlDOMLvl = 'Level: '+ this.level;
        $('div.level span#level').html(htmlDOMLvl);
    }

}

export const timer = {
    minutes: 0,
    seconds: 22,
    timerLoop: null,
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
        clearInterval(gameTimer.timerLoop);
        console.log("game pause");
    },
    continue: function () {
        this.init();
        gameTimer.init();
    },
    quit: function () {
        this.minutes = 0;
        this.seconds = 0;
        this.createDisplay();
    },
    playagain: function (){
        this.minutes = 0;
        this.seconds = 22;
        gameTimer.minutes = 0;
        gameTimer.seconds = 0;
        $('div#main-default-summary').removeClass("fadein-animation");
        $('div#main-default-summary').hide();
        $('.eq-content-area').show();
        this.continue();
        
    },
    loading: function(){
        if($("#content-section").hasClass("start")){
            setTimeout(() => { 
                $('#main-default-loading').hide();
                $('body#main-default').removeClass('flex-jc-c-imp');
                $('div#main-default-summary').hide();
                $('.eq-content-area').show();
                $('#content-section').removeClass('start');
                timer.continue();
              }, 3000);
            }
        
        
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
        if(!$('body#main-default').hasClass('flex-jc-c-imp')){
            setTimeout(() => { 
                this.loading();
                  }, 3000)
        }
        if (this.isGameOver()) {
            this.setGameOver();
            return;
        }

        if (this.seconds < 10) {
            if (this.seconds == 0 && this.minutes > 0) {
                $('div .timer-container input#timer').val(`${this.minutes}: 0${this.seconds}`);
                setTimeout(() => {
                    $('div .timer-container input#timer').val(`${this.minutes}: ${this.seconds}`);
                }, 1000);
                return;
            }
            $('div .timer-container input#timer').val(`${this.minutes}: 0${this.seconds}`);
            return;
        }

        $('div .timer-container input#timer').val(`${this.minutes}: ${this.seconds}`);
    },
    isGameOver: function () {
        return this.minutes <= 0 && this.seconds <= 0;
    },
    setGameOver: function () {
        $('.eq-content-area').hide();
        $('div#main-default-summary').addClass("fadein-animation");
        $('div#main-default-summary').show();
        $('body#main-default').addClass("flex-jc-c-imp");

        // setTimeout(() => { 

        //  }, 3000)
        gameTimer.trophyCount();
        $('span#summary-trophy').text(`Trophy: ` + gameTimer.trophy);
        $('span#summary-level').text(`Level: ` + equation.level);
        clearInterval(this.timerLoop);
        clearInterval(gameTimer.timerLoop);
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

export const gameTimer = {
    minutes: 0,
    seconds: 0,
    trophy: 0,
    addtrophycounter: 1,
    timerLoop: null,
    init: function () {
        const countUpTimer = this.countUpTimer.bind(this);

        this.timerLoop = setInterval(countUpTimer, 1000);
        this.countUpTimer();
    },
    run: function () {
        clearInterval(this.timerLoop);
        const countUpTimer = this.countUpTimer.bind(this);
        this.timerLoop = setInterval(countUpTimer, 1000);
        timer.createDisplay();
    },
    countUpTimer: function () {
        let newSeconds = this.minutes * 60 + this.seconds;
        newSeconds++;

        this.seconds = newSeconds % 60;
        this.minutes = Math.floor(newSeconds / 60);

        this.createDisplay();
        console.log(`CountUpTimer | minute: ${this.minutes} | seconds: ${this.seconds}`)
    },
    trophyCount: function () {
        let numberofSeconds = this.minutes * 60 + this.seconds;
        this.trophy = Math.floor(numberofSeconds / 30);
        
        if(this.addtrophycounter == this.trophy){
            $('span#add-trophy').addClass(`add-trophy-absolute move-up-animation`);
            setTimeout(() => {
                $('span#add-trophy').removeClass(`add-trophy-absolute move-up-animation`);
            }, 1500);
            this.addtrophycounter++;
        }
    },
    createDisplay: function () {
        this.trophyCount();
        $('div .timer-container input#trophy').val(`${this.trophy}`);
        
        return;
        
    },

};

export function sorted(arr) {
    let second_index;
    for (let first_index = 0; first_index < arr.length; first_index++) {
        second_index = first_index + 1;
        if (arr[second_index] - arr[first_index] < 0) return false;
    }
    return true;
}