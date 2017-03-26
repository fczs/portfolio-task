<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">

    @include('include.form')

    @include('include.grid')

</div>

@include('include.noty')

<script type="text/javascript" src="js/app.js"></script>
<script type="text/javascript" src="js/page.js"></script>
</body>
</html>