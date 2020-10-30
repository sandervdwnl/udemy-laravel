@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Hobbies:</div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($hobbies as $hobby)
                                <li class="list-group-item">
                                <a title="Show Details" href="/hobby/{{ $hobby->id }}">{{ $hobby->name }}</a>
                                <a href="/hobby/{{ $hobby->id }}/edit" class="btn btn-outline-secondary btn-sm mt-2"><i class="fas fa-edit">Edit</i></a>

                                {{-- Delete form to initiate function --}}
                                <form action="/hobby/{{ $hobby->id }}" method="POST" class="float-right" style="display: inline;">
                                    @csrf
                                    @method('delete')
                                    <input type="submit" value="Delete" class="btn btn-sm btn-outline-danger">
                                    </form>

                                </li>

                            @endforeach
                        </ul>
                    </div>
            </div>

            {{-- Link naar create --}}
            <div class="mt-2">
                <a href="/hobby/create" class="btn btn-success btn-sm">
                    <li class="fas fa-plus-circle"></li>
                    Create new hobby
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
