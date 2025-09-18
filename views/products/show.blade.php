<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Product Details | Salem Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
:root {
  --primary: #1a1a1a;
  --secondary: #2d2d2d;
  --accent: #C6A972;
  --text: #333;
  --text-light: #777;
  --sidebar-width: 280px;
  --card-border-radius: 12px;
}
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:Poppins,sans-serif;background:#f5f7f9;color:var(--text);line-height:1.6;overflow-x:hidden;}

/* Sidebar */
.sidebar{width:var(--sidebar-width);height:100vh;background:linear-gradient(to bottom,var(--primary),var(--secondary));color:#fff;position:fixed;top:0;left:0;padding:25px 0;overflow-y:auto;}
.sidebar-header{padding:0 25px 20px;border-bottom:1px solid rgba(255,255,255,0.1);margin-bottom:25px;}
.sidebar-header h2{color:var(--accent);text-align:center;display:flex;align-items:center;justify-content:center;gap:12px;}
.user-info{display:flex;align-items:center;padding:20px;margin:0 15px 25px;background:rgba(255,255,255,0.05);border-radius:12px;}
.user-avatar{width:50px;height:50px;border-radius:50%;background:var(--accent);display:flex;align-items:center;justify-content:center;margin-right:15px;font-weight:bold;color:var(--primary);font-size:20px;}
.user-details{flex:1;}
.user-name{font-weight:600;font-size:16px;margin-bottom:4px;}
.user-role{font-size:13px;opacity:0.8;color:var(--accent);display:inline-block;padding:4px 10px;background:rgba(198,169,114,0.15);border-radius:20px;}
.sidebar-menu{list-style:none;padding:0 15px;}
.sidebar-menu li{margin-bottom:8px;}
.sidebar-menu a{display:flex;align-items:center;color:#fff;text-decoration:none;padding:14px 18px;border-radius:10px;transition:all 0.3s ease;font-size:15px;}
.sidebar-menu a:hover{background:rgba(198,169,114,0.1);transform:translateX(5px);}
.sidebar-menu a.active{background:var(--accent);color:var(--primary);}
.sidebar-menu i{margin-right:15px;width:20px;text-align:center;font-size:18px;}

/* Main Content */
.main{margin-left:var(--sidebar-width);padding:30px; display:flex; justify-content:center;}

/* Card */
.form-card{
    background:white;
    padding:30px;
    border-radius:var(--card-border-radius);
    max-width:700px;
    width:100%;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
    border-left:6px solid var(--accent);
}

.form-card h1{
    margin-bottom:25px;
    color:var(--primary);
    display:flex;
    align-items:center;
    gap:10px;
}

.form-card p{
    margin-bottom:15px;
}

.form-card strong{
    display:inline-block;
    width:150px;
}

.btn-back{
    padding:10px 20px;
    background:var(--accent);
    color:white;
    text-decoration:none;
    border-radius:8px;
    font-weight:600;
    transition:0.3s;
    display:inline-flex;
    align-items:center;
    gap:6px;
}

.btn-back:hover{
    background:#b5925f;
}

.product-images{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    margin-top:10px;
}

.product-images img{
    width:120px;
    height:120px;
    object-fit:cover;
    border:1px solid #ccc;
    border-radius:8px;
}
</style>
</head>
<body>

@php $user = Auth::user(); @endphp

<!-- Sidebar -->
<div class="sidebar">
  <div class="sidebar-header">
    <h2><i class="fas fa-warehouse"></i> Salem Fabrics</h2>
  </div>

  <!-- User Info -->
  <div class="user-info">
    <div class="user-avatar">{{ strtoupper(substr($user->name,0,2)) }}</div>
    <div class="user-details">
      <div class="user-name">{{ $user->name }}</div>
      <div class="user-role">{{ ucfirst($user->role) }}</div>
    </div>
  </div>

  <ul class="sidebar-menu">
    <li><a href="{{ route('dashboard') }}"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
    <li><a href="{{ route('products.index') }}" class="active"><i class="fas fa-box"></i> Products</a></li>
    <li><a href="{{ route('offers.index') }}"><i class="fas fa-gift"></i> Offers</a></li>
    <li><a href="{{ route('offer_products.index') }}"><i class="fas fa-tags"></i> Offer Products</a></li>

    @if($user->role !== 'warehouse')
      <li><a href="{{ route('branches.index') }}"><i class="fas fa-store"></i> Branches</a></li>
    @endif

    @if($user->role !== 'branch')
      <li><a href="{{ route('warehouses.index') }}"><i class="fas fa-warehouse"></i> Warehouses</a></li>
    @endif

    <li><a href="{{ route('stocks.index') }}"><i class="fas fa-clipboard-list"></i> Stocks</a></li>
    <li><a href="{{ route('transactions.index') }}"><i class="fas fa-exchange-alt"></i> Transactions</a></li>
  </ul>
</div>

<!-- Main Content -->
<div class="main">
    <div class="form-card">
        <h1><i class="fas fa-box"></i> Product Details</h1>

        <p><strong>Name:</strong> {{ $product->name }}</p>
        <p><strong>Type:</strong> {{ $product->type }}</p>
        <p><strong>Description:</strong> {{ $product->description }}</p>
        <p><strong>Price Before:</strong> {{ $product->price_before }}</p>
        <p><strong>Price After:</strong> {{ $product->price_after }}</p>
        <p><strong>Colors:</strong> 
            {{ is_array($product->colors) ? implode(', ', $product->colors) : $product->colors }}
        </p>

        @if($product->images)
            <p><strong>Images:</strong></p>
            <div class="product-images">
                @foreach((array) $product->images as $image)
                    <img src="{{ asset('storage/'.$image) }}" alt="Product Image">
                @endforeach
            </div>
        @endif

        <div style="margin-top:25px;">
            <a href="{{ route('products.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Products
            </a>
        </div>
    </div>
</div>

</body>
</html>
