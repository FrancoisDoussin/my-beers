const routes = require('../../public/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

Routing.setRoutingData(routes);

document.getElementById("get-random").addEventListener('click', (event) => {
    fetch(Routing.generate('beer_random_json'))
        .then((response) => {
            return response.json();
        })
        .then((datas) => {
            document.getElementById("random-beer").innerHTML = datas.html;
        })
});