    @include('admin/header')
    <main class="container my-5">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Product List</h4>
                <a href="{{ route('add_products') }}" class="btn btn-sm btn-primary">Add New</a>
            </div>

            <div class="card-body">
                <table id="productTable" class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Close/Active</th>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Base Price</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input toggle-status" type="checkbox" role="switch"
                                            id="productStatusSwitch_{{ $item->id }}"
                                            data-id="{{ $item->id }}"
                                            {{ $item->status == 'active' ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td>{{ $item->product_name }}</td>
                            <td>
                                @if($item->image)
                                    <img src="{{ asset('uploads/products/' . $item->image) }}" width="100">
                                @endif
                            </td>
                            <td>₹{{ number_format($item->base_price, 2) }}</td>
                            <td>{{ date('d-M-Y h:i A', strtotime($item->start_date)) }}</td>
                            <td>{{ date('d-M-Y h:i A', strtotime($item->end_date)) }}</td>
                            <td>
                                <span class="badge status-badge {{ $item->status == 'active' ? 'bg-success' : 'bg-secondary' }}">{{ $item->status }}</span></td>
                            <td>
                                <a href="{{ route('edit_products', ['id' => $item->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                                <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $item->id }}">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    
    <script>
    $(document).ready(function () {
        $('#productTable').DataTable();
    });

    $(document).on("click", ".deleteBtn", function(){
        var $this = $(this);
        var prodID = $this.data('id');
        var row = $this.closest('tr');
        
        if(prodID){
            Swal.fire({
                title: "Are you sure?",
                text: "This product will be deleted permanently!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {

                    var originalHtml = $this.html();

                    $.ajax({
                        method: "DELETE",
                        dataType: "json",
                        url: "{{ route('delete_product') }}",
                        data: {
                            id: prodID,
                            _token: "{{ csrf_token() }}",
                            _method: "DELETE"
                        },
                        beforeSend: function(){
                            $this.text("deleting..!");
                            $this.attr("disabled", true);
                        },
                        success: function(data){
                            Swal.fire("Deleted!", "Product has been deleted.", "success");
                            row.fadeOut(300, function(){
                                $(this).remove();
                            });
                        },
                        error: function(xhr){
                            Swal.fire("Error!", "Something went wrong.", "error");
                            $this.html(originalHtml);
                            $this.attr("disabled", false);
                        }
                    });
                }
            });
        }
    });

    $(document).on("change", ".toggle-status", function () {
        let $this = $(this);
        let prodID = $this.data("id");
        let status = $this.is(":checked") ? "active" : "closed";

        $.ajax({
            url: "{{ route('update_product_status') }}",
            method: "PUT",
            data: {
                id: prodID,
                status: status,
                _token: "{{ csrf_token() }}"
            },
            beforeSend: function () {
                $this.prop("disabled", true);
            },
            success: function (response) {
                let $row = $this.closest("tr");
                let $badge = $row.find(".status-badge");

                $badge
                    .text(status)
                    .removeClass("bg-success bg-secondary")
                    .addClass(status === "active" ? "bg-success" : "bg-secondary");
            },
            error: function (xhr) {
                alert("Failed to update status");
                $this.prop("checked", status !== "active");
            },
            complete: function () {
                $this.prop("disabled", false);
            }
        });
    });
    </script>

    @include('admin/footer')