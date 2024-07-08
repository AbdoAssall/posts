@extends('layouts.app')

@section('title') edit @endsection

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{route('posts.update', $post->id)}}">
  @csrf
  @method('PUT')
  <div class="mb-3">
    <label class="form-label">Title</label>
    <input name="title" type="text" value="{{$post->title}}" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">Decription</label>
    <textarea name="description" class="form-control" rows="3">{{$post->description}}</textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Post Create</label>
    <select name="post_creater" class="form-control">
      @foreach ($users as $user)
      <!-- <option @selected($post->user_id == $user->id) value="{{$user->id}}">{{$user->name}}</option> -->
      <option @if($user->id == $post->user_id) selected @endif value="{{$user->id}}">{{$user->name}}</option>
    @endforeach
    </select>
  </div>

  <button class="btn btn-primary">Update</button>
</form>

@endsection