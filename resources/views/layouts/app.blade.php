<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Paróquia Digital') — Paróquia Digital</title>
    <link rel="icon" type="image/jpeg" href="/images/sao-sebastiao.jpeg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #1a3a5c;
            --primary-light: #2563eb;
            --accent: #d4af37;
            --bg: #f4f6f9;
            --sidebar-width: 260px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: #1e293b;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url('/images/igreja-001.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            opacity: 0.15;
            z-index: -1;
            pointer-events: none;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--primary);
            display: flex;
            flex-direction: column;
            z-index: 100;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
        }

        .sidebar-logo {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-logo .cross {
            font-size: 28px;
            color: var(--accent);
        }

        .sidebar-logo h1 {
            color: white;
            font-size: 16px;
            font-weight: 700;
            line-height: 1.2;
        }

        .sidebar-logo span {
            color: var(--accent);
            font-size: 11px;
            font-weight: 400;
            display: block;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 0;
            overflow-y: auto;
        }

        .nav-section {
            padding: 8px 16px 4px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.4);
            font-weight: 600;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
            font-size: 14px;
            border-left: 3px solid transparent;
            transition: all 0.2s;
            margin: 2px 0;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            border-left-color: var(--accent);
        }

        .nav-item.active {
            background: rgba(255, 255, 255, 0.12);
            color: white;
            border-left-color: var(--accent);
        }

        .nav-item .icon {
            width: 18px;
            text-align: center;
            font-size: 16px;
        }

        /* Main */
        .main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: white;
            padding: 0 28px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.05);
        }

        .topbar-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--primary);
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }

        .user-name {
            font-size: 14px;
            font-weight: 500;
        }

        .content {
            padding: 28px;
            flex: 1;
        }

        /* Cards */
        .card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.06);
            margin-bottom: 24px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
        }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px 24px;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.06);
            border-left: 4px solid var(--accent);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            font-size: 28px;
        }

        .stat-value {
            font-size: 26px;
            font-weight: 700;
            color: var(--primary);
        }

        .stat-label {
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
        }

        /* Tables */
        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        thead th {
            padding: 12px 16px;
            text-align: left;
            background: #f8fafc;
            color: #64748b;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
        }

        tbody td {
            padding: 13px 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-green {
            background: #dcfce7;
            color: #166534;
        }

        .badge-red {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-gray {
            background: #f1f5f9;
            color: #475569;
        }

        .badge-blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-yellow {
            background: #fef9c3;
            color: #92400e;
        }

        .badge-purple {
            background: #ede9fe;
            color: #6d28d9;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: #0f2b47;
        }

        .btn-accent {
            background: var(--accent);
            color: #1e293b;
        }

        .btn-accent:hover {
            opacity: 0.9;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #cbd5e1;
            color: #475569;
        }

        .btn-outline:hover {
            background: #f8fafc;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-sm {
            padding: 5px 12px;
            font-size: 12px;
        }

        .btn-success {
            background: #16a34a;
            color: white;
        }

        .btn-success:hover {
            background: #15803d;
        }

        /* Forms */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 500;
            color: #374151;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 9px 13px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            background: white;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
            width: 100%;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            align-items: center;
        }

        /* Alerts */
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        /* Pagination */
        .pagination {
            display: flex;
            gap: 4px;
            align-items: center;
            margin-top: 20px;
        }

        .pagination a,
        .pagination span {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 14px;
            text-decoration: none;
            border: 1px solid #e2e8f0;
            color: #475569;
        }

        .pagination .active span {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .pagination a:hover {
            background: #f8fafc;
        }

        /* Logout */
        form.logout-form button {
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            color: rgba(255, 255, 255, 0.75);
            font-size: 14px;
            font-family: inherit;
            border-left: 3px solid transparent;
            transition: all 0.2s;
        }

        form.logout-form button:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
        }

        /* Search bar */
        .search-bar {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .search-bar input {
            padding: 8px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            background-color: white;
        }

        .search-bar select {
            padding: 8px 36px 8px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-color: white;
            background-image: url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2212%22%20height%3D%228%22%20viewBox%3D%220%200%2012%208%22%3E%3Cpath%20d%3D%22M1%201l5%205%205-5%22%20stroke%3D%22%2364748b%22%20stroke-width%3D%221.5%22%20fill%3D%22none%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%2F%3E%3C%2Fsvg%3E');
            background-repeat: no-repeat;
            background-position: right 12px center;
            cursor: pointer;
        }

        .search-bar input:focus,
        .search-bar select:focus {
            outline: none;
            border-color: var(--primary-light);
        }

        /* Finance colors */
        .text-green {
            color: #16a34a;
        }

        .text-red {
            color: #dc2626;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        /* Section header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary);
        }

        .page-subtitle {
            font-size: 14px;
            color: #64748b;
            margin-top: 2px;
        }

        /* Detail lists */
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
        }

        .detail-item {}

        .detail-label {
            font-size: 12px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .detail-value {
            font-size: 15px;
            color: #1e293b;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-logo">
            <img src="/images/sao-sebastiao.jpeg" alt="São Sebastião"
                style="width:42px; height:42px; border-radius:50%; object-fit:cover; border:2px solid var(--accent); flex-shrink:0;">
            <div>
                <h1>Paróquia Digital</h1>
                <span>Gestão Paroquial</span>
            </div>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section">Principal</div>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="icon">🏠</span> Dashboard
            </a>

            <div class="nav-section">Paroquianos</div>
            <a href="{{ route('fieis.index') }}" class="nav-item {{ request()->routeIs('fieis.*') ? 'active' : '' }}">
                <span class="icon">👥</span> Fiéis
            </a>
            <a href="{{ route('sacramentos.index') }}"
                class="nav-item {{ request()->routeIs('sacramentos.*') ? 'active' : '' }}">
                <span class="icon">✝️</span> Sacramentos
            </a>

            <div class="nav-section">Comunidade</div>
            <a href="{{ route('grupos.index') }}" class="nav-item {{ request()->routeIs('grupos.*') ? 'active' : '' }}">
                <span class="icon">🤝</span> Grupos e Pastorais
            </a>
            <a href="{{ route('eventos.index') }}"
                class="nav-item {{ request()->routeIs('eventos.*') ? 'active' : '' }}">
                <span class="icon">📅</span> Agenda e Eventos
            </a>

            <div class="nav-section">Administração</div>
            <a href="{{ route('financas.index') }}"
                class="nav-item {{ request()->routeIs('financas.*') ? 'active' : '' }}">
                <span class="icon">💰</span> Financeiro
            </a>

            <div class="nav-section">Conta</div>
            <a href="{{ route('profile.edit') }}"
                class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <span class="icon">⚙️</span> Perfil
            </a>
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit"><span class="icon">🚪</span> Sair</button>
            </form>
        </nav>
    </div>

    <div class="main">
        <div class="topbar">
            <div class="topbar-title">@yield('page_title', 'Dashboard')</div>
            <div class="topbar-user">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <span class="user-name">{{ Auth::user()->name }}</span>
            </div>
        </div>
        <div class="content">
            @if (session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
            @endif
            @if (session('error'))
            <div class="alert alert-error">❌ {{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

</body>

</html>