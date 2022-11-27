const createUserDOM = (users) => {
    const contestants = [];


    for (const key in users.contestants) {
        if (Object.hasOwnProperty.call(users.contestants, key)) {
            const user = users.contestants[key];
            contestants.push(user);
        }
    }
    const player_one = contestants[0];
    const player_two = contestants[1];

    $('div#player-one-name').html(player_one.name);
    $('div#player-two-name').html(player_two.name);

    $('div.points-holder.one').attr('id', `player-${player_one.id}-points`).html(player_one.points > 1 ? `${player_one.points} points` : `${player_one.points} point`);
    $('div.points-holder.two').attr('id', `player-${player_two.id}-points`).html(player_two.points > 1 ? `${player_two.points} points` : `${player_two.points} point`);
}

const generateEquation = (eq) => {
    let equations = eq,
        htmlDOM = '',
        index = 1;

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

        // htmlDOM += `<div class="equation" data-answer=${equation.answer} >${equation.a}${operation}${equation.b}=???</div>`;
        htmlDOM += `<div class="equation equation-${index}" data-answer=${equation.answer}>
            <span class="circle"></span>
            <span id="equation-1">${equation.a}${operation}${equation.b}</span>
        </div>`;
        index++;
    });

    htmlDOM += `<div class="big-square"></div>`;
    $('div.game-area').html(htmlDOM);
}

const createTimerDisplay = (cd) => { 

    const newSeconds = cd;

    const seconds = newSeconds % 60;
    const minutes = Math.floor(newSeconds / 60);

    if (seconds < 10) {
        if (seconds == 0 && minutes > 0) {
            $('div.countdown').html(`${minutes}: 0${seconds}`);
            setTimeout(() => {
                $('div.countdown').html(`${minutes}: ${seconds}`);
            }, 1000);
            return;
        }
        $('div.countdown').html(`${minutes}: 0${seconds}`);
        return;
    }
    console.log(`sec: ${seconds} | min: ${minutes}`);
    $('div.countdown').html(`${minutes}: ${seconds}`);
 }


const getParam = () => { 
    const query = window.location.search,
        parameters = new URLSearchParams(query),
        id = parameters.get('id'),
        name = parameters.get('name'),
        room = parameters.get('room')

    return {
        id,
        name,
        room
    };
 }

export {
    createUserDOM,
    generateEquation,
    createTimerDisplay,
    getParam
}
