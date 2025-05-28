<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Post-It App</title>

    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</head>
<body>
@inertia
</body>
</html>
