<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Auction Site</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <style>
            body {
                background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            .product-card {
                transition: transform 0.3s ease;
            }

            .product-card:hover {
                transform: scale(1.03);
            }

            footer {
                background-color: rgba(0, 0, 0, 0.1);
                text-align: center;
                padding: 1rem;
                margin-top: auto;
            }

            .countdown {
                font-weight: bold;
                color: #dc3545;
            }
        </style>

        <style>
        #chat-widget{
            position: fixed; 
            bottom: 20px; 
            right: 20px; 
            z-index: 1000;
        }

        #chat-toggle{
            background: #4e73df; 
            color: white; 
            border: none; 
            padding: 10px 15px; 
            border-radius: 50%; 
            cursor: pointer; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        #chat-container{
            display: none; 
            width: 300px; 
            background: white; 
            border-radius: 8px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.2); 
            position: absolute; 
            bottom: 60px; right: 0;
        }

        #live-support{
            background: #4e73df; 
            color: white; 
            padding: 10px; 
            border-top-left-radius: 8px; 
            border-top-right-radius: 8px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
        }

        #chat-close{
            background: none; 
            border: none; 
            color: white; 
            cursor: pointer;
        }

        #chat-content{
            height: 300px; 
            overflow-y: auto; 
            padding: 10px;
        }

        #chat-message{
            width: 100%; 
            padding: 8px; 
            border: 1px solid #ddd; 
            border-radius: 4px;
        }

        #chat-send{
            margin-top: 5px; 
            background: #4e73df; 
            color: white; 
            border: none; 
            padding: 8px 15px; 
            border-radius: 4px; 
            cursor: pointer;
        }
        </style>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
            <div class="container">
            <a class="navbar-brand" href="{{ route('bidder-home') }}">🕒 BidNow</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('bidder-home') ? 'active' : '' }}" href="{{ route('bidder-home') }}">Home</a></li>

                    @auth
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('my_bids') ? 'active' : '' }}" href="{{ route('my_bids') }}">My Bids</a></li>

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link" href="#">Logout</button>
                        </form>
                    </li>
                    @endauth

                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endguest
                </ul>
            </div>
            </div>
        </nav>