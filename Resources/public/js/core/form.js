$(function () {
    /**
     * Manage form editable field by field
     */
    $.fn.formEditField = function(options) {
        // Settings
        var settings = $.extend( {
            'editionType': 'field',
            'submitFieldOn': 'change'
        }, options);

        this.each(function () {
            var $this = $(this);
            // Form element
            var $form = $this.closest('form');
            // Input Markup
            var input = $this.data('form-input');
            // Input object
            var $input = $(input);
            // Edit Input
            var $inputAction = $this.find('[data-form-edit="row"]');

            // Update the input form markup
            switch (settings.editionType) {
                case 'field':
                    $inputAction.on("click", function() {
                        $this.html($input);
                    });
                    break;
                case 'form':
                    $this.html($input);
                    break;
                default:
                    alert('Oops! An Error Occurred, the submitFieldOn param is invalidated');
                    break;
            }

            // Submit the value to the server if it change.
            switch (settings.submitFieldOn) {
                case 'change':
                    $input.on("change", function() {
                        $input.attr('disabled', true);

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

                                $input.attr('disabled', false)
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
        });

        return $(this);
    };
});