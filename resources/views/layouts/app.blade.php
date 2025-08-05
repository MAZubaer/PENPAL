<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/build/assets/logo.png">
    <title>@yield('title', config('app.name', 'PENPAL'))</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Baloo+2:700|Comic+Sans+MS:400,700" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f7fafc 0%, #e3f6fd 100%);
            font-family: 'Baloo 2', 'Comic Sans MS', cursive;
        }
        .navbar-custom {
            background-color: #e3f6fd !important; /* Light blue navbar */
            border-bottom: 2px solid #b2d7e6;
            box-shadow: 0 2px 8px #b2d7e644;
            position: relative;
            overflow: hidden;
        }
        }
        .navbar-brand {
            font-family: 'Baloo 2', 'Comic Sans MS', cursive;
            font-size: 2rem;
            color: #4f8a8b !important;
            font-weight: bold;
            letter-spacing: 2px;
        }
        .nav-link {
            color: #4f8a8b !important;
            font-size: 1.1rem;
            font-family: 'Baloo 2', 'Comic Sans MS', cursive;
        }
        .btn-cute {
            background: #b2d7e6;
            color: #4f8a8b;
            border-radius: 24px;
            border: none;
            font-weight: bold;
            box-shadow: 0 2px 8px #b2d7e644;
            font-size: 1.15rem;
            padding: 0.8rem 2.2rem;
            margin: 0.7rem;
            transition: background 0.2s, color 0.2s;
        }
        .btn-cute:hover {
            background: #4f8a8b;
            color: #e3f6fd;
        }
        h1, h4, h5 {
            font-family: 'Baloo 2', 'Comic Sans MS', cursive;
            color: #4f8a8b;
            font-weight: bold;
        }
        .feature-list {
            background: #e3f6fd;
            border-radius: 18px;
            box-shadow: 0 2px 8px #b2d7e6cc;
            padding: 2.2rem 2rem;
            margin-top: 2rem;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
        }
        .feature-list li {
            font-size: 1.22rem;
            color: #4f8a8b;
            margin-bottom: 0;
            font-family: 'Baloo 2', 'Comic Sans MS', cursive;
            display: flex;
            align-items: center;
            min-width: 320px;
            max-width: 400px;
            background: #f7fafc;
            border-radius: 14px;
            box-shadow: 0 2px 8px #b2d7e6cc;
            padding: 1rem 1.2rem;
        }
        .feature-list li::before {
            content: '';
            display: inline-block;
            width: 32px;
            height: 32px;
            margin-right: 12px;
            background-size: contain;
            background-repeat: no-repeat;
        }
        .card { border-radius: 18px; box-shadow: 0 2px 8px #55587944; }
        .form-control, .list-group-item { border-radius: 12px; }
        .feature-list li { font-size: 1.15rem; color: #98a1bc; margin-bottom: 10px; font-family: 'Baloo 2', 'Comic Sans MS', cursive; }
    </style>
    </style>
    @vite(['resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
      <video autoplay loop muted playsinline style="position:absolute;left:0;top:0;width:100%;height:100%;object-fit:cover;z-index:0;">
        <source src="/build/assets/Blue_navbarbg.mp4" type="video/mp4">
      </video>
      <div class="container position-relative" style="z-index:2;background:#e3f6fd !important;border-radius:16px;box-shadow:0 2px 8px #b2d7e644;">
        <a class="navbar-brand d-flex align-items-center gap-3" href="/" style="height:172px;position:relative;z-index:2;">
            <span style="display:flex;align-items:center;justify-content:center;height:172px;width:172px;background:rgba(255,255,255,0.35);border-radius:8px;box-shadow:0 2px 8px #b2d7e644;overflow:hidden;backdrop-filter:blur(8px) saturate(120%);">
                <img src="/build/assets/logo.png" alt="PENPAL Logo" style="height:172px;width:172px;object-fit:contain;display:block;" onerror="this.style.display='none'">
            </span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Products</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('categories.index') }}">Categories</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('cart.index') }}">Cart</a></li>
            @auth
            <li class="nav-item"><a class="nav-link" href="{{ route('orders.user') }}">Orders</a></li>
            @endauth
            @auth
            <li class="nav-item"><a class="nav-link" href="{{ route('bookmarks.index') }}">Wishlist</a></li>
            @if(auth()->user() && auth()->user()->isAdmin())
                <li class="nav-item">
                  <div class="d-flex flex-wrap align-items-center" style="gap:4px;max-width:340px;">
                    <a class="nav-link" href="{{ route('orders.admin') }}" style="white-space:nowrap;">View Orders</a>
                    <a class="nav-link" href="{{ route('coupons.index') }}" style="white-space:nowrap;">Manage Coupons</a>
                    <a class="nav-link" href="{{ route('coupons.history') }}" style="white-space:nowrap;">Coupon History</a>
                  </div>
                </li>
            @endif
            @endauth
            @auth
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                  onclick="event.preventDefault(); var dropdown = new bootstrap.Dropdown(this); dropdown.toggle();">
                  {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                  <li><a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </li>
            @endauth
            @guest
              <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Sign Up</a></li>
            @endguest
          </ul>
        </div>
      </div>
    </nav>
    <div id="app">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
