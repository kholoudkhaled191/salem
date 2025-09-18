<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Special Requests | Salem Dashboard</title>
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

/* Card */
.table-card{
    background:#fff;
    padding:30px;
    border-radius:var(--card-border-radius);
    max-width:95%;
    margin:0 auto;
    color:#333;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    border-left:6px solid var(--accent);
}

.table-card h1{
    margin-bottom:20px;
    color:var(--accent);
}

/* Table */
.table-responsive{overflow-x:auto;}
table { width:100%; border-collapse:collapse; table-layout:auto; }
thead th { background:#f4f4f4; padding:12px; text-align:left; font-weight:600; border-bottom:1px solid #ddd; }
tbody td { padding:12px; border-bottom:1px solid #eee; vertical-align: middle; }
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
    <li><a href="{{ route('products.index') }}"><i class="fas fa-box"></i> Products</a></li>
    <li><a href="{{ route('offers.index') }}"><i class="fas fa-gift"></i> Offers</a></li>
    <li><a href="{{ route('offer_products.index') }}"><i class="fas fa-tags"></i> Offer Products</a></li>
    <li><a href="{{ route('stocks.index') }}"><i class="fas fa-clipboard-list"></i> Stocks</a></li>
    <li><a href="{{ route('transactions.index') }}"><i class="fas fa-exchange-alt"></i> Transactions</a></li>
  </ul>
</div>

<!-- Main Content -->
<div class="main">
    <div class="table-card">
        <h1><i class="fas fa-sticky-note"></i> Special Requests</h1>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Person Name</th>
                        <th>Person Phone</th>
                        <th>Note</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $req)
                        <tr>
                            <td>{{ $req->id }}</td>
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
