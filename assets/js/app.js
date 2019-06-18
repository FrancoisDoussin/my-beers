const $ = require('jquery');
require('bootstrap');
require('../css/app.css');

if ($('.alert').length) {
    setTimeout(()=>{$('.alert').alert('close')},4000);
}
