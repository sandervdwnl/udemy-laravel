@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $user->name }}</div>
                    <div class="card-body">
                        <b>{{ $user->name }}</b>
                        <p>{{ $user->motto }}</p>
                        <p>{{ $user->about_me }}</p>
                        <p>
                        {{-- @foreach ($hobby->tags as $tag)
                            <a href=""><span class="badge badge-{{ $tag->style }}">{{ $tag->name }}</span></a>
                        @endforeach --}}
                        </p>
                    </div>
            </div>

            {{-- Link naar create --}}
            <div class="mt-2">
                {{-- Link naar vorige pagina --}}
                <a href="{{ URL::previous() }}" class="btn btn-success btn-sm">
                    <li class="primary fas fa-arrow-up"></li>
                    Back to overview
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
