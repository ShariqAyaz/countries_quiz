<!-- File: resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <title>Quiz Application</title>
    <script>
        // window.onload = function () {
        //     const existingToken = localStorage.getItem('token');

        //     if (!existingToken) {
                
        //         const newToken = {-- @json($_token ?? null);--}
        //         if (newToken) {
        //             localStorage.setItem('token', newToken);
        //             console.log('New token saved to localStorage:', newToken);
        //         } else {
        //             console.warn('No token provided.');
        //         }
        //     } else {
        //         console.log('Using existing token:', existingToken);
        //     }
        // };
    </script>
</head>
<body>
    <div id="app"></div>
    @viteReactRefresh
    @vite('resources/js/app.jsx')
</body>

</html>
