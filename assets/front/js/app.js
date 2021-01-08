/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */


// any CSS you import will output into a single css file (app.css in this case)
import '../styles/app.scss';
import './menu';


const $ = require('jquery');
require('bootstrap');

const routes = require('../../../public/fos_js_routes.json');
import Routing from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

Routing.setRoutingData(routes);

$(document).ready(function () {
    const $newsletterUrl = Routing.generate('app_front_newsletter_email_submit');

    $('.btn-newsletter').on('click', function() {
        let formData = new FormData();
        formData.append('email', $('input.form-control-newsletter').val());

        $.ajax({
            method: "POST",
            url: $newsletterUrl,
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            cache: false,
        })
        .done(function( data ) {
            $('#newsletter-subscription-confirmation').modal('show');
        })
        .fail(function( jqXHR, textStatus ) {
            $('#newsletter-subscription-error').modal('show');
        });
    });
});
