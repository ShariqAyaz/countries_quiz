@include('layout.header')
<body>
<div class="container">
    
        {{ $single_quiz['country'] }}<br>

        @foreach($single_quiz['capitals'] as $i)
            {{ $i }}
            <br>
        @endforeach
    
</div>
</body>
@include('layout.footer')