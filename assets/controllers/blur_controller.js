import {Controller} from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    connect() {
        let container = document.getElementById("blur-container");
        container.classList.add('bg-blur');
    }
}
