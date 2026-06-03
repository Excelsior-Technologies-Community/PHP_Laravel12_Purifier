<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Purifier Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg,
                    #020617 0%,
                    #0f172a 50%,
                    #111827 100%);
            min-height: 100vh;
            color: #f8fafc;
            font-family: 'Segoe UI', sans-serif;
        }

        .dashboard-title {
            font-size: 38px;
            font-weight: 700;
            color: white;
        }

        .dashboard-subtitle {
            color: #94a3b8;
            font-size: 15px;
        }

        .glass-card {
            background: rgba(15, 23, 42, .85);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 20px;
            overflow: hidden;
        }

        .stats-card {
            background: linear-gradient(135deg,
                    #3b82f6,
                    #2563eb);
            border: none;
            border-radius: 18px;
            color: white;
            transition: .3s;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-card h2 {
            font-size: 42px;
            font-weight: 700;
        }

        .mini-card {
            background: #111827;
            border: 1px solid #374151;
            border-radius: 18px;
            color: white;
            transition: .3s;
        }

        .mini-card:hover {
            transform: translateY(-5px);
        }

        .btn-add {
            background: #2563eb;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
        }

        .btn-add:hover {
            background: #1d4ed8;
        }

        .search-box {
            background: #1e293b !important;
            border: 1px solid #334155;
            color: white !important;
            height: 55px;
            border-radius: 12px;
            padding-left: 18px;
        }

        .search-box::placeholder {
            color: #94a3b8;
        }

        .search-box:focus {
            background: #1e293b !important;
            color: white !important;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .2);
        }

        .table {
            --bs-table-bg: transparent !important;
            --bs-table-color: #fff !important;
            --bs-table-border-color: #334155 !important;
            margin-bottom: 0;
        }

        .table thead th {
            background: #1e293b !important;
            color: white !important;
            padding: 20px;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 1px;
        }

        .table td {
            padding: 20px;
            border-color: #334155 !important;
        }

        .table tbody tr {
            transition: .3s;
        }

        .table tbody tr:hover {
            background: rgba(59, 130, 246, .12) !important;
        }

        .post-id {
            background: #22c55e;
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-delete {
            border-radius: 10px;
            padding: 6px 14px;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #94a3b8;
        }

        .empty-state h4 {
            color: white;
        }

        .alert-success {
            background: #14532d;
            color: #dcfce7;
            border: 1px solid #166534;
        }

        .pagination {
            justify-content: center;

        }

        .page-item {
            margin: 0 4px;
        }

        .page-link {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #111827 !important;
            border: 1px solid #374151 !important;
            color: white !important;
            border-radius: 10px !important;
        }

        .page-link:hover {
            background: #1e293b !important;
        }

        .page-item.active .page-link {
            background: #2563eb !important;
            border-color: #2563eb !important;
        }

        .badge-custom {
            background: #2563eb;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 13px;
        }

        .btn-dashboard {
            background: #2563eb;
            color: white;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: none;
            height: 44px;
        }

        .btn-dashboard:hover {
            background: #1d4ed8;
            color: white;
        }

        .btn-export {
            background: #16a34a;
        }

        .btn-export:hover {
            background: #15803d;
        }
    </style>

</head>

<body>

    <div class="container-fluid px-5 py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h1 class="dashboard-title">
                    🚀 Laravel Purifier Dashboard
                </h1>

                <p class="dashboard-subtitle">
                    Secure HTML Content Management System
                </p>
            </div>

            <!-- RIGHT SIDE BUTTONS WRAPPER -->
            <div class="d-flex align-items-center gap-2">

                <a href="/post/create" class="btn btn-dashboard">
                    ➕ Add New Post
                </a>

                <a href="{{ route('posts.export') }}" class="btn btn-dashboard btn-export">
                    ⬇️ Export CSV
                </a>

            </div>

        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="row mb-4">

            <div class="col-md-4 mb-3">

                <div class="card stats-card shadow">
                    <div class="card-body">
                        <h6>Total Posts</h6>
                        <h2>{{ $posts->total() }}</h2>
                    </div>
                </div>

            </div>

            <div class="col-md-4 mb-3">

                <div class="card mini-card shadow">
                    <div class="card-body">
                        <h6>Current Page</h6>
                        <h2>{{ $posts->currentPage() }}</h2>
                    </div>
                </div>

            </div>

            <div class="col-md-4 mb-3">

                <div class="card mini-card shadow">
                    <div class="card-body">
                        <h6>Posts Per Page</h6>
                        <h2>{{ $posts->perPage() }}</h2>
                    </div>
                </div>

            </div>

        </div>

        <div class="glass-card shadow-lg">

            <div class="p-4">

                <form method="GET" action="{{ route('posts.index') }}">

                    <input type="text" name="search" value="{{ request('search') }}" class="form-control search-box"
                        placeholder="🔍 Search title or description...">

                </form>

            </div>

            <div class="table-responsive">

                <table class="table table-dark mb-0">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th width="150" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($posts as $post)

                        <tr>

                            <td>
                                <span class="post-id">
                                    #{{ $post->id }}
                                </span>
                            </td>

                            <td>
                                <strong>{{ $post->title }}</strong>
                            </td>

                            <td>
                                {{ \Illuminate\Support\Str::limit(strip_tags($post->description), 60) }}
                            </td>

                            <td class="align-middle text-center">

                                <a href="{{ route('posts.edit', $post->id) }}"
                                    class="btn btn-sm btn-outline-warning p-1"
                                    title="Edit">
                                    ✏️
                                </a>

                                <form action="{{ route('posts.destroy', $post->id) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-outline-danger p-1"
                                        onclick="return confirm('Delete this post?')"
                                        title="Delete">

                                        🗑️

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="4">

                                <div class="empty-state">

                                    <h4>No Posts Found</h4>

                                    <p>
                                        Create your first post to get started.
                                    </p>

                                </div>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>
        </div>
        <div class="d-flex justify-content-center mt-4">

            <ul class="pagination">

                @for ($i = 1; $i <= $posts->lastPage(); $i++)

                    <li class="page-item {{ $posts->currentPage() == $i ? 'active' : '' }}">

                        <a class="page-link" href="{{ $posts->url($i) }}">

                            {{ $i }}

                        </a>

                    </li>

                    @endfor

            </ul>

        </div>

    </div>

</body>

</html>