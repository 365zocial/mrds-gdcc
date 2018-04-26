<script type="text/javascript" src="{{ url('assets/script/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/script/datatable_mod.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/script/parsley.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/script/bootstrap-toggle.min.js') }}"></script>
<!-- <script type="text/javascript" src="{{ url('assets/script/bootstrap-datepicker.js') }}"></script> -->
<script type="text/javascript" src="{{ url('assets/script/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/script/jquery.sticky.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/script/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript">

    $(document.body).on('click','.showPic',function(){
        var unique_record = $(this).data('uniqueid');
        getShowPic(unique_record);
    });

    function getShowPic(unique_record){
        $.ajax({
            method: "POST",
            url: "{{ url('recordPicture') }}",
            data: {
                _token: "{{ csrf_token() }}",
                unique_record: unique_record
            }
        }).done(function( data ) {
            $('.modal-body').html("");

            if(data.length == 0){
                $('.modal-body').append("<img class='img-responsive' style='margin-top:10px;' src='<?php echo url('/') ?>/assets/images/placeholder-image.png'>");
            }else{
                $.each(data, function(i, data){
                    $('.modal-body').append("<img class='img-responsive' style='margin-top:10px;' src='<?php echo url('/') ?>/uploads/images/"+data['path_pic']+"'>");
                });
            }

        });
    }
</script>
