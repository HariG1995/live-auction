    @include('bidder/header')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    .prod-image {
        width: 100%; 
        max-width: 500px; 
        height: auto;
    }

    .countdown{
        color: #dc3545 !important;
    }

    #error-alert{
        color: red;
        font-family: none;
    }

    #success-alert {
        color: green;
        font-family: none;
    }
    </style>

    <style>
    .countdown {
        font-size: 1.5rem;
        transition: font-size 0.3s ease;
    }

    .countdown.warning {
        font-size: 2.5rem;
        color: #ff4d4f;
        animation: pulse 1s infinite;
        font-weight: 700;
    }

    @keyframes pulse {
        0%, 100% {
            text-shadow: 0 0 8px #ff4d4f;
        }
        50% {
            text-shadow: 0 0 20px #ff0000;
        }
    }
    </style>

    @if($isActive)
    <div class="container my-5">
        <div class="row g-4 align-items-center">
            <div class="col-md-6 text-center">
                <img src="{{ asset('uploads/products/'.$product->image) }}" class="img-fluid rounded shadow prod-image" alt="{{ $product->product_name }}">
            </div>

            <div class="col-md-6">
                <h2 class="mb-3 text-white">{{ $product->product_name }}</h2>
                <p class="text-light">Ends in: <span class="countdown fs-5 fw-bold text-warning" data-end="{{ $product->end_date }}"></span></p>
                <div class="bg-light p-4 rounded shadow-sm">
                    <p><strong>Base Price:</strong> ₹{{ number_format($product->base_price, 2) }}</p>

                    <form class="d-flex align-items-center gap-3 mt-3">
                        <label class="form-label m-0"><strong>Current Bid: ₹</strong></label>
                        <div class="input-group" style="max-width: 200px;">
                            <input type="number" id="bidPrice" class="form-control" value="{{ $currentBid }}" min="{{ $product->base_price }}" step="10">
                            <button type="button" class="btn btn-outline-secondary" onclick="increaseBid()">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>

                        <button type="button" class="btn btn-success d-flex align-items-center gap-2" id="placeBid" data-id="{{ $product->id }}">
                            <i class="bi bi-cash-coin"></i> Place Bid
                        </button>
                    </form>

                    <span id="error-alert"></span>
                    <span id="success-alert"></span>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="d-flex vh-100 justify-content-center align-items-center">
        <div class="text-center">
            <h1 class="display-4 fw-bold text-danger">⛔ Auction Unavailable</h1>
            <p class="lead text-muted">Sorry, this auction is either not active yet or has already ended.</p>
            <a href="{{ route('bidder-home') }}" class="btn btn-outline-primary mt-4">
            <i class="bi bi-arrow-left-circle"></i> Back to Home
            </a>
        </div>
    </div>
    @endif

    <script>
    $(document).on("click", "#placeBid", function(){
        var prodID = $(this).data('id');
        var isLoggedIn = @json(auth()->check());
        var userRole = @json(auth()->check() ? auth()->user()->role : null);

        if(!isLoggedIn || userRole === 'admin') {
            $("#error-alert").html("Please log in first to place a bid.").show().delay(3000).fadeOut();
        }else{
            var bidPrice = $("#bidPrice").val();

            if(bidPrice && prodID){
                $.ajax({
                    method : "post",
                    dataType : "json",
                    url : "{{ route('create_bid') }}",
                    data : {
                        bid_price : bidPrice,
                        product_id : prodID,
                        _token : "{{ csrf_token() }}"
                    },
                    beforeSend:function(){
                        $("#placeBid").attr("disabled", true);
                    },
                    success:function(data){
                        $("#placeBid").attr("disabled", false);
                        $("#success-alert").html("Your bid added successfully").show().delay(3000).fadeOut();
                    },
                    error:function(xhr){
                        $("#placeBid").attr("disabled", false);
                        
                        if (xhr.responseJSON && xhr.responseJSON.status === 'failed') {
                            $("#error-alert").html(xhr.responseJSON.message).show().delay(3000).fadeOut();
                        } else {
                            $("#error-alert").html("Something went wrong").show().delay(3000).fadeOut();
                        }
                    }
                });
            }
        }
    });

    function checkOtherBid(){
        var prodID = $("#placeBid").data('id');
        var currentBidPrice = $("#bidPrice").val();

        $.ajax({
            method : "get",
            dataType : "json",
            url : "{{ route('check_other_bid') }}",
            data : {
                bid_price : currentBidPrice,
                product_id : prodID,
                _token : "{{ csrf_token() }}"
            },
            success:function(data){
                if(data.status == 'success'){
                    $("#bidPrice").val(data.amount);

                    $("#success-alert").html("New bid received").show().delay(3000).fadeOut();
                }
            },
            error:function(data){
                console.log("something went wrong");
            }
        });
    }

    checkOtherBid();

    setInterval(checkOtherBid, 5000);
    </script>

    <script>
    document.querySelectorAll('.countdown').forEach(el => {
        const endTime = new Date(el.getAttribute('data-end')).getTime();
        const interval = setInterval(() => {
            const now = new Date().getTime();
            const diff = endTime - now;

            if (diff <= 0) {
                el.textContent = "Bidding closed";
                el.classList.remove('warning');

                completeBid();

                setTimeout(function() {
                    location.reload();
                }, 5000);
            } else {
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                el.textContent = `${hours}h ${minutes}m ${seconds}s`;

                if (diff <= 60000) {
                    el.classList.add('warning');
                } else {
                    el.classList.remove('warning');
                }
            }
        }, 1000);
    });

    function increaseBid() {
        const input = document.getElementById('bidPrice');
        const step = parseFloat(input.step) || 1;
        const current = parseFloat(input.value) || 0;
        const newValue = current + step;
        input.value = newValue.toFixed(2);
    }

    function completeBid(){
        var prodID = $("#placeBid").data('id');

        $.ajax({
            method : "post",
            dataType : "json",
            url : "{{ route('complete_bid') }}",
            data : {
                product_id : prodID,
                _token : "{{ csrf_token() }}"
            },
            success:function(data){
                console.log("complete the bid");
            },
            error:function(data){
                console.log("cannot complete the bid");
                console.log(data);
            }
        });
    }
    </script>

    @include('bidder/footer')