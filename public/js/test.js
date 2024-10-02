
    $(document).ready(function(){
        var postURL = "<?php echo url('addmore'); ?>";
        var i=1;

        $('#add').click(function(){
            i++;
            $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td>' +
                '<input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td>' +
                '<td><input type="text" name="input_type[]" placeholder="Enter input Type" class="form-control name_list" /></td>' +
                '<td><input type="text" name="unit[]" placeholder="Enter unit" class="form-control name_list" /></td>' +
                '<td><input type="text" name="range[]" placeholder="Enter Range" class="form-control name_list" /></td>' +
                '<td><input type="text" name="short_code[]" placeholder="Enter Short Name" class="form-control name_list" /></td>' +
                '<td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        // $('#add_findings').click(function(){
           
        //     var iX = document.getElementById("txtIndex").value; 
        //         iX ++;
                     


        //         var $tableBody = $('#dynamic_field').find("tbody"),
        //           $trLast = $tableBody.find("tr:last"),
        //           $trNew = $trLast.clone();
              
        //         $trNew.find('select').val(function(index, value) {
        //           return $trLast.find('select').eq(index).val();
        //         });
        //         $trLast.after($trNew);
        //         $trNew.attr('id','row'+iX);
        //         $trNew.find('td:last').addClass('td'+iX);

        //         $trNew.find('#add_findings').remove();
        //         var btn = iX - 1;
        //         $trNew.find('#'+btn).remove();

        //         var line = $('<button type="button" name="remove" id="'+iX+'" class="btn btn-danger btn_remove">X</button>');

        //         line.appendTo($('.td'+iX)); 
                
        //         document.getElementById("txtIndex").value = iX;

        //       });


          

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#submit').click(function(){
            $.ajax({
                url:postURL,
                method:"POST",
                data:$('#add_name').serialize(),
                type:'json',
                success:function(data)
                {
                    if(data.error){
                        printErrorMsg(data.error);
                    }else{
                        i=1;
                        $('.dynamic-added').remove();
                        $('#add_name')[0].reset();
                        $(".print-success-msg").find("ul").html('');
                        $(".print-success-msg").css('display','block');
                        $(".print-error-msg").css('display','none');
                        $(".print-success-msg").find("ul").append('<li>Record Inserted Successfully.</li>');
                    }
                }
            });
        });

        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $(".print-success-msg").css('display','none');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }


    });
