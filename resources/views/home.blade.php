@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-8">
            <div class="card">

                <!-- <div class="card-header">{{ __('Dashboard') }}</div> -->

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if(Auth::check())
                    Welcome, {{ Auth::user()->name }}!
                    @endif
                </div>

                <form action="{{ route('search') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row m-3">
                        <label for="search" class="col-md-4 col-form-label text-md-right">Search for a user</label>
                        <input type="text" name="search" placeholder="Search..." required class="col-md-6">
                    </div>
                    <div class="form-group m-3">
                        <label for="user_type" class="col-md-3 col-form-label text-md-right">Choose user type:</label>

                        <select class="form-group col-md-6 results">
                            @foreach ($types as $type)
                            <option>{{ $type }}</option>
                            @endforeach
                        </select>

                    </div>
                    <button type="submit" class="col-md-2 btn-search btn-primary">Search</button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection