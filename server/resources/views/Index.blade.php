<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @auth
        <h1>home page</h1>
    @endauth
    
    @guest
        <p>guest</p>
    @endguest
        @php
            if($f == "awd") $f = "ok"
        @endphp
    {{ $f }}
</body>
</html>