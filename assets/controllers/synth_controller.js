import {Controller} from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    connect() {


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////// VALUES INITIALIZATION

// url, for loading images (this should NOT work like this)
        const url = "http://localhost:8080";
// const url = "";

// initializing WebAudio API
        const audioContext = new AudioContext({
            latencyHint: "interactive",
            sampleRate: 48000,
        });

        let oscillators = [];
        let mainGainNode = null;
        let type = "sine";
        let synthStatus = "off";
        let modalStatus = "off";

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
        const saveForm = document.querySelector(".saveFormControlTextarea1");
        const saveFormKeys = document.querySelector(".saveFormControlTextarea2");
        const saveModal = document.getElementById("saveModal");

        const keyboardPic = document.getElementById("keyboard-pic");
        const keyboardPicMobile = document.getElementById("keyboard-pic-mobile");

// creating arrays containing notes, frequencies and keys
        const noteList = createDataArray("name");
        const noteFreq = createDataArray("frequency");
        const noteKey = createDataArray("key");

        function createDataArray(data) {
            let dataArray = [];

            for (let i = 1; i <= 13; i++) {
                if (data === "key") {
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

            keyElement.addEventListener("keydown", notePressed, false);
            keyElement.addEventListener("keyup", noteReleased, false);

            return keyElement;
        }

// initializing the whole keyboard thing
        function createKeyboard() {
            let keyboard = document.getElementById("keyboard");

            for (let i = 0; i <= noteFreq.length; i++) {
                keyboard.appendChild(createKey(noteFreq[i], noteKey[i]));
            }

            mainGainNode = audioContext.createGain();
            mainGainNode.connect(audioContext.destination);
        }

        createKeyboard();


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////// SOUND PLAY & STOP

// preventing notes from being fired up multiples times when keeping key pressed
        let keydown = false;

        function playNote(freq) {
            let osc = audioContext.createOscillator();

            osc.type = type;
            osc.frequency.value = freq;

            mainGainNode.gain.value = 1;

            osc.start();
            osc.connect(mainGainNode);

            return osc;
        }

// things to do when a key is pressed
        function notePressed(event) {
            let dataset = event.target.dataset;

            if (!dataset["pressed"]) {
                oscillators[dataset["note"]] = playNote(dataset["frequency"]);
                dataset["pressed"] = "yes";
            }
        }

// things to do when a key is released
        function noteReleased(event) {
            let dataset = event.target.dataset;

            if (dataset && dataset["pressed"]) {
                oscillators[dataset["note"]].stop();
                delete oscillators[dataset["note"]];
                delete dataset["pressed"];
            }
        }

// displaying input and note in console (why not?)
        function consoleKeyNote(note, key) {
            console.log(note + " (" + key.toUpperCase() + " pressed)");
        }

// this does some things (obviously)
        function thingsThatHappen(event, noteIndex) {
            if (!screenTitle.classList.contains("d-none")) {
                screenTitle.classList.add("d-none");
                screen.style.display = "initial";
                screenOptions.classList.remove("d-none");
                screenSeparator.classList.remove("d-none");
            }

            oscillators["note"] = playNote(noteFreq[noteIndex]);
            consoleKeyNote(noteList[noteIndex], event.key);

            // display notes and keys on screen and save form
            textNotes.textContent += noteList[noteIndex] + " ";
            textKeys.textContent += noteKey[noteIndex].toUpperCase() + " ";
            saveForm.value += noteList[noteIndex] + " ";
            saveFormKeys.value += noteKey[noteIndex].toUpperCase() + " ";
        }

// playing sound when key is pressed
        window.addEventListener(
            "keydown",
            function (event) {
                modalStatus = checkModalStatus();

                if (!keydown && synthStatus == "on" && modalStatus == "on") {
                    keydown = true;

                    if (event.defaultPrevented) {
                        return;
                    }

                    switch (event.key) {
                        case "q":
                            keyboardPic.src = url + "/build/images/synth/_d_c4.png";
                            keyboardPicMobile.src = url + "/build/images/synth/_m_c4.png";
                            thingsThatHappen(event, 0);
                            break;
                        case "z":
                            keyboardPic.src = url + "/build/images/synth/_d_cs4.png";
                            keyboardPicMobile.src = url + "/build/images/synth/_m_cs4.png";
                            thingsThatHappen(event, 1);
                            break;
                        case "s":
                            keyboardPic.src = url + "/build/images/synth/_d_d4.png";
                            keyboardPicMobile.src = url + "/build/images/synth/_m_d4.png";
                            thingsThatHappen(event, 2);
                            break;
                        case "e":
                            keyboardPic.src = url + "/build/images/synth/_d_ds4.png";
                            keyboardPicMobile.src = url + "/build/images/synth/_m_ds4.png";
                            thingsThatHappen(event, 3);
                            break;
                        case "d":
                            keyboardPic.src = url + "/build/images/synth/_d_e4.png";
                            keyboardPicMobile.src = url + "/build/images/synth/_m_e4.png";
                            thingsThatHappen(event, 4);
                            break;
                        case "f":
                            keyboardPic.src = url + "/build/images/synth/_d_f4.png";
                            keyboardPicMobile.src = url + "/build/images/synth/_m_f4.png";
                            thingsThatHappen(event, 5);
                            break;
                        case "t":
                            keyboardPic.src = url + "/build/images/synth/_d_fs4.png";
                            keyboardPicMobile.src = url + "/build/images/synth/_m_fs4.png";
                            thingsThatHappen(event, 6);
                            break;
                        case "g":
                            keyboardPic.src = url + "/build/images/synth/_d_g4.png";
                            keyboardPicMobile.src = url + "/build/images/synth/_m_g4.png";
                            thingsThatHappen(event, 7);
                            break;
                        case "y":
                            keyboardPic.src = url + "/build/images/synth/_d_gs4.png";
                            keyboardPicMobile.src = url + "/build/images/synth/_m_gs4.png";
                            thingsThatHappen(event, 8);
                            break;
                        case "h":
                            keyboardPic.src = url + "/build/images/synth/_d_a4.png";
                            keyboardPicMobile.src = url + "/build/images/synth/_m_a4.png";
                            thingsThatHappen(event, 9);
                            break;
                        case "u":
                            keyboardPic.src = url + "/build/images/synth/_d_as4.png";
                            keyboardPicMobile.src = url + "/build/images/synth/_m_as4.png";
                            thingsThatHappen(event, 10);
                            break;
                        case "j":
                            keyboardPic.src = url + "/build/images/synth/_d_b4.png";
                            keyboardPicMobile.src = url + "/build/images/synth/_m_b4.png";
                            thingsThatHappen(event, 11);
                            break;
                        case "k":
                            keyboardPic.src = url + "/build/images/synth/_d_c5.png";
                            keyboardPicMobile.src = url + "/build/images/synth/_m_c5.png";
                            thingsThatHappen(event, 12);
                            break;
                        default:
                            return;
                    }
                }
                event.preventDefault();
            },
            true
        );

// creating events for buttons (click and touch)
        for (let j = 0; j < noteList.length; j++) {
            let button = document.getElementById("button" + j);

            // set up touch events
            button.addEventListener("touchstart", function () {
                button.dispatchEvent(new KeyboardEvent("keydown", {key: noteKey[j]}));
            });
            button.addEventListener("touchend", stopSound, true);

            // set up click events
            button.addEventListener("mousedown", function () {
                button.dispatchEvent(new KeyboardEvent("keydown", {key: noteKey[j]}));
            });

            button.addEventListener("mouseup", stopSound, true);
        }

        window.addEventListener("keyup", stopSound, true);

// function to stop sound, called in multiple places
        function stopSound(event) {
            keydown = false;

            // not sure what this does
            if (event.defaultPrevented) {
                return;
            }

            // stop sound from playing
            if (oscillators["note"]) {
                oscillators["note"].stop();
            }

            // put back default picture
            keyboardPic.src = url + "/build/images/synth/_d_default.png";
            keyboardPicMobile.src = url + "/build/images/synth/_m_default.png";

            event.preventDefault();
        }

        const wait = (cb, time) => {
            return new Promise((res) => {
                setTimeout(() => {
                    cb();
                    res();
                }, time);
            });
        };


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

// clearing screen function
        clearScreen.addEventListener("click", function () {
            textNotes.innerHTML = "";
            textKeys.innerHTML = "";
            saveForm.value = "";
            saveFormKeys.value = "";
        });

// choosing waveform
        waveformPicker.addEventListener("click", function () {
            let waveform = waveformPicker.innerHTML;

            switch (waveform) {
                case "WAVEFORM: SINE":
                    waveformPicker.innerHTML = "WAVEFORM: SAWTOOTH";
                    type = "sawtooth";
                    break;
                case "WAVEFORM: SAWTOOTH":
                    waveformPicker.innerHTML = "WAVEFORM: TRIANGLE";
                    type = "triangle";
                    break;
                case "WAVEFORM: TRIANGLE":
                    waveformPicker.innerHTML = "WAVEFORM: SQUARE";
                    type = "square";
                    break;
                case "WAVEFORM: SQUARE":
                    waveformPicker.innerHTML = "WAVEFORM: SINE";
                    type = "sine";
                    break;
            }
        });

// choosing if displaying notes or keyboard keys
        displayTypeSelector.addEventListener("click", function () {
            let displayType = displayTypeSelector.innerHTML;

            if (displayType === "NOTES") {
                displayTypeSelector.innerHTML = "KEYS";
                textNotes.classList.add("d-none");
                textKeys.classList.remove("d-none");
            } else {
                displayTypeSelector.innerHTML = "NOTES";
                textNotes.classList.remove("d-none");
                textKeys.classList.add("d-none");
            }
        });

// checking modal status
        function checkModalStatus() {
            if (saveModal.classList.contains("show")) {
                modalStatus = "off";
            } else {
                modalStatus = "on";
            }

            return modalStatus;
        }

    }
}
