@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="mb-4">Dashboard</h1>

    {{-- Stat Cards --}}
    <div class="row mb-4">
        <div class="col-md-4 col-lg">
            <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
                <div class="card text-bg-primary">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3" style="font-size:2rem;">&#128230;</div>
                        <div>
                            <h6 class="card-title mb-0">Products</h6>
                            <h2 class="mb-0">{{ $stats['products'] }}</h2>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-lg">
            <a href="{{ route('admin.product-categories.index') }}" class="text-decoration-none">
                <div class="card text-bg-success">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3" style="font-size:2rem;">&#128193;</div>
                        <div>
                            <h6 class="card-title mb-0">Categories</h6>
                            <h2 class="mb-0">{{ $stats['product_categories'] }}</h2>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-lg">
            <a href="{{ route('admin.product-images.index') }}" class="text-decoration-none">
                <div class="card text-bg-info">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3" style="font-size:2rem;">&#128247;</div>
                        <div>
                            <h6 class="card-title mb-0">Product Images</h6>
                            <h2 class="mb-0">{{ $stats['product_images'] }}</h2>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-lg">
            <a href="{{ route('admin.news.index') }}" class="text-decoration-none">
                <div class="card text-bg-warning">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3" style="font-size:2rem;">&#128240;</div>
                        <div>
                            <h6 class="card-title mb-0">News</h6>
                            <h2 class="mb-0">{{ $stats['news'] }}</h2>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-lg">
            <a href="{{ route('admin.albums.index') }}" class="text-decoration-none">
                <div class="card text-bg-secondary">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3" style="font-size:2rem;">&#127748;</div>
                        <div>
                            <h6 class="card-title mb-0">Albums</h6>
                            <h2 class="mb-0">{{ $stats['albums'] }}</h2>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-lg">
            <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
                <div class="card text-bg-danger">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3" style="font-size:2rem;">&#128179;</div>
                        <div>
                            <h6 class="card-title mb-0">Orders</h6>
                            <h2 class="mb-0">{{ $stats['orders'] }}</h2>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-lg">
            <a href="{{ route('admin.pages.index') }}" class="text-decoration-none">
                <div class="card text-bg-dark">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3" style="font-size:2rem;">&#128196;</div>
                        <div>
                            <h6 class="card-title mb-0">Pages</h6>
                            <h2 class="mb-0">{{ $stats['pages'] }}</h2>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 col-lg">
            <a href="{{ route('admin.advertisements.index') }}" class="text-decoration-none">
                <div class="card text-bg-info">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3" style="font-size:2rem;">&#128226;</div>
                        <div>
                            <h6 class="card-title mb-0">Ads</h6>
                            <h2 class="mb-0">{{ $stats['advertisements'] }}</h2>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="card mb-4">
        <div class="card-header">Quick Actions</div>
        <div class="card-body">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary me-2">+ Add Product</a>
            <a href="{{ route('admin.product-categories.create') }}" class="btn btn-success me-2">+ Add Category</a>
            <a href="{{ route('admin.news.create') }}" class="btn btn-warning me-2">+ Add News</a>
            <a href="{{ route('admin.albums.create') }}" class="btn btn-secondary me-2">+ Add Album</a>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-dark me-2">+ Add Page</a>
            <a href="{{ route('admin.advertisements.create') }}" class="btn btn-info">+ Add Ad</a>
        </div>
    </div>

    {{-- Recent Data --}}
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <div class="card-header">Recent Products</div>
                <div class="card-body">
                    @if($recentProducts->isEmpty())
                        <p class="text-muted mb-0">No products yet.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($recentProducts as $product)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>{{ $product->name }}</span>
                                    <small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <div class="card-header">Recent News</div>
                <div class="card-body">
                    @if($recentNews->isEmpty())
                        <p class="text-muted mb-0">No news yet.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($recentNews as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>{{ $item->title }}</span>
                                    <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <div class="card-header">Recent Orders</div>
                <div class="card-body">
                    @if($recentOrders->isEmpty())
                        <p class="text-muted mb-0">No orders yet.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($recentOrders as $order)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <a href="{{ route('admin.orders.show', $order) }}">#{{ $order->id }} - {{ $order->name }}</a>
                                    <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : ($order->status === 'processing' ? 'info' : 'warning')) }}">{{ ucfirst($order->status) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <div class="card-header">Recent Albums</div>
                <div class="card-body">
                    @if($recentAlbums->isEmpty())
                        <p class="text-muted mb-0">No albums yet.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($recentAlbums as $album)
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span>{{ $album->name }}</span>
                                    <small class="text-muted">{{ $album->created_at->diffForHumans() }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
