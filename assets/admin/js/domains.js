/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
import './app';
import '../styles/domains.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

const $ = require('jquery');
console.log('Hello Webpack Encore! Edit me in assets/admin/js/domains.js');

$(document).ready(function () {
    setSampleColor($('select#domain_color'));

    $('select#domain_color').on('change', function() {
        setSampleColor($(this));
    });

    setSampleIcon($('input#domain_icon'), $('.domain-icon-sample'));

    $('input#domain_icon').on('input', function() {
        setSampleIcon($(this), $('.domain-icon-sample'));
    });
});

function setSampleColor(selector) {
    const selectedColor = selector.val();

    const sampleColor = $('.domain-color-sample');
    const actualColor = sampleColor.attr('data-selected');

    if (actualColor) {
        sampleColor.removeClass(actualColor);
    }
    sampleColor.addClass(selectedColor);
    sampleColor.attr({'data-selected': selectedColor});
}

function setSampleIcon(selector, sampleIcon) {
    const selectedIcon = selector.val();

    const actualIcon = sampleIcon.attr('data-selected');

    if (actualIcon) {
        sampleIcon.find('.icon').removeClass(`bx-${actualIcon}`);
        sampleIcon.find('.icon').removeClass(`bxs-${actualIcon}`);
        sampleIcon.find('.icon').removeClass(`bxl-${actualIcon}`);
    }

    sampleIcon.find('.icon').addClass(`bxl-${selectedIcon}`);
    sampleIcon.find('.icon').addClass(`bxs-${selectedIcon}`);
    sampleIcon.find('.icon').addClass(`bx-${selectedIcon}`);

    sampleIcon.attr({'data-selected': selectedIcon});
}