@extends('layouts.app')

@section('content')
@if(Auth::check())

<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Search results</div>
                    <div class="card-body">

                        @foreach ($names as $name)
                        <div class="result">
                            <p>{{ $name ->user_type}} ({{ $number }})</p>
                            <p>{{ $name ->name }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@else

@endif

@endsection