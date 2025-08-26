<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Recycling Facility Directory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">Recycling Directory</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsMain" aria-controls="navbarsMain" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsMain">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="{{ route('facilities.index') }}">Facilities</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('facilities.create') }}">Add Facility</a></li>
      </ul>
      <ul class="navbar-nav ms-auto">
        @auth
          <li class="nav-item"><span class="navbar-text me-2">{{ auth()->user()->name }}</span></li>
          <li class="nav-item">
            <form method="post" action="{{ route('logout') }}">
              @csrf
              <button class="btn btn-sm btn-outline-light">Logout</button>
            </form>
          </li>
        @endauth
        @guest
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
        @endguest
      </ul>
    </div>
  </div>
  </nav>

  <div class="container">
    @if (session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @yield('content')
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

