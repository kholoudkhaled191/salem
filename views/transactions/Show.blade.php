<!DOCTYPE html>
<html>
<head>
    <title>Transaction Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="p-4">

<h1>Transaction #{{ $transaction->id }}</h1>

<a href="{{ route('transactions.index') }}" class="btn btn-secondary mb-3">Back to Transactions</a>
<a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-primary mb-3">Edit Transaction</a>

<table class="table table-bordered">
    <tr>
        <th>Type</th>
        <td>{{ $transaction->type }}</td>
    </tr>
    <tr>
        <th>Branch</th>
        <td>{{ $transaction->branch?->name ?? '-' }}</td>
    </tr>
    <tr>
        <th>From Warehouse</th>
        <td>{{ $transaction->from_warehouse?->name ?? '-' }}</td>
    </tr>
    <tr>
        <th>To Warehouse</th>
        <td>{{ $transaction->to_warehouse?->name ?? '-' }}</td>
    </tr>
    <tr>
        <th>Status</th>
        <td>{{ $transaction->status ?? 'Pending' }}</td>
    </tr>
    <tr>
        <th>Created By</th>
        <td>{{ $transaction->user?->name ?? 'System' }}</td>
    </tr>
    <tr>
        <th>Created At</th>
        <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
    </tr>
</table>

<h3>Items</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th>Quantity Rolls</th>
            <th>Quantity Rows</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transaction->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->quantity_rolls }}</td>
            <td>{{ $item->quantity_rows }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
