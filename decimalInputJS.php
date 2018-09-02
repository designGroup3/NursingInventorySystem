<script src="js/bootstrapvalidator.min.js"></script>
<body>
<script>
    $(document).ready(function() {
        $('#contact_form').bootstrapValidator({
            // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                cost: {
                    validators: {
                        numeric:{
                            decimalSeparator : true,
                            thousandsSeparator :true,
                            message: 'Please add a valid cost'
                        },
                        notEmpty: {
                            message: 'Please add a valid cost'
                        },
                        step:{
                            step: 0.01,
                            message: 'Please add a valid cost'
                        },
                        greaterThan:{
                            inclusive: true,
                            value: -0.01,
                            message: 'Please add a valid cost'
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: 'Please supply your email address'
                        },
                        emailAddress: {
                            message: 'Please supply a valid email address'
                        }
                    }
                }
            }
        })
    });
</script>