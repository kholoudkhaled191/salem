<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Product | Salem Dashboard</title>
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
.main{margin-left:var(--sidebar-width);padding:30px;}

/* Form Card */
.form-card{background:white;padding:30px;border-radius:var(--card-border-radius);box-shadow:0 5px 15px rgba(0,0,0,0.05);max-width:700px;margin:0 auto;border-left:6px solid var(--accent);}
.form-card h1{margin-bottom:25px;color:var(--primary);text-align:center;}
.form-group{margin-bottom:15px;}
.form-group label{font-weight:500;margin-bottom:6px;display:block;}
.form-group input[type="text"],
.form-group input[type="number"],
.form-group input[type="file"]{width:100%;padding:12px 14px;border-radius:8px;border:1px solid #ddd;font-size:15px;}
.price-wrapper{display:flex;gap:20px;flex-wrap:wrap;}
.price-wrapper .form-group{flex:1;}
#colors-wrapper input{width:calc(100% - 0px);margin-bottom:5px;}
button[type="submit"], .btn-add{margin-top:10px;padding:12px 22px;background:var(--accent);color:#fff;border:none;border-radius:8px;cursor:pointer;font-size:15px;font-weight:600;display:inline-flex;align-items:center;gap:6px;transition:0.3s;}
button[type="submit"]:hover, .btn-add:hover{background:#b5925f;}
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
    <h1><i class="fas fa-box"></i> Add Product</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label>Name:</label>
        <input type="text" name="name" placeholder="Product Name" required>
      </div>
      <div class="form-group">
        <label>Type:</label>
        <input type="text" name="type" placeholder="Product Type" required>
      </div>
      <div class="form-group">
        <label>Description:</label>
        <input type="text" name="description" placeholder="Product Description">
      </div>
      <div class="price-wrapper">
        <div class="form-group">
          <label>Price Before:</label>
          <input type="number" step="0.01" name="price_before" placeholder="Price Before">
        </div>
        <div class="form-group">
          <label>Price After:</label>
          <input type="number" step="0.01" name="price_after" placeholder="Price After">
        </div>
      </div>
      <div class="form-group">
        <label>Colors:</label>
        <div id="colors-wrapper">
          <input type="text" name="colors[]" placeholder="Enter color"><br>
        </div>
        <button type="button" class="btn-add" onclick="addColor()"><i class="fas fa-plus"></i> Add Color</button>
      </div>
      <div class="form-group">
        <label>Images:</label>
        <input type="file" name="images[]" multiple>
      </div>
      <button type="submit"><i class="fas fa-save"></i> Save Product</button>
    </form>
  </div>
</div>

<script>
function addColor() {
  let wrapper = document.getElementById('colors-wrapper');
  let input = document.createElement('input');
  input.type = "text";
  input.name = "colors[]";
  input.placeholder = "Enter color";
  wrapper.appendChild(input);
  wrapper.appendChild(document.createElement('br'));
}
</script>

</body>
</html>
