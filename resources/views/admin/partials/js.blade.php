<script>

    $(document).ready(function() {

        $('.selectpicker').selectpicker();

        window.setTimeout(function() {
            $("div.alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove();
            });
        }, {{SWTET_ALERT_MODAL_TIMER}});


        // PAGE LOADER
        $(window).on('load',function() {
            $('.page-loader').fadeOut('slow');
        });

        // AJAX LOADER
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
            cache:false,
            beforeSend: function() {
                $('#ajax-loader').addClass('ajax-loader');
            },
            complete:function(){
                $('#ajax-loader').removeClass('ajax-loader');
            },
        });

        // SAVE MODAL
        $('#modal-store').on('show.bs.modal', function (event) {

            var save_btn = $(this).closest('div').find('#modal-store-save-btn');
            var form = $(this).closest('div').find('form');

            // SAVE BUTTON
            var save_btn_text = save_btn.text();
            save_btn.prop('disabled', false).after().find('i').remove().html();
            form.closest('div').find('span.error-text').addClass('d-none');

            $(save_btn).click(function(event){
                event.preventDefault();
                $(this).prop("disabled",true).html(save_btn_text+' <i class="fa fa-spinner fa-spin"></i>');

                var formData = form.serialize();

                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    dataType: 'json',
                    data: formData,
                    success:function(resp){
                        {{--if(resp.{{STATUS_CODE_KEY}} == {{config('configuration.software_exception_code.success')}}){--}}
                        {{--    location.reload();--}}
                        {{--}else{--}}
                        {{--    location.reload();--}}
                        {{--}--}}
                        location.reload();
                    },
                    error:function(resp){

                        var errors = resp.responseJSON.errors;

                        $.each(errors, function (key, value) {
                            form.find('#'+key).siblings('.error-text').text(value[0]).removeClass('d-none');
                        });

                        save_btn.prop('disabled', false).after().find('i').remove().html();
                    },
                });

            });
        });

        // UPDATE MODAL
        $("#modal-update").on("show.bs.modal", function(event) {

            var modal_name = "#modal-update";
            // UPDATE FROM INITIALIZE
            var form = $(this).closest('div').find('form');
            form.attr('action', $(event.relatedTarget).data('form-href'));
            var form_method = $(event.relatedTarget).data('form-method');

            // UPDATE BUTTON
            var update_btn = $(this).closest('div').find('#modal-edit-update-btn');
            var update_btn_text = update_btn.text();
            update_btn.prop('disabled', false).after().find('i').remove().html();
            form.closest('div').find('span.error-text').addClass('d-none');

            // GET DATA TARAGET VALUES ATTRS
            var data_attrs = $(event.relatedTarget).map(function(){
                return $(this).data();
            }).get();

            // SET IT AS OBJECT
            var data_object = Object.entries(data_attrs[0]).map(function(item){
                return {
                    key: item[0],
                    value: item[1]
                };
            });

            // SET FROM DATA
            $.each(data_object, function(key, data){

                var type = $(modal_name+' #'+data.key).attr('tag_name');

                if(type == 'select-picker'){

                    $(modal_name+' #'+data.key).val(data.value);
                    $(modal_name+' #'+data.key).selectpicker('refresh')
                }else if(type == 'textarea_summernote'){
                    $(modal_name+' #'+data.key).summernote('code', data.value);
                }else{
                    form.find('#'+data.key).val(data.value);
                }


            });

            $(update_btn).click(function(event){
                event.preventDefault();
                $(this).prop("disabled",true).html(update_btn_text+' <i class="fa fa-spinner fa-spin"></i>');

                var formData = form.serialize();

                $.ajax({
                    url: form.attr('action'),
                    method: form_method,
                    dataType: 'json',
                    data: formData,
                    success:function(resp){
                        if(resp.{{STATUS_CODE_KEY}} == {{config('configuration.software_exception_code.success')}}){
                            location.reload();
                        }
                    },
                    error:function(resp){

                        var errors = resp.responseJSON.errors;
                        // console.log(errors);
                        $.each(errors, function (key, value) {
                            form.find('#'+key).siblings('.error-text').text(value[0]).removeClass('d-none');
                        });

                        update_btn.prop('disabled', false).after().find('i').remove().html();
                    },
                });
            });

        });

        // DELETE MODAL
        $('.item-delete-btn').click(function(event){
            event.preventDefault();
            var thisBtn = $(this);
            swal({
                title: "{{__('Are you sure?')}}",
                text: "{{__('You will not be able to recover this imaginary file!')}}",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-danger',
                confirmButtonText: "{{ __('Yes, delete it!')}}",
                cancelButtonText: "{{ __('No, cancel plz!') }}",
                closeOnConfirm: false,
                closeOnCancel: false,
                timer: {{ SWTET_ALERT_MODAL_TIMER }},
            },
            function (isConfirm) {
                if (isConfirm) {

                    $.ajax({
                        url: thisBtn.attr('href'),
                        type: "DELETE",
                        data: {
                            '_token': "{{ csrf_token() }}"
                        },
                        success: function (resp) {

                            if(resp.{{STATUS_CODE_KEY}} == {{config('configuration.software_exception_code.success')}}){
                                swal({
                                    title: "{{ __('Deleted!') }}",
                                    text: "{{ __('Data has been Deleted.') }}",
                                    type: "success"
                                });


                                location.reload(true);

                                //
                                // btnThis.closest("tr").remove();
                                // var totalRecord = parseInt($('.dataTables_info strong').text().split(":").pop())-1 ;
                                // $('.dataTables_info strong').text('Total Records: '+totalRecord);

                            }else if(resp.{{STATUS_CODE_KEY}} == {{config('configuration.software_exception_code.warning')}}){

                                swal({
                                    title: "{{ __('Warning!') }}",
                                    text: "{{ __('This data is already exits on another table') }}",
                                    type: "error",
                                });

                            }else{
                                swal({
                                    title: "{{ __('Server Error!') }}",
                                    text: "{{ __('Please Check The Log') }}",
                                    type: "error"
                                });
                            }
                        }
                    });
                } else {
                    swal("Cancelled", "Your data is safe :)", "error");
                }
            });

        });

        // FORM SUBMIT BTN
        $('.form-submit-btn').click(function(event){

            event.preventDefault();

            var text = $(this).text();
            $(this).prop("disabled",true).html(text+' <i class="fa fa-spinner fa-spin"></i>');
            $(this).closest('form').submit();
        });
    });
</script>
