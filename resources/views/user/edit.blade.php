@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tag:</div>
                    <div class="card-body">
                            
                        {{-- Info for update() --}}
                        <form action="/user/{{ $user->id }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="Motto">Motto:</label>
                                <input type="text" class="form-control {{ $errors->has('motto') ? 'border-danger' : '' }}" name="motto" id="motto" value="{{ old('motto') ?? $user->motto }}">
                                <small class="form-text text-danger">{!! $errors->first('motto') !!}</small>
                            </div>
                            {{-- Preview --}}
                            <div class="mb-2">
                                @if (file_exists('img/users/' . $user->id . '_large.jpg'))
                                    <div class="preview mb-2">
                                    <img style="max-width:400px;max-height:300px;" src="/img/users/{{$user->id}}_large.jpg" alt="">
                                    </div>
                                @endif
                                <a class="btn btn-danger" href="/delete-images/user/{{$user->id}}">Delete image</a>
                            </div>
                            <div class="form-group">
                                <label for="About Me">About Me:</label>
                                <textarea class="form-control" name="about_me" id="about_me" rows="10">{{old('about_me') ?? $user->about_me }}</textarea>
                                
                            </div>
                            <div class="form-group">
                                <label for="Image">Image:</label>
                                <input type="file" class="form-control {{ $errors->has('image') ? 'border-danger' : '' }}" name="image" id="image" value="{{old('image')}}">
                                <small class="form-text text-danger">{!! $errors->first('image') !!}</small>
                            </div>

                            <input class="btn btn-primary float-left" type="submit" value="Save Profile">
                        </form>    

                        <a href="/home" class="btn btn-primary float-right">
                        <i class="fas fa-arrow-circle-up"></i>
                        Back to home
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
