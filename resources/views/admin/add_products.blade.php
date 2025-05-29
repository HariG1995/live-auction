    @include('admin/header')
    <main class="container my-5">
        <div class="card shadow">
            <div class="card-header">
                <h4 class="mb-0">Add New Product</h4>
            </div>

            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data" id="form-submit">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="product_name" class="form-label">Product Name</label>
                            <input type="text" name="product_name" id="product_name" placeholder="Enter product name" oninput="fieldcheck('#product_name', '#err_product_name')" class="form-control" required>
                            <span class="error_field" id="err_product_name"></span>
                        </div>

                        <div class="col-md-6">
                            <label for="product_image" class="form-label">Product Image <small>(max 5MB)</small></label>
                            <input type="file" name="product_image" id="product_image" oninput="fieldcheck('#product_image', '#err_product_image')" class="form-control" accept="image/*" required>
                            <span class="error_field" id="err_product_image"></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" placeholder="Enter product description" oninput="fieldcheck('#description', '#err_description')" class="form-control" rows="6" required></textarea>
                            <span class="error_field" id="err_description"></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="base_price" class="form-label">Base Price</label>
                            <input type="number" name="base_price" id="base_price" placeholder="Enter base price" oninput="fieldcheck('#base_price', '#err_base_price')" class="form-control" step="0.01" required>
                            <span class="error_field" id="err_base_price"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Starting Date & Time</label>
                            <input type="datetime-local" name="start_date" id="start_date" class="form-control" oninput="fieldcheck('#start_date', '#err_start_date')" required>
                            <span class="error_field" id="err_start_date"></span>
                        </div>

                        <div class="col-md-4">
                            <label for="end_date" class="form-label">Ending Date & Time</label>
                            <input type="datetime-local" name="end_date" id="end_date" class="form-control" oninput="fieldcheck('#end_date', '#err_end_date')" required>
                            <span class="error_field" id="err_end_date"></span>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-primary" id="submitBtn">Add Product</button>
                        <a href="{{ route('view_products') }}" type="submit" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
    $(document).on("click", "#submitBtn", function(e){
        e.preventDefault();

        var errProduct = false;
        var errImage = false;
        var errDesc = false;
        var errBprice = false;
        var errSdate = false;
        var errEdate = false;

        var prodName = $("#product_name").val();
        var prodImage = $("#product_image").val();
        var prodDesc = $("#description").val();
        var basePrice = $("#base_price").val();
        var sDate = $("#start_date").val();
        var eDate = $("#end_date").val();

        if(!prodName){
            errProduct = true;
            show_error_alert("#err_product_name", "#product_name", "product name is required");
        }else{
            errProduct = false;
            hide_error_alert("#err_product_name", "#product_name", "");
        }

        if(!prodImage){
            errImage = true;
            show_error_alert("#err_product_image", "#product_image", "product image is required");
        }else{
            errImage = false;
            hide_error_alert("#err_product_image", "#product_image", "");
        }

        if(!prodDesc){
            errDesc = true;
            show_error_alert("#err_description", "#description", "description is required");
        }else{
            errDesc = false;
            hide_error_alert("#err_description", "#description", "");
        }

        if(!basePrice){
            errBprice = true;
            show_error_alert("#err_base_price", "#base_price", "base price is required");
        }else{
            errBprice = false;
            hide_error_alert("#err_base_price", "#base_price", "");
        }

        if(!sDate){
            errSdate = true;
            show_error_alert("#err_start_date", "#start_date", "start date is required");
        }else{
            errSdate = false;
            hide_error_alert("#err_start_date", "#start_date", "");
        }

        if(!eDate){
            errEdate = true;
            show_error_alert("#err_end_date", "#end_date", "end date is required");
        }else{
            errEdate = false;
            hide_error_alert("#err_end_date", "#end_date", "");
        }

        if(errProduct == false && errImage == false && errDesc == false && errBprice == false && errSdate == false && errEdate == false){
            let form = document.getElementById('form-submit');
            let formData = new FormData(form);
            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                method : "post",
                dataType : "json",
                url : "{{ route('create_products') }}",
                data : formData,
                processData: false,
                contentType: false,
                beforeSend:function(){
                    $("#submitBtn").text("Loading..!");
                    $("#submitBtn").attr("disabled", true);
                },
                success:function(data){
                    // window.location.reload();
                    window.location.href="{{ route('view_products') }}";
                },
                error:function(xhr){
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;

                        if (errors.product_name) {
                            $("#err_product_name").text(errors.product_name[0]);
                        }

                        if (errors.product_image) {
                            $("#err_product_image").text(errors.product_image[0]);
                        }

                        if (errors.description) {
                            $("#err_description").text(errors.description[0]);
                        }

                        if (errors.base_price) {
                            $("#err_base_price").text(errors.base_price[0]);
                        }

                        if (errors.start_date) {
                            $("#err_start_date").text(errors.start_date[0]);
                        }

                        if (errors.end_date) {
                            $("#err_end_date").text(errors.end_date[0]);
                        }
                    } else {
                        alert("Something went wrong.");
                        console.log(xhr);
                    }

                    $("#submitBtn").text("Add Product");
                    $("#submitBtn").attr("disabled", false);
                }
            });
        }
    });

    function show_error_alert(errorID, fieldID, message){
        $(errorID).html(message);
        $(fieldID).css("border", "solid 1px red");
    }

    function hide_error_alert(errorID, fieldID, message){
        $(errorID).html("");
        $(fieldID).css("border", "");
    }

    function fieldcheck(fieldID, errorID){
        var value = $(fieldID).val();

        if(value){
            hide_error_alert(errorID, fieldID, "")
        }
    }
    </script>

    <script>
    $(document).ready(function () {
        $('#start_date').on('change', function () {
            const startDate = $(this).val();
            $('#end_date').attr('min', startDate);
        });
    });
    </script>

    @include('admin/footer')