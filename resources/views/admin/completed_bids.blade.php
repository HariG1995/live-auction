    @include('admin/header')
    <main class="container my-5">
        <div class="card shadow">
            <div class="card-header">
                <h4 class="mb-0">Completed Bid List</h4>
            </div>

            <div class="card-body">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Base Price</th>
                            <th>Bid Price</th>
                            <th>Bidder</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($completedBids as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product_name }}</td>
                            <td>
                                @if($item->image)
                                    <img src="{{ asset('uploads/products/' . $item->image) }}" width="100">
                                @endif
                            </td>
                            <td>₹{{ number_format($item->base_price, 2) }}</td>
                            <td>₹{{ number_format($item->bid_price, 2) }}</td>
                            <td>{{ $item->highestBidder->name ?? '' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    
    <script>
    $(document).ready(function () {
        $('#datatable').DataTable();
    });
    </script>

    @include('admin/footer')