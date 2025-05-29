    @include('bidder/header')
    <div class="container my-5">
        <h2 class="mb-4 text-primary">🧾 My Completed Bids</h2>

        <div class="row g-4">
            @foreach ($bids as $item)
            <div class="col-md-6">
                <div class="card shadow-sm border-0 bg-light">
                    <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('uploads/products/'.$item->image) }}" class="rounded me-3" alt="Product" style="width: 100px; height: 100px; object-fit: cover;">
                            <div>
                                <h5 class="card-title mb-1">{{ $item->product_name }}</h5>
                                <p class="mb-0 text-muted">Base Bid: <strong>₹{{ number_format($item->base_price,2) }}</strong></p>
                                <p class="mb-0 text-muted">Final Bid: <strong>₹{{ number_format($item->bid_price,2) }}</strong></p>
                                <small class="text-success">✔️ You Won</small>
                            </div>
                        </div>
                        <div class="mt-3 mt-md-0 text-end">
                            <span class="badge bg-secondary">{{ $item->status }}</span><br>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @include('bidder/footer')