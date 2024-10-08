class Model {
    constructor() {
        this.message = null;
    }

    getModel() {
        $.ajax({
            url: 'call_python/get_admin_verify_id_application.php',
            method: 'GET',
            success: (response) => {
                const container = $('#responseContainer');
                container.append(`<p class="response-message" id="responseMessage">Permanent ID Number For The New Applicant: ${response}</p>`);
                container.append(`<input class="response-message" id="responseMessage" type="hidden" name="id_application_id_number" value="<?php $application_id_number = ${response} ?>"/>`);
            },
            error: (xhr, status, error) => {
                console.error('Error Generating New ID Number:', error);
                $('#responseContainer').html('<p class="response-message">Error Generating New ID Number. Please Try Again Later.</p>');
            }
        });
    }
}

$(document).ready(function() {
    const model = new Model();
    model.getModel();
});