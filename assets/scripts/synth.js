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
const statusButton = document.getElementById("on-button");
const startup = document.getElementById("audio");
const screen = document.getElementById("screen");
const screenTitle = document.getElementById("screen-title");
const screenOptions = document.getElementById("screen-options");
const waveformPicker = document.getElementById("waveform-picker");
const clearScreen = document.getElementById("clear-screen");
const displayTypeSelector = document.getElementById("display-type");
const screenSeparator = document.getElementById("screen-separator");
const textNotes = document.getElementById("text-notes");
const textKeys = document.getElementById("text-keys");

const keyboardPic = document.getElementById("keyboard-pic");
const keyboardPicMobile = document.getElementById("keyboard-pic-mobile");


// creating arrays containing notes, frequencies and keys
const noteList = createDataArray("name");
const noteFreq = createDataArray("frequency");
const noteKey = createDataArray("key");

function createDataArray(data) {
    let dataArray = [];

    for (let i = 1; i <= 13; i++) {
        if (data == "key") {
            dataArray.push(
                document
                    .getElementById("note-table-" + i + "-" + data)
                    .innerHTML.toLowerCase()
            );
        } else {
            dataArray.push(
                document.getElementById("note-table-" + i + "-" + data).innerHTML
            );
        }
    }

    return dataArray;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////// CREATING KEYBOARD AND KEYS

// creating each key (one sound, one shortcut)
function createKey(note, key) {
    let keyElement = document.createElement("div");

    keyElement.dataset["note"] = note;
    keyElement.dataset["key"] = key;

    return keyElement;
}

// initializing the whole keyboard thing
function createKeyboard() {
    let keyboard = document.getElementById("keyboard");

    for (i = 0; i <= noteFreq.length; i++) {
        keyboard.appendChild(createKey(noteFreq[i], noteKey[i]));
    }

    mainGainNode = audioContext.createGain();
    mainGainNode.connect(audioContext.destination);
}

createKeyboard();


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
