<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name') }}</title>

    <!-- Bootstrap library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- datatables library (https://datatables.net/)-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url()->current() }}">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
      @yield('content')
    </div>
    <footer>
        <!-- JQUERY library -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Bootstrap js library -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- DataTables js library -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        @yield('script')
    </footer>
</body>
</html>