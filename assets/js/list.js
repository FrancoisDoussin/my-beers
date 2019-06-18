const routes = require('../../public/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
Routing.setRoutingData(routes);

document
    .getElementById("beers-list")
    .addEventListener("change", (event) => {
        fetch(Routing.generate("beer_detail", { id: event.target.value }))
            .then(function(response) {
                return response.json();
            })
            .then(function(result) {
                document.getElementById("beer-detail").innerHTML = result.html;
            });
    });