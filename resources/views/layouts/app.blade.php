<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Insurance CRM')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --crm-navy: #1b3a4b;
            --crm-teal: #0d7377;
            --crm-sand: #f4f7f6;
        }
        body { background: var(--crm-sand); min-height: 100vh; }
        .navbar { background: var(--crm-navy); }
        .navbar-brand, .nav-link, .navbar-text { color: #fff !important; }
        .nav-link.active, .nav-link:hover { color: #9ee7e5 !important; }
        .card { border: 0; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
        .btn-primary { background: var(--crm-teal); border-color: var(--crm-teal); }
        .btn-primary:hover { background: #095c5f; border-color: #095c5f; }
        .table thead { background: #e8eef0; }
        .stat { font-size: 1.75rem; font-weight: 700; color: var(--crm-navy); }
    </style>
</head>
<body>
@auth
<nav class="navbar navbar-expand-lg mb-4">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="{{ route('dashboard') }}">Insurance CRM</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('owners.index') }}">Owners</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('sales.index') }}">Contracts</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('claims.index') }}">Claims</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('notes.index') }}">Notes</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('history.index') }}">History</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('reports.index') }}">Reports</a></li>
                @if(auth()->user()->roleEnum()->atLeast(\App\Enums\UserRole::Administrator))
                    <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Users</a></li>
                @endif
            </ul>
            <span class="navbar-text me-3">{{ auth()->user()->fullName() }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-sm btn-outline-light">Logout</button>
            </form>
        </div>
    </div>
</nav>
@endauth

<main class="container pb-5">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @yield('content')
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
