@include('layout.header')
<body class="d-flex flex-column min-vh-100">
    <div class="container mt-5">
        <div class="mb-4 display-4"><i>Guess the</i> <span class="mb-4 display-1">Capital</span></div>
        <form action="" method="POST">
            @csrf
            <div class="mb-3">
                <p><strong>What is the capital of {{ $single_quiz['country'] }}?</strong></p>
                @foreach($single_quiz['capitals'] as $index => $capital)
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="capital" id="capital{{ $index }}" value="{{ $capital }}" required>
                        <label class="form-check-label" for="capital{{ $index }}">
                            {{ $capital }}
                        </label>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-success">Check Answer</button>
        </form>
    </div>
@include('layout.footer')