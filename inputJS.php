<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/angular-strap/v2.3.8/angular-strap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js"></script>
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
                MACAddress: {
                    validators: {
                        mac: {
                            message: 'Please supply a valid MAC address'
                        }
                    }
                },IPAddress: {
                    validators: {
                        ip: {
                            message: 'Please supply a valid IP address'
                        }
                    }
                }
            }
        })
    });
</script>