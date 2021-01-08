/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */


// any CSS you import will output into a single css file (app.css in this case)
import '../styles/app.scss';
import tinymce from 'tinymce/tinymce';
import 'tinymce/themes/silver/theme';
import 'tinymce/plugins/paste';
import 'tinymce/plugins/link';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/image';
import 'tinymce/plugins/fullscreen';
import 'tinymce/plugins/media';
import 'eonasdan-bootstrap-datetimepicker';

const routes = require('../../../public/fos_js_routes.json');
import Routing from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

Routing.setRoutingData(routes);

const $ = require('jquery');
require('bootstrap');

$(document).ready(function () {
    tinymce.init({
        selector: 'textarea',
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | fullscreen",
        plugins: ['paste', 'link', 'lists', 'image', 'fullscreen', 'media'],
        images_upload_url: 'upload.php',
        images_upload_base_path: '/some/basepath',
        images_upload_handler: example_image_upload_handler,
    });

    $('.datepicker').datetimepicker({
        format: 'L',
        locale: 'fr'
    });

    $('.timepicker').datetimepicker({
        format: 'LT',
        locale: 'fr',
        useCurrent: false
    });

    $('[data-toggle="tooltip"]').tooltip({html:true});

    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
        $(this).toggleClass('active');
    });

    window.setTimeout(function() {
        $(".alert-dismissible").fadeOut(1000);
    }, 3000);

    $('.toggle-button').on('click', function() {
       const target = $(this).data('target');

       $(`#${target}`).toggle('slow');
    });

    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').on('click', function() {
            $.ajax(
                $(e.relatedTarget).data('href'),
                {
                    method: 'DELETE'
                }
            )
            .done(function( data ) {
                if ( console && console.log ) {
                    console.log(data);
                }
                window.location.reload();
            });
        });
        $(this).find('.btn-cancel').trigger('focus');
    });
});

function example_image_upload_handler (blobInfo, success, failure, progress) {
    const $url = Routing.generate('app_admin_images_upload');
    let xhr, formData;

    xhr = new XMLHttpRequest();
    xhr.withCredentials = false;
    xhr.open('POST', $url);

    xhr.upload.onprogress = function (e) {
        progress(e.loaded / e.total * 100);
    };

    xhr.onload = function() {
        let json;

        if (xhr.status === 403) {
            failure('HTTP Error: ' + xhr.status, { remove: true });
            return;
        }

        if (xhr.status < 200 || xhr.status >= 300) {
            failure('HTTP Error: ' + xhr.status);
            return;
        }

        json = JSON.parse(xhr.responseText);

        if (!json || typeof json.location != 'string') {
            failure('Invalid JSON: ' + xhr.responseText);
            return;
        }

        success(json.location);
    };

    xhr.onerror = function () {
        failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
    };

    formData = new FormData();
    formData.append('image', blobInfo.blob(), blobInfo.filename());

    xhr.send(formData);
}
