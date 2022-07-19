///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////// VALUES INITIALIZATION

// initializing WebAudio API
const audioContext = new AudioContext({
    latencyHint: "interactive",
    sampleRate: 48000,
});

let oscillators = [];
let mainGainNode = null;
let type = "sine";
let synthStatus = "off";

// getting elements from DOM
const startup = document.getElementById("audio");
const statusButton = document.getElementById("on-button");
const screenTitle = document.getElementById("screen-title");

const keyboardPic = document.getElementById("keyboard-pic");
const keyboardPicMobile = document.getElementById("keyboard-pic-mobile");


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////// OTHER FUNCTIONS

// on / off button
statusButton.addEventListener("click", function () {
    if (synthStatus === "off") {
        synthStatus = "on";
        screenTitle.classList.remove("d-none");
        screen.classList.add("screenBg");
        startup.play();
        statusButton.innerHTML = "OFF";
        statusButton.classList.remove("button-glowing");
    } else {
        window.location.reload();
    }
});
