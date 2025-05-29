<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Admin Panel</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <style>
        html {
            overflow-y: scroll;
        }

        html, body {
            height: 100%;
            margin: 0;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1 1 auto;
            /* min-height: 0; */
        }

        .error_field {
            color: red;
            font-family: math;
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
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('admin-home') }}">Auction</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin-home') ? 'active' : '' }}" href="{{ route('admin-home') }}">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('view_products') ? 'active' : '' }}" href="{{ route('view_products') }}">Products</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('completed_bids') ? 'active' : '' }}" href="{{ route('completed_bids') }}">Completed Bid</a>
                            </li>

                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="nav-link btn btn-link">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>