    @include('bidder/header')

    <style>
    .product-card img {
        height: 250px;
        object-fit: cover;
        width: 100%;
    }
    </style>

    <div class="container my-5">

        @auth
            @if (Auth::user()->role == 'bidder')
            <div class="text-center mb-5">
                <p style="font-family: 'Segoe UI', sans-serif; color: #fdfdfd; font-size: 1.2rem;">
                    Welcome <strong>{{ Auth::user()->name ?? '' }}</strong> 👋
                </p>
            </div>
            @endif
        @endauth
        
        <h2 class="text-center mb-4 text-white">Live Auction Products</h2>

        <div class="row g-4" id="auction-products">
            
        </div>
    </div>

    <script>
    function loadLiveAuctions() {
        $.getJSON("/live-auction", function(products) {
            let container = $("#auction-products");
            container.empty();

            if (!products || products.length === 0) {
                container.html('<p class="text-center">Oops, there\'s no bid at the moment.</p>');
                return;
            }

            products.forEach(product => {
                let endTime = new Date(product.end_date).toISOString();
                let html = `
                    <div class="col-md-4">
                        <div class="card product-card shadow-sm">
                            <img src="{{ asset('uploads/products/') }}/${product.image}" class="card-img-top" alt="${product.product_name}" />
                            <div class="card-body">
                                <h5 class="card-title">${product.product_name}</h5>
                                <p class="card-text">Base Price: <strong>₹${parseFloat(product.base_price).toFixed(2)}</strong></p>
                                <p class="countdown" data-end="${endTime}" data-id="${product.id}">Loading...</p>
                                <a href="/live-auction-details/${product.id}" class="btn btn-primary w-100 auction-btn" data-id="${product.id}">Bid Now</a>
                            </div>
                        </div>
                    </div>`;
                container.append(html);
            });

            updateCountdowns();
        });
    }

    function updateCountdowns() {
        $(".countdown").each(function () {
            let element = $(this);
            let endTime = new Date(element.data("end")).getTime();
            let productId = element.data("id");

            let interval = setInterval(() => {
                let cTIme = new Date().getTime();
                let distance = endTime - cTIme;

                if (distance < 0) {
                    element.text("Auction Closed");
                    clearInterval(interval);

                    let btn = $(`.auction-btn[data-id="${productId}"]`);
                    btn.text("Closed")
                        .removeClass("btn-primary")
                        .addClass("btn-danger")
                        .removeAttr("href")
                        .css("pointer-events", "none")
                        .css("opacity", "0.65");

                    return;
                }

                let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                element.text(`Time Left: ${hours}h ${minutes}m ${seconds}s`);
            }, 1000);
        });
    }

    loadLiveAuctions();

    setInterval(loadLiveAuctions, 30000);
    </script>
    
    @include('bidder/footer')
