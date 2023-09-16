@extends('dash.layouts.app')

@section('title', 'PROFILE')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="profile-header text-center">
            <div class="mb-4">
                <img src="{{ $auth->avatar() }}" alt="avatar" class="h-auto rounded-circle" style="width: 150px; height: 150px;" />
            </div>
            <div class="profile-details">
                <h2 class="mb-3 text-center">{{ $user->name }}</h2>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h4 class="text-center"><strong>Username :</strong> {{ $user->username }}</h4>
                        <h4 class="text-center"><strong>Hak Akses :</strong> {{ $user->role }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
