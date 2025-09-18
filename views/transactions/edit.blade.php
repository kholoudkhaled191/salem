<!DOCTYPE html>
<html>
<head>
    <title>Edit Transaction</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="p-4">

<h1>Edit Transaction #{{ $transaction->id }}</h1>

<a href="{{ route('transactions.index') }}" class="btn btn-secondary mb-3">Back to Transactions</a>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Type:</label>
        <select name="type" class="form-control" required>
            <option value="in" {{ $transaction->type == 'in' ? 'selected' : '' }}>In (Stock In)</option>
            <option value="out" {{ $transaction->type == 'out' ? 'selected' : '' }}>Out (Stock Out)</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Branch (optional):</label>
        <select name="branch_id" class="form-control">
            <option value="">Select Branch</option>
            @foreach(\App\Models\Branch::all() as $branch)
                <option value="{{ $branch->id }}" {{ $transaction->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>From Warehouse:</label>
        <select name="from_warehouse_id" class="form-control">
            <option value="">Select Warehouse</option>
            @foreach(\App\Models\Warehouse::all() as $warehouse)
                <option value="{{ $warehouse->id }}" {{ $transaction->from_warehouse_id == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>To Warehouse:</label>
        <select name="to_warehouse_id" class="form-control">
            <option value="">Select Warehouse</option>
            @foreach(\App\Models\Warehouse::all() as $warehouse)
                <option value="{{ $warehouse->id }}" {{ $transaction->to_warehouse_id == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
            @endforeach
        </select>
    </div>

    <h4>Items</h4>
    <div id="items-wrapper">
        @foreach($transaction->items as $index => $item)
        <div class="item mb-3">
            <select name="items[{{ $index }}][product_id]" class="form-control mb-2" required>
                <option value="">Select Product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                @endforeach
            </select>
            <input type="number" name="items[{{ $index }}][quantity_rolls]" placeholder="Quantity Rolls" class="form-control mb-2" value="{{ $item->quantity_rolls }}" required>
            <input type="number" name="items[{{ $index }}][quantity_rows]" placeholder="Quantity Rows" class="form-control mb-2" value="{{ $item->quantity_rows }}" required>
        </div>
        @endforeach
    </div>

    <button type="button" id="add-item" class="btn btn-secondary mb-3">Add Another Item</button>
    <br>
    <button type="submit" class="btn btn-success">Update Transaction</button>
</form>

<script>
let itemIndex = {{ $transaction->items->count() }};
document.getElementById('add-item').addEventListener('click', function() {
    const wrapper = document.getElementById('items-wrapper');
    const newItem = document.querySelector('.item').cloneNode(true);
    newItem.querySelectorAll('select, input').forEach(el => {
        const name = el.getAttribute('name');
        const newName = name.replace(/\d+/, itemIndex);
        el.setAttribute('name', newName);
        if(el.tagName === 'INPUT') el.value = '';
    });
    wrapper.appendChild(newItem);
    itemIndex++;
});
</script>

</body>
</html>
