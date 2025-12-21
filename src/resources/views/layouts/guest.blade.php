<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Кредитная система') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .auth-card {
            max-width: 400px;
            margin: 100px auto;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .auth-header {
            background-color: #343a40;
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 2rem;
            text-align: center;
        }
        
        .auth-body {
            padding: 2rem;
            background-color: white;
            border-radius: 0 0 15px 15px;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-auth {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 10px 20px;
            width: 100%;
            border-radius: 5px;
        }
        
        .auth-link {
            color: #667eea;
            text-decoration: none;
        }
        
        .auth-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>