<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2>Transaction History</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('transactions.create') }}" class="btn btn-primary mb-3">Add Transaction</a>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3">Dashboard</a>

        <table class="table table-bordered bg-white">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Account</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $tx)
                <tr>
                    <td>{{ $tx->id }}</td>
                    <td>{{ $tx->account->account_number }}</td>
                    <td class="text-uppercase">{{ $tx->type }}</td>
                    <td>${{ number_format($tx->amount, 2) }}</td>
                    <td>{{ $tx->created_at->format('M d, Y h:i A') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $transactions->links() }}
    </div>
</body>
</html>