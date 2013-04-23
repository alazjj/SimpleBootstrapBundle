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
        // Settings
        var settings = $.extend( {
            'submitFieldOn': 'change'
        }, options);

        // Submit the value to the server, for the moment there only is
        // one way to edit it the. We submit it on the onChange event
        var submitDataFrom = function($form, $field) {
            switch (settings.submitFieldOn) {
                case 'change':
                    $field.on("change", function() {
                        $field.attr('disabled', true);

                        // Send field data
                        $.ajax({
                            url: $form.attr('action'),
                            type: $form.attr('method'),
                            data: $form.serialize()
                        })
                            .done(function(data) {
                                if(data != undefined) {
                                    if(data.status == 'error') {
                                        if (data.message == undefined) {
                                            data.message = 'Oops! An Error Occurred, you can update this fields';
                                        }
                                        alert(data.message);
                                    }

                                    $field.attr('disabled', false)
                                } else {
                                    alert('Oops! An Error Occurred, you can update this fields');
                                }
                            })
                            .fail(function(data) {
                                alert('Oops! An Error Occurred, you can update this fields');
                            });
                    });
                    break;
                case 'disable':
                    break;
                default:
                    alert('Oops! An Error Occurred, the submitFieldOn param is invalidated');
                    break;
            }
        }

        // Manage specific instance of plugin js.
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

        // Form edition row management
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
            submitDataFrom($form, $field);
        }

        this.each(function () {
            var $form = $(this);
            var $formRows = $form.find('[data-form="row"]');
            var $formDataEdition = $form.find('[data-form-edit="form"]');

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
        });

        return $(this);
    };
});