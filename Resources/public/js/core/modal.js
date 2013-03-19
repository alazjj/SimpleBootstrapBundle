$(function () {
    /**
     * Symfony environment (do not forget to put data-env attribute on the body element)
     */
    var env = $('body').data('env');


    /**
     * Get the modal container
     * @param $element
     * @param defaultModal
     * @return mixed false|modalContainer
     */
    function getModalContainer($element, defaultModal) {
        var $modal, $defaultModal;

        if ($element.is('a')) {
            $modal = $($element.attr('href'));
        } else {
            $modal = $($element.data('target'));
        }

        if ($modal.length == 0) {
            $defaultModal = $(defaultModal);
            if ($defaultModal.length == 0) {
                alert("Oops! An Error Occurred, the popup container was not found...");
                return false;
            }
            $modal = $defaultModal;
        }

        return $modal;
    }


    /**
     * Open the modal and put the body var into modal body
     * (element with .modal-body css class)
     */
    function openModalWithBody ($modal, body) {
        var $modalContent =  $modal.find('.modal-body');
        if ($modalContent.length == 1) {
            $modalContent.html(body);
        } else {
            $modal.html(body)
        }
        $modal.modal('show');
    }


    /**
     * Open a popup and ask to the server the content.
     *
     * Put two others attributes on the clickable element:
     * - data-url : url which return content of the popup up
     * - href or data-target : modal element id, you must used
     *   it as an anchor or a button (bootstrap mechanism )
     *
     * If you want enable ajax submit, put a attribute
     * data-submit="ajax" on your form returned in the response.
     *
     * @return {*|jQuery|HTMLElement}
     */
    $.fn.simpleModal = function(){
        // Default modal container
        var defaultContainer = '#basicModalContainer';

        /**
         * Open the "error modal". It is the current modal with
         * error retuened (by the server) as body
         */
        function openModalWithError ($modal, jqXHR) {
            if(env != 'dev') {
                openModalWithBody($modal, jqXHR.responseText);
            } else {
                // TODO : get the content of the symfony response.
                alert('Impossible to display the popup, Error code ' + jqXHR.status + ' Error message : ' + jqXHR.statusText)
            }
        }

        this.each(function () {
            // Modal element
            var $modal;
            // Button element
            var $this = $(this);
            // Url which return content of the popup up
            var url = $this.data('url');

            if (($modal = getModalContainer($this, defaultContainer)) == false) {
                return false;
            }

            $this.on("click", function() {
                // Get the content of the popup
                $.get(url, function(response) {
                    if(response == "" || response == undefined) {
                        response = "Oops! An Error Occurred, The response from the server is empty...";
                        openModalWithBody($modal, response);
                        return false;
                    } else {
                        // Display the modal with its content
                        $modal.html(response);
                        $modal.modal('show');

                        // Form element in the response
                        var $form = $('form[data-submit="ajax"]', $modal);

                        if ($form.length == 1) {
                            // Form Input submit
                            var $submitButton = $('input[type=submit]', $modal);

                            // Enable form fielf edition
                            $('[data-form="row"]').formEditField();

                            $form.on("submit", function(even) {
                                even.preventDefault();

                                // Disable the submit button
                                $submitButton.attr('disabled', true);

                                // Ajax Submition
                                $form.ajaxSubmit({
                                    statusCode: {
                                        // You have to use 204 (http status code) if you want send
                                        // a request and close the modal.
                                        204: function(){
                                            $modal.modal('hide');
                                        },
                                        // If you want to reload the page use 205
                                        205: function(){
                                            location.reload();
                                        }
                                    },
                                    // The request is successful (code), you display the modal.
                                    success: function(responseText, textStatus, jqXHR) {
                                        if(jqXHR.status == 200) {
                                            $modal.html(responseText);
                                        }
                                    },
                                    // The request failed
                                    error: function(jqXHR) {
                                        openModalWithError ($modal, jqXHR);
                                    }
                                });
                            });
                        }
                    }
                }).fail(function(jqXHR) {
                    openModalWithError ($modal, jqXHR);
                });
            });

        });

        return $(this);
    };

    /**
     * Open a confirm modal and redirect the user on the specified url
     * if he validates it.
     *
     * Put three others attributes on the clickable element:
     * - data-url : url where is redirected the user if he validates the modal
     * - href or data-target : modal element id, you must used
     *   it as an anchor or a button (bootstrap mechanism )
     * - data-message (optional) : Displayed message on the modal
     *
     * You have three ways to redirect the user after validation,
     * - You can use a link with data-action="confirm" attribute
     *   and specified the url with the data-url attribute. The plugin
     *   will update the href attribute
     * - You can do do the thing with a form element. The plugin
     *   will update the action attribute.
     * - You can directly put a link or a form in the template modal
     *   and do not use the data-url attribute.
     *
     * @return {*|jQuery|HTMLElement}
     */
    $.fn.confirmModal = function() {
        // Default modal container
        var defaultContainer = '#confirmModalContainer';

        this.each(function () {
            // Modal element
            var $modal;
            // Button element
            var $this = $(this);
            // Confirm popup message (question)
            var message = $this.data('message');
            // Url used if you confirm the action
            var url = $this.data('url');

            if (($modal = getModalContainer($this, defaultContainer)) == false) {
                return false;
            }

            $this.on("click", function() {
                // Form Input submit
                if (url != "" && url != undefined) {
                    var $confirmActionElment = $('[data-action="confirm"]');
                    if ($confirmActionElment.length != 1) {
                        alert('Oops! An Error Occurred, There is not only one primary button...');
                        return false;
                    }

                    if ($confirmActionElment.is('a')) {
                        $confirmActionElment.attr('href', url);
                    } else if($confirmActionElment.is('form')) {
                        $confirmActionElment.attr('action', url);
                    } else {
                        alert('Oops! An Error Occurred, The primary button was not found...');
                        return false
                    }
                }

                // Open the confirm modal
                openModalWithBody($modal, message);
            });
        });

        return $(this);
    }

    /**
     * Open an alert modal
     *
     * Put three others attributes on the clickable element:
     * - href or data-target : modal element id, you must used
     *   it as an anchor or a button (bootstrap mechanism )
     * - data-message : Displayed message on the modal
     *
     * @return {*|jQuery|HTMLElement}
     */
    $.fn.alertModal = function() {
        // Default modal container
        var defaultContainer = '#alertModalContainer';

        this.each(function () {
            // Modal element
            var $modal;
            // Button element
            var $this = $(this);
            // Confirm popup message (question)
            var message = $this.data('message');

            if (($modal = getModalContainer($this, defaultContainer)) == false) {
                return false;
            }

            $this.on("click", function() {
                // Open the confirm modal
                openModalWithBody($modal, message);
            });
        });

        return $(this);
    }
});