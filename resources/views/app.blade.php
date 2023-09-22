<!-- resources/views/app.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <!-- Your HTML head content here -->
</head>
<body>
    <!-- Include the header template -->
    @include('header')

    <!-- Content of your application -->
    <div class="content">
        @yield('content') <!-- This will be replaced by specific content from views -->
    </div>

    <!-- Your footer or other layout elements here -->
</body>
</html>
