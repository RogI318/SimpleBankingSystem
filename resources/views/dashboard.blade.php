<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banking Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Banking Dashboard</h2>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card p-3 shadow-sm">
                    <h5>Total Accounts</h5>
                    <h3 id="total-accounts" class="text-primary">0</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow-sm">
                    <h5>Total Money in Bank</h5>
                    <h3 class="text-success">$<span id="total-money">0.00</span></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow-sm">
                    <h5>Transactions Today</h5>
                    <h3 id="tx-today" class="text-warning">0</h3>
                </div>
            </div>
        </div>

        <a href="{{ route('transactions.create') }}" class="btn btn-primary">New Transaction</a>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">View Transactions</a>
    </div>

    <script>
        function fetchStats() {
            fetch('/api/dashboard/stats')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('total-accounts').innerText = data.total_accounts;
                    document.getElementById('total-money').innerText = Number(data.total_money).toFixed(2);
                    document.getElementById('tx-today').innerText = data.transactions_today;
                })
                .catch(err => console.error('Error fetching stats:', err));
        }

        fetchStats();                    // load right away
        setInterval(fetchStats, 30000);  // then every 30 seconds, no page refresh
    </script>
</body>
</html>