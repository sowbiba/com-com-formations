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
console.log('Hello Webpack Encore! Edit me in assets/admin/js/home.js');

$(document).ready(function () {
    setSampleIcon($('input#home_middleBlockBoxOneIcon'), $('.middle-block-box-one-icon-sample'));
    $('input#home_middleBlockBoxOneIcon').on('input', function() {
        setSampleIcon($(this), $('.middle-block-box-one-icon-sample'));
    });

    setSampleIcon($('input#home_middleBlockBoxTwoIcon'), $('.middle-block-box-two-icon-sample'));
    $('input#home_middleBlockBoxTwoIcon').on('input', function() {
        setSampleIcon($(this), $('.middle-block-box-two-icon-sample'));
    });

    setSampleIcon($('input#home_middleBlockBoxThreeIcon'), $('.middle-block-box-three-icon-sample'));
    $('input#home_middleBlockBoxThreeIcon').on('input', function() {
        setSampleIcon($(this), $('.middle-block-box-three-icon-sample'));
    });
});

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