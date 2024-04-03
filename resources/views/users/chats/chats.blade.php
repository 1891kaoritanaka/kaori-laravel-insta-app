@extends('layouts.app')

@section('title','Chats Show')

@section('content')
    <div class="row">
        <div class="col-5 mx-auto">
            {{-- Form --}}
            <form action="#" method="post">
                @csrf
                <div class="mb-2">
                    <input type="text" name="message" class="form-control">
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

            {{-- Chat  --}}
            @forelse ($all_chats as $chat)
                <div class="card shadow mb-2 p-3 pb-0 mt-4">
                    <p>
                        @if ($chat->sender->avatar)
                            <img src="{{ $chat->sender->avatar }}" alt="{{ $chat->sender->name }}" class="rounded-circle avatar-sm me-2">
                        @else
                            <i class="fa-solid fa-circle-user icon-sm text-secondary me-2"></i>
                        @endif
                        {{ $chat->sender->name }}
                    </p>
                    <h5>{{ $chat->message }}</h5>
                    <p class="text-muted text-end small">{{ $chat->sender->created_at }}</p>
                </div>
            @empty
                <div class="card shadow">
                    <p>No Message yet.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
