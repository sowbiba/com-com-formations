/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */


// any CSS you import will output into a single css file (app.css in this case)

const $ = require('jquery');
require('bootstrap');

$(document).ready(function () {
    $('.bck-nav-main--item').hover(function(event) {
        event.preventDefault();
        event.stopPropagation();

        const $link = $(this).find('a.bck-nav-main--link');
        if ($link && $link.attr('aria-controls')) {
            let $target = $link.attr('aria-controls');
            $(`#${$target}`).show();
        }
    }, function(event) {
        event.preventDefault();
        event.stopPropagation();

        const $link = $(this).find('a.bck-nav-main--link');
        if ($link && $link.attr('aria-controls')) {
            let $target = $link.attr('aria-controls');
            $(`#${$target}`).hide();
        }
    });


    // carousel slide on hover
    // $('#carousel-domains').find('a[data-slide]').hover(function(event) {
    //     event.preventDefault();
    //     event.stopPropagation();
    //
    //     $('#carousel-domains').carousel($(this).attr('data-slide'));
    // }, function(event) {
    //
    // });
});
