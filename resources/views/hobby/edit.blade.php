@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tag:</div>
                    <div class="card-body">
                            
                        {{-- Info for update() --}}
                        <form action="/hobby/{{ $hobby->id }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="Name">Name:</label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'border-danger' : '' }}" name="name" id="name" value="{{ $hobby->name ?? old('name')}}">
                                <small class="form-text text-danger">{!! $errors->first('name') !!}</small>
                            </div>
                            <div class="form-group">
                                <label for="Description">Description:</label>
                                <textarea class="form-control {{ $errors->has('description') ? 'border-danger' : '' }}" name="description" id="description" rows="10">{{ $hobby->description ?? old('description')}}</textarea>
                                <small class="form-text text-danger">{!! $errors->first('description') !!}</small>
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
