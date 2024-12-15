@include('layout.header')
<body>
<div class="container">
    @foreach($single_quiz as $i)
        {{ $i['name'] }}<br>
    @endforeach
</div>
</body>
@include('layout.footer')