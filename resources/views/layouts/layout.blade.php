<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>tdd laravel test</title>
</head>
<body>
@auth
    @if(auth()->user()->type == "admin")
        <a href="admin/dashbord">admin panel</a>
    @endif
@endauth
@yield('content')
</body>
</html>
