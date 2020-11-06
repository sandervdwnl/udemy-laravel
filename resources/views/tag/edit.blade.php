@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tags:</div>
                    <div class="card-body">
                            
                        {{-- Info for update() --}}
                        <form action="/tag/{{ $tag->id }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="Name">Name:</label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'border-danger' : '' }}" name="name" id="name" value="{{ old('name') ?? $tag->name }}">
                                <small class="form-text text-danger">{!! $errors->first('name') !!}</small>
                            </div>
                            <div class="form-group">
                                <label for="style">Style:</label>
                                <input type="text" class="form-control {{ $errors->has('style') ? 'border-danger' : '' }}" name="style" id="style" value="{{ old('style') ?? $tag->style }}">
                                <small class="form-text text-danger">{!! $errors->first('style') !!}</small>
                            </div>

                            <input class="btn btn-primary float-left" type="submit" value="Save Tag">
                        </form>    

                        <a href="/tag" class="btn btn-primary float-right">
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
