$(function () {
    /*
     * Manage edition field one by one.
     */
    $('[data-form="row"]').formEditField();


    /*
     * Put a data-form-edit="form" on element to enable edition on all form fields
     */
    $('[data-form-edit="form"]').on("click", function() {
        $('[data-form="row"]').formEditField({
            allFields: true
        });
    });

    /**
     * Modal
     */
    $('[data-modal="simple"]').simpleModal();
    $('[data-modal="confirm"]').confirmModal();
    $('[data-modal="alert"]').alertModal();
});