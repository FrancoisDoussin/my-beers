const routes = require('../../public/js/fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
Routing.setRoutingData(routes);

let favorite = document.getElementsByClassName("beer-favorite");

for (let i=0; i< favorite.length; i++) {
    favorite[i].addEventListener("click", (event) => {
        let id = event.target.id;
        fetch(Routing.generate("beer_favorite", { id : id}))
            .then(function(response) {
                return response.json();
            })
            .then(function() {
                event.target.innerHTML = event.target.innerHTML === "favorite" ? "favorite_border" : "favorite";
            });
    });
}