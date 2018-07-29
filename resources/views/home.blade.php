@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Your keys are:
                    <ul>
                      @foreach($user->apiKeys as $key)
                        <li>{{ $key->key }}</li>
                      @endforeach
                    </ul>

                    <div>
                      <form action="{{ route('createApiKey') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="submit" value="Create new key!" class="btn btn-info">
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
