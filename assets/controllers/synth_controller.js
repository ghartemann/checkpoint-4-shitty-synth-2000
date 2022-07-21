import {Controller} from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    connect() {

// TODO: all this code used to be in scripts/synth.js, but I couldn't import it here
// so this will have to do unfortunately

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
        let synthStatus = false;
        let modalStatus = false;
        let lockScreen = false;

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
        const loadSelector = document.getElementById("load-selector");
        const tracksToLoad = document.getElementsByClassName("tracks-to-load");
        const loadButton = document.getElementById("load-button");
        const saveButton = document.getElementById("save-button");
        const readOnly = document.getElementById("read-only");
        const playbackButton = document.getElementById("playback-button");

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

        // display notes and keys on screen and save form
        function displayNotes(noteIndex) {
            if (lockScreen === false) {
                textNotes.textContent += noteList[noteIndex] + " ";
                textKeys.textContent += noteKey[noteIndex].toUpperCase() + " ";
                saveForm.value += noteList[noteIndex] + " ";
                saveFormKeys.value += noteKey[noteIndex].toUpperCase() + " ";
            }
        }

        // hiding stuff when synth starts
        function initializeScreen() {
            screenTitle.classList.add("d-none");
            screen.style.display = "initial";
            screenOptions.classList.remove("d-none");
            screenSeparator.classList.remove("d-none");

        }

        // playing sound when key is pressed
        window.addEventListener("keydown", pressKey, true);

        function pressKey(event) {
            // initialize screen
            if (!screenTitle.classList.contains("d-none")) {
                initializeScreen();
            }

            // stop startup audio when a key is pressed
            startup.pause();
            startup.currentTime = 0;

            modalStatus = checkModalStatus();

            if (!keydown && synthStatus === true && modalStatus === true) {
                determineKey(event);
            }
        }

        // do various things depending on what key is pressed
        function determineKey(event) {
            keydown = true;

            // TODO: is this useful?
            if (event.defaultPrevented) {
                return;
            }

            switch (event.key) {
                case "q":
                    keyboardPic.src = url + "/build/images/synth/_d_c4.png";
                    keyboardPicMobile.src = url + "/build/images/synth/_m_c4.png";
                    oscillators["note"] = playNote(noteFreq[0]);
                    displayNotes(0);
                    break;
                case "z":
                    keyboardPic.src = url + "/build/images/synth/_d_cs4.png";
                    keyboardPicMobile.src = url + "/build/images/synth/_m_cs4.png";
                    oscillators["note"] = playNote(noteFreq[1]);
                    displayNotes(1);
                    break;
                case "s":
                    keyboardPic.src = url + "/build/images/synth/_d_d4.png";
                    keyboardPicMobile.src = url + "/build/images/synth/_m_d4.png";
                    oscillators["note"] = playNote(noteFreq[2]);
                    displayNotes(2);
                    break;
                case "e":
                    keyboardPic.src = url + "/build/images/synth/_d_ds4.png";
                    keyboardPicMobile.src = url + "/build/images/synth/_m_ds4.png";
                    oscillators["note"] = playNote(noteFreq[3]);
                    displayNotes(3);
                    break;
                case "d":
                    keyboardPic.src = url + "/build/images/synth/_d_e4.png";
                    keyboardPicMobile.src = url + "/build/images/synth/_m_e4.png";
                    oscillators["note"] = playNote(noteFreq[4]);
                    displayNotes(4);
                    break;
                case "f":
                    keyboardPic.src = url + "/build/images/synth/_d_f4.png";
                    keyboardPicMobile.src = url + "/build/images/synth/_m_f4.png";
                    oscillators["note"] = playNote(noteFreq[5]);
                    displayNotes(5);
                    break;
                case "t":
                    keyboardPic.src = url + "/build/images/synth/_d_fs4.png";
                    keyboardPicMobile.src = url + "/build/images/synth/_m_fs4.png";
                    oscillators["note"] = playNote(noteFreq[6]);
                    displayNotes(6);
                    break;
                case "g":
                    keyboardPic.src = url + "/build/images/synth/_d_g4.png";
                    keyboardPicMobile.src = url + "/build/images/synth/_m_g4.png";
                    oscillators["note"] = playNote(noteFreq[7]);
                    displayNotes(7);
                    break;
                case "y":
                    keyboardPic.src = url + "/build/images/synth/_d_gs4.png";
                    keyboardPicMobile.src = url + "/build/images/synth/_m_gs4.png";
                    oscillators["note"] = playNote(noteFreq[8]);
                    displayNotes(8);
                    break;
                case "h":
                    keyboardPic.src = url + "/build/images/synth/_d_a4.png";
                    keyboardPicMobile.src = url + "/build/images/synth/_m_a4.png";
                    oscillators["note"] = playNote(noteFreq[9]);
                    displayNotes(9);
                    break;
                case "u":
                    keyboardPic.src = url + "/build/images/synth/_d_as4.png";
                    keyboardPicMobile.src = url + "/build/images/synth/_m_as4.png";
                    oscillators["note"] = playNote(noteFreq[10]);
                    displayNotes(10);
                    break;
                case "j":
                    keyboardPic.src = url + "/build/images/synth/_d_b4.png";
                    keyboardPicMobile.src = url + "/build/images/synth/_m_b4.png";
                    oscillators["note"] = playNote(noteFreq[11]);
                    displayNotes(11);
                    break;
                case "k":
                    keyboardPic.src = url + "/build/images/synth/_d_c5.png";
                    keyboardPicMobile.src = url + "/build/images/synth/_m_c5.png";
                    oscillators["note"] = playNote(noteFreq[12]);
                    displayNotes(12);
                    break;
                default:
                    return;
            }
        }

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


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////// OTHER FUNCTIONS

        // on / off button
        statusButton.addEventListener("click", onOff);

        function onOff() {
            if (synthStatus === false) {
                synthStatus = true;
                screenTitle.classList.remove("d-none");
                screen.classList.add("screenBg");
                startup.play();
                statusButton.innerHTML = "OFF";
                statusButton.classList.remove("button-glowing");
            } else {
                window.location.reload();
            }
        }

        // clearing screen function
        clearScreen.addEventListener("click", clear);

        function clear() {
            textNotes.innerHTML = "";
            textKeys.innerHTML = "";
            saveForm.value = "";
            saveFormKeys.value = "";
            lockScreen = false;
            saveButton.classList.remove("d-none");
            readOnly.classList.add("d-none");
        }

        // choosing waveform
        waveformPicker.addEventListener("click", pickWaveform);

        function pickWaveform() {
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
        }

        // choosing if displaying notes or keyboard keys
        displayTypeSelector.addEventListener("click", selectDisplayType);

        function selectDisplayType() {
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
        }

        // checking modal status
        function checkModalStatus() {
            if (saveModal.classList.contains("show")) {
                modalStatus = false;
            } else {
                modalStatus = true;
            }

            return modalStatus;
        }

        // displaying track according to select
        loadSelector.addEventListener("change", displayTrack);

        function displayTrack() {
            if (loadSelector.value !== "none") {
                loadButton.children[0].disabled = false;
                for (const element of tracksToLoad) {
                    if ("track_" + loadSelector.value === element.id) {
                        element.classList.remove("d-none");
                        element.children[4].id = "load-notes";
                        element.children[6].id = "load-keys";
                    } else {
                        element.classList.add("d-none");
                        element.children[4].removeAttribute('id');
                        element.children[6].removeAttribute('id');
                    }
                }
            } else {
                loadButton.children[0].disabled = true;
                for (const element of tracksToLoad) {
                    element.classList.add("d-none");
                }
            }
        }

        // load track
        loadButton.addEventListener("click", load);

        function load() {
            lockScreen = true;
            saveButton.classList.add("d-none");
            readOnly.classList.remove("d-none");
            textNotes.textContent = document.getElementById("load-notes").innerHTML;
            textKeys.textContent = document.getElementById("load-keys").innerHTML;
        }
        
        // playback tracks from what's on the screen
        playbackButton.addEventListener("click", playbackSong);

        async function playbackSong() {
            lockScreen = true;

            if (textNotes.textContent === "" || textNotes.textContent === "NOTHING TO PLAY") {
                textNotes.textContent = "NOTHING TO PLAY";
                textKeys.textContent = "NOTHING TO PLAY";
            } else {
                // get track from screen and put it in an array
                let trackToPlayback = document.getElementById("text-keys").innerHTML.toLowerCase();
                let trackArray = trackToPlayback.split(" ");

                // start looping on notes (ugly code)
                let k = 0;
                while (k < trackArray.length) {
                    console.log(k);
                    dispatchEvent(new KeyboardEvent("keydown", {key: trackArray[k]}));

                    // TODO: add real values to play in rythm?
                    let randomValue = (Math.random() * 250) + 250;

                    setTimeout(function () {

                        // stop sound from playing
                        if (oscillators["note"]) {
                            oscillators["note"].stop();
                        }
                        keydown = false;

                        // put back default picture
                        keyboardPic.src = url + "/build/images/synth/_d_default.png";
                        keyboardPicMobile.src = url + "/build/images/synth/_m_default.png";
                    }, randomValue);
                    await wait(() => {
                        k++;
                    }, randomValue + 50);
                }
            }
        }

        const wait = (cb, time) => {
            return new Promise((res) => {
                setTimeout(() => {
                    cb();
                    res();
                }, time);
            });
        };
    }
}
