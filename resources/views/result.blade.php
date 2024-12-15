@include('layout.header')

<body class="d-flex flex-column min-vh-100">
    <div class="container mt-5">

    @if($message==='correct')
        <div class="mb-4 display-4" style="margin:10px;padding:10px"><i> Yes</i><br><span class="mb-4 display-1"  style="margin:10px;padding:10px">It is Correct </span></div>
    @elseif($message==='not correct')
        <div class="mb-4 display-4">
            <i class="bg-danger" style="margin:15px;padding:15px">not quite right...!</i>
            <br>
            <br>
            <span class="mb-4 display-3"><i>The correct capital was </i><b>{{ $correct_capital}}</b>.</span>
        </div>
        @endif
        
        <a href="{{ route('index') }}" class="btn btn-warning mt-3">New Question</a>
    </div>

@include('layout.footer')