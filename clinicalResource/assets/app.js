import './bootstrap.js';
import Chart from 'chart.js';
import * as ChartDataLabels from 'chartjs-plugin-datalabels';

Chart.register(ChartDataLabels.default ?? ChartDataLabels);

/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');


// Assets JS
// import './vendor/aos/aos.js';
// import './vendor/aos/aos.cjs.js';
// import './vendor/aos/aos.esm.js';
// import './vendor/purecounter/purecounter_vanilla.js';
// import './vendor/bootstrap/js/bootstrap.bundle.min.js';
// import './vendor/php-email-form/validate.js';
// import './vendor/glightbox/js/glightbox.min.js';
// import './vendor/swiper/swiper-bundle.min.js';
// import './vendor/imagesloaded/imagesloaded.pkgd.min.js';
// import './vendor/isotope-layout/isotope.pkgd.min.js';
// import './vendor/glightbox/js/glightbox.js';

import './js/main.js';
import './js/table_search.js';
import './js/mapa.js';
import './js/animacion_tooltip.js';
import './js/autocomplete_search.js';

// Assets CSS


import './vendor/bootstrap-icons/font/bootstrap-icons.min.css';
import './css/aos.css';
//import './vendor/aos/aos.css';
import './css/glightbox.css';
//import './vendor/glightbox/css/glightbox.css';
import './css/swiper-bundle.min.css';
//import './vendor/swiper/swiper-bundle.min.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import './css/main.css';
import './css/search.css';
import './css/animacion_tooltip.css';
import '../assets/css/aos.css';
import '../assets/css/glightbox.css';
import '../assets/css/swiper-bundle.min.css';
import '../assets/css/animacion_result_search_acordeon.css';
import '@fortawesome/fontawesome-free/css/all.css';
//
// import {Chart} from "./vendor/chart.js/chart.js.index.js";
// Chart.register(ChartDataLabels);

