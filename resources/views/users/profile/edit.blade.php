@extends('layouts.app')

@section('title',$user->name)

@section('content')
    <div class="row justify-content-center">
        <div class="col-8">
            <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <h2 class="h3 mb-3 fw-light text-muted">Update Profile</h2>
                <div class="row mb-3">
                    <div class="col-4">
                        @if ($user->avatar)
                            <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="img-thumbnail rounded-circle d-block mx-auto avatar-lg">
                        @else
                            <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-lg"></i>
                        @endif
                    </div>
                    <div class="col-auto align-self-end">
                        <input type="file" name="avatar" id="avatar" class="form-control form-control-sm mt-1" aria-describedby="avatar-info">
                        <div class="form-text" id="avatar-info">
                            Acceptable format: jpeg,jpg,png,gif only. <br>
                            Max file size is 1048kb
                        </div>
                        @error('avatar')
                            <p class="text-danger small">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name',$user->name) }}">
                    @error('name')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email',$user->email) }}">
                    @error('email')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="introduction" class="form-label fw-bold">Introduction</label>
                    <textarea name="introduction" id="introduction" rows="5" class="form-control" placeholder="Describe yourself">{{ old('introduction',$user->introduction) }}</textarea>
                    @error('introduction')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-warning px-5">Save</button>
            </form>
        </div>
    </div>
    {{-- Create another from here for the edit/change password --}}
    <div class="row justify-content-center mt-3">
        <div class="col-8">
            {{-- <form action="{{ route('profile.updatePassword') }}" method="post">
                @csrf
                @method('PATCH')
                <h2 class="h3 mb-3 fw-light text-muted">Change Password Here</h2>
                <div class="mb-3">
                    <label for="current-password" class="form-label fw-bold">Current Password</label>
                    <input type="password" name="current_password" id="current-password" class="form-control">
                    @error('current_password')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="new-password" class="form-label fw-bold">New Password</label>
                    <input type="password" name="new_password" id="new-password" class="form-control">
                    @error('new_password')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password-confirm" class="form-label fw-bold">Confirm Password</label>
                    <input type="password" name="password_confirm" id="password-confirm" class="form-control">
                    @error('password_confirm')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                    @if(session('errorMessage'))
                        <div class="text-danger small">
                            {{ session('errorMessage') }}
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-warning px-5">Update Password</button>
                @if(session('successMessage'))
                    <div class="alert alert-success">
                        {{ session('successMessage') }}
                    </div>
                @endif
            </form> --}}
            <form action="{{ route('profile.updatepassword') }}" class="mt-5 bg-white shadow rounded-3 p-5" method="post">
                @csrf
                @method('PATCH')
                <h2 class="h3 mb-3 fw-light text-muted">Update Password</h2>
                <div class="mb-3">
                    <label for="current-password" class="form-label fw-bold">Current Password</label>
                    <input type="password" name="current_password" id="current-password" class="form-control">
                    @if (session('current_password_error'))
                        <p class="text-danger small">{{ session('current_password_error') }}</p>
                    @endif
                    @error('current_password')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="new-password" class="form-label fw-bold">New Password</label>
                    <input type="password" name="new_password" id="new-password" class="form-control" aria-describedby="password-info">
                    <div class="form-text" id="password-info">
                        Your password must be at least 8 characters long, and contain letters and numbers.
                    </div>
                    @if (session('new_password_error'))
                        <p class="text-danger small">{{ session('new_password_error') }}</p>
                    @endif
                    @error('new_password')
                        <p class="text-danger small">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="new-password-confirmation" class="form-label fw-bold">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" id="new-password-confirmation" class="form-control">
                </div>
                <button type="submit" class="btn btn-warning px-5">Update Password</button>
                @if (session('success_password'))
                    <p class="text-success small">{{ session('success_password') }}</p>
                @endif
            </form>
        </div>
    </div>
@endsection
