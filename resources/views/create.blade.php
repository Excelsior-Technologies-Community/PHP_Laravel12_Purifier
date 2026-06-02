<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 12 Purifier Demo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f4f6f9;
        }

        .card{
            border:none;
            border-radius:15px;
        }

        .card-header{
            border-radius:15px 15px 0 0 !important;
        }

        textarea{
            resize:none;
        }
    </style>
</head>
<body>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow-lg">

                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

                    <h4 class="mb-0">
                        Laravel 12 Purifier Demo
                    </h4>

                    <a href="{{ route('posts.index') }}"
                       class="btn btn-light btn-sm">
                        📋 View Posts
                    </a>

                </div>

                <div class="card-body p-4">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}

                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="alert">
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('post.store') }}"
                          method="POST">

                        @csrf

                        <!-- Title -->

                        <div class="mb-3">

                            <label class="form-label fw-bold">
                                Post Title
                            </label>

                            <input type="text"
                                   name="title"
                                   value="{{ old('title') }}"
                                   class="form-control @error('title') is-invalid @enderror"
                                   placeholder="Enter post title">

                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <!-- Description -->

                        <div class="mb-3">

                            <label class="form-label fw-bold">
                                Description
                            </label>

                            <textarea
                                name="description"
                                rows="6"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Enter HTML content here...">{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="alert alert-info">

                            <strong>Test Purifier:</strong>

                            Try entering:

                            <code>
                                &lt;script&gt;alert('XSS')&lt;/script&gt;
                            </code>

                            and see how Purifier sanitizes the content.

                        </div>

                        <div class="d-flex justify-content-end gap-2">

                            <button type="reset"
                                    class="btn btn-secondary">
                                Reset
                            </button>

                            <button type="submit"
                                    class="btn btn-success">
                                💾 Save Post
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>