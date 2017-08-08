/**
 * Created by Pierre BELIN on 10/04/2017.
 */

$("#resultats-mail-form").submit(function () {
    $.ajax({
        type: "POST",
        //url: "{{ path('PierreSiteBundle_newsletter') }}",
        data: {
            mail: $("#resultats-mail").val(),
            user: $("#resultats-firstname").val(),
        },
        cache: false,
        // success: function (data) {
        //     console.log(data);
        //     if(data == 'success'){
        //         $('#subscribe-success-modal').modal('show');
        //     } else if (data == 'warning'){
        //         $('#subscribe-warning-modal').modal('show');
        //     } else {
        //         $('#subscribe-error-modal').modal('show');
        //     }
        //     $("#resultats-mail").val("");
        //     $("#resultats-firstname").val("");
        // }
    });
    return false;
});
