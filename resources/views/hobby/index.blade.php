@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                @isset($filter)
                <div class="card-header">Filtered Hobbies For This Tag:</div>
                {{-- $filter is instance van Tag en heeft toegang tot zijn properties --}}
                <span class="badge badge-{{ $filter->style }}">{{$filter->name}}</span>
                {{-- backlink --}}
                <span class="float-right"><a href="/hobby">Show all hobbies</a></span>
                @endisset

                <div class="card-header">Hobbies:</div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($hobbies as $hobby)
                                <li class="list-group-item">
                                    {{-- Hobby naam --}}
                                <a title="Show Details" href="/hobby/{{ $hobby->id }}">{{ $hobby->name }}</a>
                                {{-- Edit btn --}}
                                @auth
                                <a href="/hobby/{{ $hobby->id }}/edit" class="btn btn-outline-secondary btn-sm mt-2"><i class="fas fa-edit">Edit</i></a>
                                @endauth

                                {{-- Naam van creator(user) --}}
                                <span class="mx-2">Posted by: <a href="user/{{$hobby->user->id}}"> {{ $hobby->user->name }} </a></span>
                                {{-- Totale hobbies welke deze user heeft aangemaakt --}}
                                <span>Hobbies({{ $hobby->user->hobbies->count() }})</span>

                                {{-- Delete form to initiate function --}}
                                @auth
                                <form action="/hobby/{{ $hobby->id }}" method="POST" class="float-right" style="display: inline;">
                                    @csrf
                                    @method('delete')
                                    <input type="submit" value="Delete" class="btn btn-sm btn-outline-danger">
                                    </form>
                                    @endauth
                                    {{-- Aanmaakdatum --}}
                                    {{-- diffForHumans is ex Carbon library, maakt van datum bijv. 5 days ago --}}
                                <span class="float-right mx-2">{{ $hobby->created_at->diffForHumans() }}</span>
                                <br>
                                {{-- Tags van toepassing op de hobby --}}
                                @foreach ($hobby->tags as $tag)
                                <a href="/hobby/tag/{{ $tag->id }}"><span class="badge badge-{{ $tag->style }}">{{ $tag->name }}</span></a>
                                @endforeach
                                </li>
                            @endforeach
                        </ul>
                    </div>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $hobbies->links() }}
            </div>

            {{-- Link naar create --}}
            @auth
            <div class="mt-2">
                <a href="/hobby/create" class="btn btn-success btn-sm">
                    <li class="fas fa-plus-circle"></li>
                    Create new hobby
                </a>
            </div>
            @endauth
        </div>
    </div>
</div>
@endsection
