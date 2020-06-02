window._ = require('lodash');



try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    require('bootstrap-fileinput/js/plugins/piexif.js');
    require('bootstrap-fileinput/js/plugins/sortable.js');
    require('bootstrap-fileinput/js/plugins/purify.js');
    require('bootstrap');
    require('bootstrap-fileinput/js/fileinput.js');
    require('bootstrap-fileinput/themes/fas/theme.js');
    require('sweetalert');
} catch (e) {}


window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


