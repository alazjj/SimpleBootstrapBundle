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

        // Form edition row management
        var rowEditionManagement = function($form, $row, printInput) {
            var $field = $($row.data('form-input'));
            var $fieldDataEdition = $row.find('[data-form-edit="row"]');

            if (!printInput) {
                $fieldDataEdition.on("click", function() {
                    $row.html($field);
                });
            } else {
                $row.html($field);
            }

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