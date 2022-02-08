@extends('layouts.app')
@section('content')
    {{-- make a show post page with add comments using bootstrap 4 --}}
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">

                            <div class="col-auto  p-3">
                                @if ($user->avatar_path == null)
                                <img class="rounded-circle img-fluid" width="60"
                                src="https://avatars.dicebear.com/api/initials/{{substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)}}.svg?backgroundColorLevel=300&fontSize=35"
                                alt="">
                                @else
                                <img class="rounded-circle img-fluid" width="60"
                                src="{{ url('storage/avatars/' . $user->avatar_path) }}" alt="">
                                @endif
                                
                            </div>
                            <h4>
                                {{ $user->first_name . " " . $user->last_name }}
                            </h4>
                        </div>
                        {{-- delete button if user is the owner of the post --}}
                        @if (Auth::id() == $user->id)
                        <form method="POST" action="{{ route('deletePost',$post->id)}}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                        @endif

                    </div>
                    <div class="card-body text-justify">
                        {{ $post->content }}
                    </div>
                    <div class="card-footer">
                        
                            <div class="col-auto p-3">
                                <small>
                                    {{ $post->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                </div>
                <h3>Comments</h3>
                <div class="card container">
                    {{-- make comment form --}}
                    <div class="row">

                        <div class="col-auto  p-3">
                            @if (Auth::user()->avatar_path == null)
                            <img class="rounded-circle img-fluid" width="60"
                            src="https://avatars.dicebear.com/api/initials/{{substr(Auth::user()->first_name, 0, 1) . substr(Auth::user()->last_name, 0, 1)}}.svg?backgroundColorLevel=300&fontSize=35"
                            alt="">
                            @else
                            <img class="rounded-circle img-fluid" width="60"
                            src="{{ url('storage/avatars/' . Auth::user()->avatar_path) }}" alt="">
                            @endif
                            
                        </div>
                        <div class="col p-2">
    
                            <form action="{{ route('addComment', $post->id) }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <textarea 
                                    name="content"
                                     id="comment" 
                                     cols="30" 
                                     rows="2" 
                                     class="form-control" 
                                     placeholder="Add Comment"></textarea>  

                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary">Add Comment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- show comments --}}
                @foreach ($comments as $comment)
                <div class="card container">
                    <div class="row">
                        <div class="col-auto  p-3">
                            @if ($comment->user->avatar_path == null)
                            <img class="rounded-circle img-fluid" width="60"
                            src="https://avatars.dicebear.com/api/initials/{{substr($comment->user->first_name, 0, 1) . substr($comment->user->last_name, 0, 1)}}.svg?backgroundColorLevel=300&fontSize=35"
                            alt="">
                            @else
                            <img class="rounded-circle img-fluid" width="60"
                            src="{{ url('storage/avatars/' . $comment->user->avatar_path) }}" alt="">
                            @endif
                            
                        </div>
                        <div class="col p-2">
                            <div class="card-body">
                                <p>
                                    {{ $comment->content }}
                                </p>
                            </div>
                            <div class="card-footer">
                                <div class="col-auto p-3">
                                    {{-- delete button if user is owner of the comment --}}
                                    @if (Auth::user()->id == $comment->user_id)
                                    <form action="{{ route('deleteComment', $comment->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-danger">Delete</button>
                                    </form>
                                    @endif
                                    <small>
                                        {{ $comment->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
        </div>
    </div>


@endsection