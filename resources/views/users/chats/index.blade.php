@extends('layouts.app')

@section('title','Chats Index')

@section('content')
    <div class="row justify-content-center">
        <div class="col-4">
            {{-- following list --}}
            @foreach ($user->following as $following)
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <a href="#">
                            @if ($following->following->avatar)
                                <img src="{{ $following->following->avatar }}" alt="{{ $following->following->name }}" class="rounded-circle avatar-sm">
                            @else
                                <i class="fa-solid fa-circle-user icon-sm text-secondary"></i>
                            @endif
                        </a>
                    </div>
                    <div class="col ps-0 text-truncate">
                        <a href="#" class="text-decoration-none text-dark fw-bold">{{ $following->following->name }}</a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-8">
            <h3>Message</h3>
            <table class="table table-hover text-center mt-3">
                <thead>
                    <tr>
                        <th>Sender</th>
                        <th>Message</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($all_chats as $chat)
                        <tr>
                            <td>
                                @if ($chat->sender->avatar)
                                    <img src="{{ $chat->sender->avatar }}" alt="{{ $chat->sender->name }}" class="rounded-circle avatar-sm me-2">
                                @else
                                    <i class="fa-solid fa-circle-user icon-sm text-secondary me-2"></i>
                                @endif
                                <a href="{{ route('chat.show',$chat->sender_id) }}" class="text-dark text-decoration-none">{{ $chat->sender->name }}</a>
                            </td>
                            <td>
                                <a href="{{ route('chat.show',$chat->sender_id) }}" class="text-dark text-decoration-none">{{ $chat->message }}</a>
                            </td>
                            <td class="text-muted">{{ $chat->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No Message Yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
