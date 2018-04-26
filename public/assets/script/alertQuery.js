$(document).ready(function(){
    $(".alert-success").fadeTo(5000, 500).slideUp(500, function(){
        $(this).alert('close');
    });

    $(".alert-danger").fadeTo(30000, 500).slideUp(500, function(){
        $(this).alert('close');
    });
});
