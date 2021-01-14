@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tag:</div>
                    <div class="card-body">
                            
                        {{-- Info for update() --}}
                        <form action="/hobby/{{ $hobby->id }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="Name">Name:</label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'border-danger' : '' }}" name="name" id="name" value="{{ old('name') ?? $hobby->name }}">
                                <small class="form-text text-danger">{!! $errors->first('name') !!}</small>
                            </div>
                            {{-- Preview --}}
                            <div class="mb-2">
                                @if (file_exists('img/hobbies/' . $hobby->id . '_large.jpg'))
                                    <div class="preview">
                                    <img style="max-width:400px;max-height:300px;" src="/hobbies/{{$hobby->id}}_large.jpg" alt="">
                                    </div>
                                @endif
                                <a class="btn btn-danger" href="/delete-images/hobby/{{$hobby->id}}">Delete image</a>
                            </div>
                            <div class="form-group">
                                <label for="Description">Description:</label>
                                <textarea class="form-control {{ $errors->has('description') ? 'border-danger' : '' }}" name="description" id="description" rows="10">{{old('description') ?? $hobby->description }}</textarea>
                                <small class="form-text text-danger">{!! $errors->first('description') !!}</small>
                            </div>
                            <div class="form-group">
                                <label for="Image">Image:</label>
                                <input type="file" class="form-control {{ $errors->has('image') ? 'border-danger' : '' }}" name="image" id="image" value="{{old('image')}}">
                                <small class="form-text text-danger">{!! $errors->first('image') !!}</small>
                            </div>

                            <input class="btn btn-primary float-left" type="submit" value="Save Hobby">
                        </form>    

                        <a href="/hobby" class="btn btn-primary float-right">
                        <i class="fas fa-arrow-circle-up"></i>
                        Back
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
