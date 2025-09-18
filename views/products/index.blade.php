<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Products | Salem Dashboard</title>
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

/* Table Card */
.table-card {
    background:#fff;
    padding:30px 25px;
    border-radius:var(--card-border-radius);
    max-width:95%;
    margin:0 auto;
    color:#333;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.table-card h1 {
    margin-bottom:20px;
    color:var(--accent);
    display:flex;
    align-items:center;
    gap:10px;
}

.btn-add {
    display:inline-block;
    margin-bottom:15px;
    padding:10px 20px;
    background:var(--accent);
    color:#fff;
    border-radius:6px;
    text-decoration:none;
    font-weight:600;
    transition:0.3s;
}

.btn-add:hover {
    background:#b5925f;
}

.table-responsive { overflow-x:auto; }

table { width:100%; border-collapse:collapse; table-layout:auto; }

thead th {
    background:#f4f4f4;
    padding:12px;
    text-align:left;
    font-weight:600;
    border-bottom:1px solid #ddd;
}

tbody td {
    padding:12px;
    border-bottom:1px solid #eee;
    vertical-align: middle;
}

.product-img {
    width:50px;
    height:50px;
    object-fit:cover;
    margin:2px;
    border-radius:5px;
    border:1px solid #ccc;
}

.actions {
    display:flex;
    gap:5px;
    justify-content:center;
}

.actions a,
.actions button {
    padding:6px 10px;
    border:none;
    border-radius:5px;
    cursor:pointer;
    color:#fff;
    font-size:14px;
    text-decoration:none;
    display:flex;
    align-items:center;
    justify-content:center;
}

.actions .view { background:#3498db; }
.actions .view:hover { background:#2980b9; }

.actions .edit { background:#f39c12; }
.actions .edit:hover { background:#d78e0b; }

.actions .delete { background:#e74c3c; }
.actions .delete:hover { background:#c0392b; }
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
  <div class="table-card">
    <h1><i class="fas fa-box"></i> Products</h1>

    <a href="{{ route('products.create') }}" class="btn-add">+ Add Product</a>

    @if(session('success'))
        <p style="color:green; margin-top:15px;">{{ session('success') }}</p>
    @endif

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Colors</th>
                    <th>Images</th>
                    <th>Price Before</th>
                    <th>Price After</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->type }}</td>
                    <td>{{ $product->description }}</td>

                    <td>
                        @php
                            $colors = $product->colors;
                            if (is_string($colors)) {
                                $colors = json_decode($colors, true) ?? explode(',', $colors);
                            }
                            if (!is_array($colors)) $colors = [];
                        @endphp
                        {{ implode(', ', $colors) ?: '-' }}
                    </td>

                    <td>
                        @php
                            $images = $product->images;
                            if (is_string($images)) {
                                $images = json_decode($images, true) ?? explode(',', $images);
                            }
                            if (!is_array($images)) $images = [];
                        @endphp
                        @if(count($images) > 0)
                            @foreach($images as $img)
                                <img src="{{ asset('storage/'.$img) }}" class="product-img">
                            @endforeach
                        @else
                            No Images
                        @endif
                    </td>

                    <td>{{ $product->price_before ?? '-' }}</td>
                    <td>{{ $product->price_after ?? '-' }}</td>

                    <td>
                        <div class="actions">
                            <a href="{{ route('products.show', $product) }}" class="btn-action view" title="View Product"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('products.edit', $product) }}" class="btn-action edit" title="Edit Product"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action delete" onclick="return confirm('Delete this product?')" title="Delete Product">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </div>
</div>

</body>
</html>
