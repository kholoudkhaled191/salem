<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Offer</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
:root {
  --primary: #111;
  --secondary: #2d2d2d;
  --accent: #C6A972;
  --text: #333;
  --text-light: #777;
  --card-border-radius: 12px;
}
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:Poppins,sans-serif;background:#f5f7f9;color:var(--text);overflow-x:hidden;line-height:1.6;}
.sidebar{width:280px;height:100vh;background:linear-gradient(to bottom,var(--primary),var(--secondary));color:#fff;position:fixed;top:0;left:0;padding:25px 0;overflow-y:auto;}
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
.main{margin-left:280px;padding:30px;}
.section-card{margin-bottom:30px;background:white;border-radius:var(--card-border-radius);box-shadow:0 5px 15px rgba(0,0,0,0.05);padding:25px;max-width:650px;margin-left:auto;margin-right:auto;}
.section-card h1{font-size:22px;font-weight:600;margin-bottom:20px;color:var(--primary);display:flex;align-items:center;gap:10px;justify-content:center;}
.form-card label{display:block;margin-bottom:8px;font-weight:600;}
.form-card input,.form-card textarea{width:100%;padding:12px 15px;margin-bottom:20px;border-radius:8px;border:1px solid #ddd;font-size:14px;box-sizing:border-box;}
.form-card textarea{min-height:100px;resize:none;}
.btn-group{display:flex;gap:15px;margin-top:10px;}
.form-card button,.form-card .cancel-btn{flex:1;padding:12px 0;font-size:16px;font-weight:600;border-radius:8px;cursor:pointer;border:none;text-align:center;text-decoration:none;display:inline-block;transition:0.3s;}
.form-card button{background:var(--accent);color:#fff;}
.form-card button:hover{background:#b5935f;}
.cancel-btn{background:#777;color:#fff;}
.cancel-btn:hover{background:#555;}
.alert{background:#e74c3c;color:#fff;padding:12px 15px;border-radius:6px;margin-bottom:20px;}
</style>
</head>
<body>

@php $user = Auth::user(); @endphp

<div class="sidebar">
  <div class="sidebar-header">
    <h2><i class="fas fa-gift"></i> Salem Fabrics</h2>
  </div>
  <div class="user-info">
    <div class="user-avatar">{{ substr($user->name,0,2) }}</div>
    <div class="user-details">
      <div class="user-name">{{ $user->name }}</div>
      <div class="user-role">{{ ucfirst($user->role) }}</div>
    </div>
  </div>
  <ul class="sidebar-menu">
    <li><a href="{{ route('dashboard') }}"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
    <li><a href="{{ route('products.index') }}"><i class="fas fa-box"></i> Products</a></li>
    <li><a href="{{ route('offers.index') }}" class="active"><i class="fas fa-gift"></i> Offers</a></li>
    <li><a href="{{ route('offer_products.index') }}"><i class="fas fa-tags"></i> Offer Products</a></li>
    <li><a href="{{ route('branches.index') }}"><i class="fas fa-store"></i> Branches</a></li>
    <li><a href="{{ route('warehouses.index') }}"><i class="fas fa-warehouse"></i> Warehouses</a></li>
    <li><a href="{{ route('stocks.index') }}"><i class="fas fa-clipboard-list"></i> Stocks</a></li>
    <li><a href="{{ route('transactions.index') }}"><i class="fas fa-exchange-alt"></i> Transactions</a></li>
    <li><a href="{{ route('special-requests.index') }}"><i class="fas fa-star"></i> Special Requests</a></li>
  </ul>
</div>

<div class="main">
  <div class="section-card form-card">
    <h1><i class="fas fa-edit"></i> Edit Offer</h1>

    @if ($errors->any())
        <div class="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('offers.update', $offer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Name</label>
        <input type="text" name="name" value="{{ old('name', $offer->name) }}" required>

        <label>Description</label>
        <textarea name="description">{{ old('description', $offer->description) }}</textarea>

        <label>Discount Value</label>
        <input type="number" name="discount_value" value="{{ old('discount_value', $offer->discount_value) }}" required>

        <label>Start At</label>
        <input type="datetime-local" name="start_at" value="{{ old('start_at', \Carbon\Carbon::parse($offer->start_at)->format('Y-m-d\TH:i')) }}" required>

        <label>End At</label>
        <input type="datetime-local" name="end_at" value="{{ old('end_at', \Carbon\Carbon::parse($offer->end_at)->format('Y-m-d\TH:i')) }}" required>

        <div class="btn-group">
            <button type="submit"><i class="fas fa-save"></i> Update</button>
            <a href="{{ route('offers.index') }}" class="cancel-btn"><i class="fas fa-times"></i> Cancel</a>
        </div>
    </form>
  </div>
</div>

</body>
</html>
