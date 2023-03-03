<script>
    $('document').ready(function(){
        $('input[type="checkbox"]').click(function(){
            var main_menu = $(this).attr('main-menu');
            var sub_menu = $(this).attr('sub-menu');
            var route_name = $(this).attr('route');
            var type = $(this).attr('input-type');

            if (type == 'main_menu') {
               //MENU
               if($(this).is(':checked')){
                    if($('input[type="checkbox"][input-type="sub_menu"][main-menu="'+main_menu+'"]').is(':checked')){
                        $('input[type="checkbox"][input-type="sub_menu"][main-menu="'+main_menu+'"]').prop('checked',false);
                    }else{
                        $('input[type="checkbox"][input-type="sub_menu"][main-menu="'+main_menu+'"]').prop('checked',true);
                    }

                    if($('input[type="checkbox"][input-type="action"][main-menu="'+main_menu+'"]').is(':checked')){
                        $('input[type="checkbox"][input-type="action"][main-menu="'+main_menu+'"]').prop('checked',false);
                    }else{
                        $('input[type="checkbox"][input-type="action"][main-menu="'+main_menu+'"]').prop('checked',true);
                    }
               }else{
                    $('input[type="checkbox"][input-type="sub_menu"][main-menu="'+main_menu+'"]').prop('checked',false);
                    $('input[type="checkbox"][input-type="action"][main-menu="'+main_menu+'"]').prop('checked',false);
               }
            }else if(type == 'sub_menu'){
                // SUB MENU
                if($(this).is(':checked') && $('input[type="checkbox"][input-type="sub_menu"]').is(':checked')){
                    $('input[type="checkbox"][input-type="main_menu"][main-menu="'+main_menu+'"]').prop('checked',true);
                    $('input[type="checkbox"][input-type="action"][main-menu="'+main_menu+'"][sub-menu="'+sub_menu+'"]').prop('checked',true);
                }else{

                    if(!$('input[type="checkbox"][input-type="sub_menu"]').is(':checked')){
                        $('input[type="checkbox"][input-type="main_menu"][main-menu="'+main_menu+'"]').prop('checked',false);
                        $('input[type="checkbox"][input-type="action"][main-menu="'+main_menu+'"][sub-menu="'+sub_menu+'"]').prop('checked',false);

                    }else if(!$(this).is(':checked')){
                        $('input[type="checkbox"][input-type="action"][main-menu="'+main_menu+'"][sub-menu="'+sub_menu+'"]').prop('checked',false);
                    }else{
                        $('input[type="checkbox"][input-type="main_menu"][main-menu="'+main_menu+'"]').prop('checked',false);
                    }
                }
            }else{
                //Route Action
                if(!$('input[type="checkbox"][input-type="action"]').is(':checked')){
                    $('input[type="checkbox"][input-type="main_menu"][main-menu="'+main_menu+'"]').prop('checked',false);
                    $('input[type="checkbox"][input-type="sub_menu"][main-menu="'+main_menu+'"][sub-menu="'+sub_menu+'"]').prop('checked',false);
                }else{
                    $('input[type="checkbox"][input-type="main_menu"][main-menu="'+main_menu+'"]').prop('checked',true);
                    $('input[type="checkbox"][input-type="sub_menu"][main-menu="'+main_menu+'"][sub-menu="'+sub_menu+'"]').prop('checked',true);
                }
            }
        });
    });
</script>