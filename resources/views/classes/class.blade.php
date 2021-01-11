@extends('layouts.app')
@section('title', $class->longname)
@section('content')
<div class="container">
    <div class="row">

        <div class="col-9">
            <div class="h2 text-danger">{{ ucfirst($class->getTable()) }}: {{ $class->name }}</div>
            <div class="h3 text-info">{{$class->longname }}</div>
@markdown
{!! $class->description !!}
@endmarkdown
            <hr>
            <h3>Constructor:</h3>
            @php
                $classConstructor = resolve('get_params_format')($params)
            @endphp
            <x-member-card
                class="border-bottom border-danger mt-1 pt-2 pb-4"
                name="new {{ $class->name }}({{$classConstructor}})"
                :params=$params
                since="{{$class->since}}"
                metaFileRoute="{{$class->metapath}}/{{$class->metafilename}}"
                metalineno="{{$class->metalineno}}"
            />

            @if (!empty($extends) AND count($extends))
            <h3 class="mt-4">Extends</h3>
            <ul>
                @foreach ($extends as $extend)
                <li><a href="/{{Config::get('app.phaser_version')}}/{{$extend->object}}">{{$extend->object}}</a></li>
                @endforeach
            </ul>
            <hr>
            @endif
            @if ((!empty($members) AND count($members)) OR (!empty($membersConstants) AND count($membersConstants)))
                <h3 class="mt-4">Members</h3>
                @foreach ($membersConstants as $memberConstant)
                        <x-member-card
                            class="border-bottom border-danger mt-2 pt-2 pb-4"
                            name="{{$memberConstant->name}}"
                            :description="$memberConstant->description"
                            kind="constant"
                            :types="$memberConstant"
                            since="{{$memberConstant->since}}"
                            metaFileRoute="{{$memberConstant->metapath}}/{{$memberConstant->metafilename}}"
                            metalineno="{{$memberConstant->metalineno}}"
                            defaultValue="{{$memberConstant->defaultValue}}"
                            returnsdescription="{{$memberConstant->returnsdescription}}"
                            overrides="{{$memberConstant->overrides}}"
                            inherits="{{$memberConstant->inherits}}"
                            readOnly="{{$memberConstant->readOnly}}"
                            nullable="{{$memberConstant->nullable}}"

                        />
                    @endforeach
                    @foreach ($members as $member)
                        <x-member-card
                            class="border-bottom border-danger mt-2 pt-2 pb-4"
                            name="{{$member->name}}"
                            :description="$member->description"
                            kind="member"
                            :types="$member"
                            since="{{$member->since}}"
                            metaFileRoute="{{$member->metapath}}/{{$member->metafilename}}"
                            metalineno="{{$member->metalineno}}"
                            defaultValue="{{$member->defaultValue}}"
                            returnsdescription="{{$member->returnsdescription}}"
                            overrides="{{$member->overrides}}"
                            inherits="{{$member->inherits}}"
                            readOnly="{{$member->readOnly}}"
                            nullable="{{$member->nullable}}"
                            scope="{{$member->scope}}"

                        />
                    @endforeach
                <hr>
            @endif
            @if (!empty($methods) AND count($methods))
                <h3>Methods</h3>
                    @foreach ($methods as $method)
                    @php
                    echo $method->longname;

                    // if($method->longname == "Phaser.GameObjects.GameObjectFactory#image") {
                    //     dd($method);
                    // }

                    $methodConstructor = resolve('get_params_format')($method->params->all())
                    @endphp
                    <x-member-card
                        class="border-bottom border-danger mt-1 pt-2 pb-4"
                        name="{{$method->name}}({{$methodConstructor}})"
                        scope="{{$method->scope}}"
                        :description="$method->description"
                        :params="$method->params->all()"
                        since="{{$method->since}}"
                        metaFileRoute="{{$method->metapath}}/{{$method->metafilename}}"
                        metalineno="{{$method->metalineno}}"
                        fires="{{$method->fires}}"
                        inherits="{{$method->inherits}}"
                        returnstype="{{$method->returnstype}}"
                        returnsdescription="{{$method->returnsdescription}}"
                    />

                    @endforeach
                {{-- <hr> --}}
            @endif
        </div>
        <div class="col-3">
            {{-- Aside --}}
        </div>
    </div>
</div>
@endsection
