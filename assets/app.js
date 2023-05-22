/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';
require ('bootstrap');
import 'bootstrap-icons/font/bootstrap-icons.css';

document.getElementById('watchlist').addEventListener('click', addToWatchlist);

function addToWatchlist(event) {
    event.preventDefault();

    const watchlistLink = event.currentTarget;
    const link = watchlistLink.href;

    try {
        fetch(link)
            .then(res => res.json())
            .then(data => {
                const watchlistIcon = watchlistLink.firstElementChild;
                if (data.isInWatchlist) {
                    watchlistIcon.classList.remove("bi-heart");
                    watchlistIcon.classList.add("bi-heart-fill");
                } else {
                    watchlistIcon.classList.remove("bi-heart-fill");
                    watchlistIcon.classList.add("bi-heart");
                }
            });
    } catch (error) {
        console.error(error);
    }
}