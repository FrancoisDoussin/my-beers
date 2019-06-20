const $ = require('jquery');
require('bootstrap');
require('../css/app.scss');

if ($('.alert').length) {
    setTimeout(()=>{$('.alert').alert('close')},4000);
}