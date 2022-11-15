import { Howl } from "howler"
console.log('fx init');

//sample fx
// var sound = new Howl({
//     src: ['sound.webm', 'sound.mp3', 'sound.wav'],
//     autoplay: true,
//     loop: true,
//     volume: 0.5,
//     onend: function() {
//       console.log('Finished!');
//     }
//   });

//fade
// var id1 = sound.play();
// sound.fade(1, 0, 1000, id1);

//pause
//sound.pause()

//resume
// sound.resume()?

const sfx = {
    menu: new Howl({
        src: ['/sfx/menu.mp3'],
        loop: true
    }),
    tap: new Howl({
        src: ['/sfx/tap.mp3'],
        loop: false
    }),
    classic: new Howl({
        src: ['/sfx/classic.mp3'],
        loop: true
    }),
    pvp: new Howl({
        src: ['/sfx/pvp.mp3'],
        loop: true
    }),
    tick: new Howl({
        src: ['/sfx/clock.mp3'],
        loop: false
    }),
    incorrect: new Howl({
        src: ['/sfx/incorrect.mp3'],
        loop: false
    }),
    correct: new Howl({
        src: ['/sfx/success-1.mp3'],
        loop: false
    }),
    lose: new Howl({
        src: ['/sfx/lose.mp3'],
        loop: false
    }),
    win: new Howl({
        src: ['/sfx/win.mp3'],
        loop: false
    }),
}

export default sfx;

