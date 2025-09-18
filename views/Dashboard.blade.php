<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Salem Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
:root {
  --primary: #1a1a1a; --secondary: #2d2d2d; --accent: #C6A972;
  --text: #333; --text-light: #777; --success: #2ecc71; --danger: #e74c3c;
  --sidebar-width: 280px; --card-border-radius: 12px;
}
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:Poppins,sans-serif;background:#f5f7f9;color:var(--text);line-height:1.6;overflow-x:hidden;}
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
.main{margin-left:var(--sidebar-width);padding:30px;}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:25px;margin-bottom:30px;}
.card{background:white;padding:25px;border-radius:var(--card-border-radius);box-shadow:0 5px 15px rgba(0,0,0,0.05);position:relative;overflow:hidden;border-left:4px solid var(--accent);}
.card h3{font-size:16px;font-weight:600;color:var(--text-light);margin-bottom:15px;}
.card .stat{font-size:32px;font-weight:700;color:var(--primary);}
.card .icon{position:absolute;top:25px;right:25px;font-size:40px;color:rgba(198,169,114,0.15);}
.table-responsive{overflow-x:auto;border-radius:var(--card-border-radius);box-shadow:0 0 0 1px #eee;}
table{width:100%;border-collapse:collapse;}
table th, table td{padding:15px;text-align:left;border-bottom:1px solid #eee;}
table th{background:#f8f9fa;font-weight:600;color:var(--primary);position:sticky;top:0;}
.section-card{margin-bottom:30px;background:white;border-radius:var(--card-border-radius);box-shadow:0 5px 15px rgba(0,0,0,0.05);padding:25px;}
.section-card h3{font-size:20px;font-weight:600;margin-bottom:20px;color:var(--primary);}
input, select{padding:8px;border-radius:6px;border:1px solid #ccc;width:100%;margin-bottom:10px;}
button{padding:10px 20px;background:#C6A972;color:#fff;border:none;border-radius:6px;cursor:pointer;}
button:hover{background:#B5925E;}
</style>
</head>
<body>

@php $user = Auth::user(); @endphp

<div class="sidebar">
  <div class="sidebar-header">
    <h2><i class="fas fa-warehouse"></i> Salem Fabrics</h2>
  </div>
  <div class="user-info">
    <div class="user-avatar">{{ substr($user->name,0,2) }}</div>
    <div class="user-details">
      <div class="user-name">{{ $user->name }}</div>
      <div class="user-role">{{ ucfirst($user->role) }}</div>
    </div>
  </div>

  <ul class="sidebar-menu">
    <li><a href="{{ route('dashboard') }}" class="active"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
    <li><a href="{{ route('products.index') }}"><i class="fas fa-box"></i> Products</a></li>
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
    <li><a href="{{ route('special-requests.index') }}"><i class="fas fa-star"></i> Special Requests</a></li>
  </ul>
</div>

<div class="main">
  <h1>Dashboard Overview</h1>

  <!-- Stats Cards -->
  <div class="grid">
    <div class="card"><div class="icon"><i class="fas fa-box"></i></div><h3>Total Products</h3><div class="stat">{{ $data['totalProducts'] }}</div></div>
    <div class="card"><div class="icon"><i class="fas fa-store"></i></div><h3>Total Branches</h3><div class="stat">{{ $data['totalBranches'] }}</div></div>
    <div class="card"><div class="icon"><i class="fas fa-warehouse"></i></div><h3>Total Warehouses</h3><div class="stat">{{ $data['totalWarehouses'] }}</div></div>
    <div class="card"><div class="icon"><i class="fas fa-exchange-alt"></i></div><h3>Total Transactions</h3><div class="stat">{{ $data['totalTransactions'] }}</div></div>
  </div>

  <!-- Form لإضافة مستخدم جديد يظهر فقط لل general -->
  @if($user->role === 'general')
  <div class="section-card">
      <h3><i class="fas fa-user-plus"></i> Add New User</h3>
      @if(session('success'))
          <p style="color:green;">{{ session('success') }}</p>
      @endif
      <form id="addUserForm" action="{{ route('users.store') }}" method="POST">
          @csrf
          <input type="text" name="name" placeholder="Name" required>
          <input type="email" name="email" placeholder="Email" required>
          <input type="password" name="password" placeholder="Password" required>
          <select name="role" required>
              <option value="admin">Admin</option>
              <option value="branch">Branch</option>
              <option value="warehouse">Warehouse</option>
          </select>
          <button type="submit">Create User</button>
      </form>
  </div>
  @endif

  <!-- Transactions Table -->
  <div class="section-card">
    <h3><i class="fas fa-exchange-alt"></i> Transactions</h3>
    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Type</th>
            <th>From</th>
            <th>To</th>
            <th>Items</th>
            <th>Date</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data['transactions'] as $trx)
          <tr>
            <td>#TR-{{ $trx->id }}</td>
            <td>{{ ucfirst($trx->type) }}</td>
            <td>{{ $trx->from_location ?? '-' }}</td>
            <td>{{ $trx->to_location ?? '-' }}</td>
            <td>
              @foreach($trx->items as $item)
                {{ $item->product->name ?? 'N/A' }}: {{ $item->quantity_rolls }} rolls, {{ $item->quantity_rows }} rows<br>
              @endforeach
            </td>
            <td>{{ $trx->created_at->format('M d, Y') }}</td>
            <td>{{ ucfirst($trx->status) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- Special Requests Table -->
  <div class="section-card">
    <h3><i class="fas fa-star"></i> Special Requests</h3>
    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>Person Name</th>
            <th>Person Phone</th>
            <th>Note</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data['specialRequests'] as $req)
          <tr>
            <td>{{ $req->person_name }}</td>
            <td>{{ $req->person_phone }}</td>
            <td>{{ $req->note }}</td>
            <td>{{ $req->created_at->format('M d, Y') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

</div>

</body>
</html>  
