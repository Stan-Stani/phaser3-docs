@extends('layouts.app')
@section('title', $constant->longname)
@section('content')
<div class="container">
    <div class="row">
        {{-- Show namespace properties Name, methods--}}
        <div class="col-9">
            <div class="h2 text-danger">{{ ucfirst($constant->getTable()) }}: {{ $constant->name }}</div>
            <div class="h3 text-info">{{$constant->longname }}</div>
            <x-member-card
                class="border-bottom border-danger mt-0 pt-0 pb-4 "
                scope="{{$constant->scope}}"
                :description="$constant->description"
                :type="$constant->type"
                since="{{$constant->since}}"
                metaFileRoute="{{$constant->metapath}}/{{$constant->metafilename}}"
                metalineno="{{$constant->metalineno}}"
                {{-- :returnstype="$method->returnstype" --}}
                {{-- returnsdescription="{{$method->returnsdescription}}" --}}
            />
        </div>
        <div class="col-3">
            Aside
        </div>

    </div>
</div>
@endsection
