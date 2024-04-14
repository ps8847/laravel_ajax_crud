<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
<script>
    $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        $(document).on('click' , '.add_Product' , function(e){
			e.preventDefault();
			var name = $('#name').val();
			let price = $('#price').val();
			
			$.ajax({
                method:'POST',
                url:'{{ route("add.product") }}',
                data:{name:name , price:price},
                success:function(res){
                    if(res.status=='success'){
                        $('#closebuttonAdd').click();
                        $('#addProductForm')[0].reset();
                        $('.table').load(location.href+' .table');
                        Command: toastr["success"]("Product Added!", "Success")

                        toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                        }
                    }
                },
                error:function(err){
                    $('.errMsgContainer').html('');
                    console.log(err);
                let error = err.responseJSON;
                ////console.log(error);
                    $.each(error.errors, function(index , value){
                        $('.errMsgContainer').append('<span class="text-danger">'+value+'</span>'+'<br>');
                    });
                }
            });
		});

        //show product value in update form
        $(document).on('click' , '.update_product_form' , function(){
            let id = $(this).data('id');
            let name = $(this).data('name');
            let price = $(this).data('price');

            $('#up_id').val(id);
            $('#up_name').val(name);
            $('#up_price').val(price);
        });

        //update data
        $(document).on('click' , '.update_Product' , function(e){
			e.preventDefault();
			var up_name = $('#up_name').val();
			let up_price = $('#up_price').val();
			let up_id = $('#up_id').val();
			
			$.ajax({
                method:'POST',
                url:'{{ route("update.product") }}',
                data:{up_id:up_id , up_name:up_name , up_price:up_price},
                success:function(res){
                    if(res.status=='success'){
                        $('#closebuttonUpdate').click();
                        $('#updateProductForm')[0].reset();
                        $('.table').load(location.href+' .table');
                        Command: toastr["success"]("Product Updated!", "Success")

                        toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                        }
                    }
                },
                error:function(err){
            
                    $('.errMsgContainer').html('');
                    console.log(err);
                    let error = err.responseJSON;
                ////console.log(error);
                    $.each(error.errors, function(index , value){
                        $('.errMsgContainer').append('<span class="text-danger">'+value+'</span>'+'<br>');
                    });
                }
            });
		});

        //delete product data
        $(document).on('click' , '.delete_Product' , function(e){
			e.preventDefault();
	
			let product_id = $(this).data('id');
            if(confirm('Are You sure to delete product ??')){
                $.ajax({
                method:'POST',
                url:'{{ route("delete.product") }}',
                data:{product_id:product_id},
                success:function(res){
                    if(res.status=='success'){
                        $('.table').load(location.href+' .table');
                        Command: toastr["success"]("Product Deleted!", "Success")

                        toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                        }
                    }
                }
            });
            }
			
		});

        //pagination
        $(document).on('click' , '.pagination a' , function(e){
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            product(page);
        })
        function product(page){
            $.ajax({
                url:'/pagination/paginate-data?page='+page,
                success:function(res){
                    $('.table-data').html(res);
                }
            })
        }

        //search product
        $(document).on('keyup' , function(e)
        {
            e.preventDefault();
            let search_string = $('#search').val();
            $.ajax
            ({
                url:"{{ route('search.product') }}",
                method: 'GET',
                data: {search_string:search_string},
                success:function(res)
                {
                    $('.table-data').html(res);
                    if(res.status=='nothing_found')
                    {
                        $('.table-data').html('<span class="text-danger">'+'Nothing Found !'+'</span>');
                    }
                }
            });
        });
    });
    
</script>