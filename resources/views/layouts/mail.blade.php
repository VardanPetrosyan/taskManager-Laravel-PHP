<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
   <p style="text-align:center;">
       <img src="{{asset('assets/images/logo.png')}}" alt="logo">
   </p>
   <div style="width:70%; margin:0 auto; text-align:center; border-radius:10px; border: 5px solid #59B210; " >
    <main>
        @yield('content')
    </main>
    </div>
</body>
</html>