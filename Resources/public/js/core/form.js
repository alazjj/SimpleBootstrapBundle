/**
 * This file is part of the SimpleBootstrap Bundle.
 *
 * @author aRn0D (Arnaud Langlade) <arn0d.dev@gmail.com>
 * @author Julien Janvier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$(function () {
    /**
     * Manage form editable field by field
     */
    $.fn.simpleForm = function(options) {

        /**
         * Default settings
         */
        var settings = $.extend({}, options);

        /**
         * Alert display management
         *
         * @param $alert
         * @param message
         * @param type
         * @param diplay
         */
        var alertMessageManagement = function ($form, message, type, diplay) {
            var $alert = $form.find('[data-form="message"]');
            if ($alert.length == 1) {
                $alert.addClass('alert-' + type);

                if (message != '') {
                    $alert.html(message);
                }

                if (diplay) {
                    $alert.removeClass('hide');
                    $alert.addClass('in');
                } else {
                    $alert.removeClass('in');
                    $alert.addClass('hide');
                }
            }
        }


        /**
         * Display error messages
         *
         * @param $form
         * @param message
         */
        var displayErrorMessMessage = function($form, message) {
            alertMessageManagement($form, message, 'error', true);
        }


        /**
         * Display success messages
         *
         * @param $form
         * @param message
         */
        var displaySuccessMessage = function($form, message) {
            alertMessageManagement($form, message, 'success', true);
        }


        /**
         * Get submition way
         *
         * @param $form
         * @returns {string} : ajax or change
         */
        var getSubmissionWay = function($form) {
            return $form.data('form-submission');
        }


        /**
         * Submit the field value to the server, only the ajax
         * submition on the change event is available
         *
         * @param $form
         * @param $field
         */
        var submitFieldData = function($form, $field) {
            var submissionWay = getSubmissionWay($form);
            if (submissionWay == 'change') {
                $field.on("change", function() {
                    $field.attr('disabled', true);

                    // Submit form
                    $form.ajaxSubmit({
                        statusCode: {
                            202: function(responseText){
                                if(responseText == '') {
                                    responseText = 'Oops! An Error Occurred, you can update this fields';
                                }

                                displayErrorMessMessage(
                                    $form,
                                    responseText
                                );

                                $field.attr('disabled', false);
                            }
                        },
                        // The request has failed
                        error: function(jqXHR) {
                            $field.attr('disabled', false);
                            displayErrorMessMessage(
                                $form,
                                'Oops! An Error Occurred, you can update this fields'
                            );
                            $field.attr('disabled', false);
                        }
                    });
                });
            }
        }


        var submitFormData = function($form) {
            var submissionWay = getSubmissionWay($form);
            if (submissionWay == 'ajax') {
                $form.on("submit", function(even) {
                    even.preventDefault();
                    var errorCallback = function(jqXHR) {
                        displayErrorMessMessage(
                            $form,
                            'Impossible to display the popup, Error code ' + jqXHR.status + ' Error message : ' + jqXHR.statusText
                        );
                    }

                    var submissionOptions = {
                        statusCode: {
                            // The form was not valid, we print it with errors
                            202: function(responseText){
                                $form.html(responseText);
                            }
                        },
                        // The form is valid, we print the response given by the server.
                        // The server have to return the success message (not the form).
                        success: function(responseText) {
                            displaySuccessMessage($form, responseText);
                        },
                        // The request has failed
                        error: errorCallback
                    }

                    if (settings) {
                        settings.error = errorCallback;
                        submissionOptions = settings;
                    }

                    // Submit form
                    $form.ajaxSubmit(submissionOptions);
                });
            }
        }


        /**
         * Manage specific instance of plugin js.
         *
         * @param $row
         * @param $field
         */
        var fieldPluginInstanceManagement = function($row, $field) {
            switch ($field.data('form-type')) {
                case 'colorpicker':
                    $row.colorpicker();
                    break;
                case 'datepicker':
                    $row.datepicker();
                    break;
            }
        }


        /**
         * Form edition row management
         *
         * @param $form
         * @param $row
         * @param printInput
         */
        var rowEditionManagement = function($form, $row, printInput) {
            /*
             * Tansform the inpu markup in jquery object beacause we need to
             * find the form element (input/select) to active the datas submition
             */
            var $tmpDiv = $('<div></div>').hide();
            $tmpDiv.html($row.data('form-input'));

            var $field = $tmpDiv.find('[data-form-type]');
            var $fieldDataEdition = $row.find('[data-form-edit="row"]');

            if (!printInput) {
                $fieldDataEdition.on("click", function() {
                    $row.html($tmpDiv.children());
                    fieldPluginInstanceManagement($row, $field);
                });
            } else {
                $row.html($tmpDiv.children());
                fieldPluginInstanceManagement($row, $field);
            }

            // Manage data submition
            submitFieldData($form, $field);
        }


        this.each(function () {
            var $form = $(this);
            var $formRows = $form.find('[data-form="row"]');
            var $formDataEdition = $form.find('[data-form-edit="form"]');
            var submissionWay = getSubmissionWay($form);

            // Enable field edition : one by one
            $formRows.each(function(index) {
                rowEditionManagement($form, $(this), false);
            });

            // Enable field edition : all fields
            $formDataEdition.on('click', function(e){
                e.preventDefault();

                $formRows.each(function(index) {
                    rowEditionManagement($form, $(this), true);
                });
            });

            submitFormData($form);
        });

        return $(this);
    };
});