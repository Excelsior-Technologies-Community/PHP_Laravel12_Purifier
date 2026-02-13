# PHP_LARAVEL12_PURIFIER
```php
A Laravel 12 based web application demonstrating HTML sanitization and XSS protection using Laravel Purifier, built with clean MVC architecture.
```
# Key Features
```php
- Laravel 12 Compatible
- HTML Sanitization & XSS Protection
- Secure User Input Handling
- Clean MVC Architecture
- Beginner Friendly Setup
- Configurable Allowed HTML Tags
- Real-world CMS / Blog Use Case
- Lightweight & Easy Integration
```
# Step 1: Install Fresh Laravel 12 Application
Open Terminal / Command Prompt and run:
```php
composer create-project laravel/laravel:^12.0 PHP_Laravel12_Purifier
```
Move into project directory:
```php
cd PHP_Laravel12_Purifier
```
Generate application key:
```php
php artisan key:generate
```
# Explanation
```php
- Installs a fresh Laravel 12 project
- Application key is required for encryption, sessions, and security
```
# Step 2: Configure Environment & Database
Open .env file and update database configuration:
```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=php_laravel12_purifier
DB_USERNAME=root
DB_PASSWORD=
```
Run default migrations:
```php
php artisan migrate
```
# Explanation
```php
- .env manages environment configuration
- Default migrations create Laravel system tables
- Confirms database connection is working
```

# Step 3: Install Laravel Purifier Package
Install Laravel Purifier package using Composer:
```php
composer require mews/purifier
```
Publish Purifier configuration file:
```php
php artisan vendor:publish --provider="Mews\Purifier\PurifierServiceProvider"
```
# Explanation
```php
- Installs Laravel Purifier package
- Publishes config/purifier.php for customization
- Enables HTML sanitization features
```

# Step 4: Create Posts Table
Generate model and migration:
```php
php artisan make:model Post -m
```
Update migration file:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
```
Run migration:
```php
php artisan migrate
```
# Explanation
```php
- Creates posts table
- Stores user-submitted HTML content
- Used to demonstrate Purifier functionality
```
# Step 5: Create Controller
Generate controller:
```php
php artisan make:controller PostController
```
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Purifier;

class PostController extends Controller
{
    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        Post::create([
            'title' => $request->title,
            'description' => Purifier::clean($request->description)
        ]);

        return redirect()->back()->with('success', 'Post Saved Successfully!');
    }
}
```
# Explanation
```php
- Controller handles form requests
- Applies Purifier before saving data
- Keeps business logic organized
```
# Step 6: Configure Web Routes
Open file:
```php
routes/web.php
```
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/post/create', [PostController::class, 'create']);
Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
```
# Explanation
```php
- Defines form display route
- Handles form submission securely
```

# Step 7: Blade UI Structure
Views folder structure:
```php
resources/views/
└── create.blade.php
```
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel 12 Purifier Demo</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Create Post (Laravel 12 + Purifier)</h4>
                </div>

                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('post.store') }}" method="POST">
                        @csrf

                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter post title">
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Description
                                <!-- <small class="text-muted">(Try adding &lt;script&gt; tag)</small> -->
                            </label>
                            <textarea name="description" class="form-control" rows="5"
                                placeholder="Enter HTML content here..."></textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-success px-4">
                                💾 Save Post
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
```
# Explanation
```php
- Blade template provides UI
- User enters HTML content
- Used to test XSS protection
```
# Step 8: Apply Laravel Purifier in Controller
Inside PostController:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Purifier;

class PostController extends Controller
{
    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        Post::create([
            'title' => $request->title,
            'description' => Purifier::clean($request->description)
        ]);

        return redirect()->back()->with('success', 'Post Saved Successfully!');
    }
}
```
# Explanation
```php
- Purifier::clean() removes malicious HTML
- Blocks <script> and unsafe attributes
- Allows only safe HTML tags
```

# Step 9: Run Laravel Project
Start Laravel development server:
```php
php artisan serve
```

# Step 10: Open Browser
Create Post Page:
```php
http://127.0.0.1:8000/post/create
```
<img width="1347" height="634" alt="image" src="https://github.com/user-attachments/assets/a2b6a8ca-b65f-4a13-92ae-d254d649e424" />

# Explanation
```php
- Runs Laravel locally
- Opens Purifier demo form
- User input is sanitized before database storage
```

# Project Folder Structure
```php
PHP_LARAVEL12_PURIFIER
├── app/
│   ├── Models/
│   │   └── Post.php
│   └── Http/
│       └── Controllers/
│           └── PostController.php
│
├── resources/
│   └── views/
│       └── create.blade.php
│
├── routes/
│   └── web.php
│
├── database/
│   └── migrations/
│
├── config/
│   └── purifier.php
│
├── .env
├── artisan
└── composer.json
```


