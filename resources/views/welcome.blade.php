@extends('layouts.app')
@section('content')
@section('title', 'PENPAL')
<style>
    body {
        background: linear-gradient(135deg, #f7fafc 0%, #e3f6fd 100%) !important;
        font-family: 'Baloo 2', 'Comic Sans MS', cursive !important;
    }
    .container {
        background: #f7fafc !important;
        border-radius: 24px !important;
        box-shadow: 0 4px 24px #b2d7e6cc !important;
        padding: 3.5rem 3rem !important;
        margin-top: 3rem !important;
        max-width: 1100px !important;
    }
    .fun-title {
        font-size: 3.2rem !important;
        color: #4f8a8b !important;
        font-weight: bold !important;
        letter-spacing: 2px !important;
        margin-bottom: 2rem !important;
        text-shadow: 2px 2px 0 #b2d7e6 !important;
    }
    .fun-desc {
        font-size: 1.5rem !important;
        color: #6ebfb5 !important;
        margin-bottom: 2.5rem !important;
    }
    .btn-cute {
        background: #b2d7e6 !important;
        color: #4f8a8b !important;
        border-radius: 24px !important;
        border: none !important;
        font-weight: bold !important;
        box-shadow: 0 2px 8px #b2d7e644 !important;
        font-size: 1.15rem !important;
        padding: 0.8rem 2.2rem !important;
        margin: 0.7rem !important;
        transition: background 0.2s, color 0.2s !important;
    }
    .btn-cute:hover {
        background: #4f8a8b !important;
        color: #e3f6fd !important;
    }
    .feature-list {
        background: #e3f6fd !important;
        border-radius: 18px !important;
        box-shadow: 0 2px 8px #b2d7e6cc !important;
        padding: 2.2rem 2rem !important;
        margin-top: 2rem !important;
        display: flex !important;
        flex-wrap: wrap !important;
        justify-content: center !important;
        gap: 2rem !important;
    }
    .feature-list li {
        font-size: 1.22rem !important;
        color: #4f8a8b !important;
        margin-bottom: 0 !important;
        font-family: 'Baloo 2', 'Comic Sans MS', cursive !important;
        display: flex !important;
        align-items: center !important;
        min-width: 320px !important;
        max-width: 400px !important;
        background: #f7fafc !important;
        border-radius: 14px !important;
        box-shadow: 0 2px 8px #b2d7e6cc !important;
        padding: 1rem 1.2rem !important;
    }
    .feature-list li::before {
        content: '' !important;
        display: inline-block !important;
        width: 32px !important;
        height: 32px !important;
        margin-right: 12px !important;
        background-size: contain !important;
        background-repeat: no-repeat !important;
    }
    .feature-list li:nth-child(1)::before { background-image: url('https://cdn-icons-png.flaticon.com/512/2921/2921822.png') !important; }
    .feature-list li:nth-child(2)::before { background-image: url('https://cdn-icons-png.flaticon.com/512/3523/3523887.png') !important; }
    .feature-list li:nth-child(3)::before { background-image: url('https://cdn-icons-png.flaticon.com/512/2921/2921826.png') !important; }
    .feature-list li:nth-child(4)::before { background-image: url('https://cdn-icons-png.flaticon.com/512/3523/3523882.png') !important; }
    .feature-list li:nth-child(5)::before { background-image: url('https://cdn-icons-png.flaticon.com/512/3523/3523883.png') !important; }
</style>

<div class="container text-center">
    <h1 class="fun-title">Welcome to PENPAL!</h1>
    <div class="mb-3">
        <img src="/build/assets/logo.png" alt="PENPAL Logo" style="height:300px;width:300px;object-fit:contain;display:inline-block;box-shadow:0 2px 8px #b2d7e644;border-radius:12px;background:#fff;" onerror="this.style.display='none'">
    </div>
    <p class="fun-desc">The coolest place to shop pens, notebooks, art supplies, and more!</p>
    <div class="mb-4">
        <a href="{{ route('products.index') }}" class="btn btn-cute">Shop Products</a>
        <a href="{{ route('categories.index') }}" class="btn btn-cute">Browse Categories</a>
        <a href="{{ route('cart.index') }}" class="btn btn-cute">View Cart</a>
    </div>
    <hr class="my-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h4 class="mb-3" style="color:#555879; font-family:'Baloo 2','Comic Sans MS',cursive;">Why Shop at PENPAL?</h4>
            <ul class="feature-list list-unstyled">
                <li>Super cute and colorful products</li>
                <li>Easy shopping cart and checkout</li>
                <li>Fun categories for quick browsing</li>
                <li>Surprise gifts for every order!</li>
            </ul>
        </div>
    </div>
</div>
@endsection
