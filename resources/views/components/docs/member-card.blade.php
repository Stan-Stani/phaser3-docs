<div {{ $attributes->merge([
    'class' => ( ((!empty($access)) ? 'private hide-card' : '') .' '. ((!empty($inherits)) ? 'inherited' : ''))
]) }}>
    {{ $access}}
    @php
        $param_join = resolve('get_params_format')($params);
    @endphp
    @if (!empty($name))
        <div class="d-flex justify-content-between">
            <div class="h4 text-danger" id="{{ $id }}">
                @if ($scope == "static" || $scope == "protected" || $scope == "readonly" || $kind == "constant" || $nullable == "1" )
                    @php
                        $scope_out = '';
                        if ($scope == 'static') {
                            $scope_out .= 'static';
                        }

                        if ($scope == 'protected') {
                            if (!empty($scope_out)) {
                                $scope_out .= ', ';
                            }
                            $scope_out .= 'protected';
                        }

                        if ($scope == 'readonly') {
                            if (!empty($scope_out)) {
                                $scope_out .= ', ';
                            }
                            $scope_out .= 'readonly';
                        }

                        if ($kind == 'constant') {
                            if (!empty($scope_out)) {
                                $scope_out .= ', ';
                            }
                            $scope_out .= 'constant';
                        }

                        if ($nullable == "1" ) {
                            if (!empty($scope_out)) {
                                $scope_out .= ', ';
                            }
                            $scope_out .= 'nullable';
                        }
                    @endphp
                    {{"<".$scope_out.">"}}
                @endif
                {{-- set access --}}
                @if(!empty($access))
                    {{ "<$access>" }}

                @endif
                @if ($kind === "typedef")
                    @if (strtolower($type) == 'function')
                        {{($scope == "static") ? "<static>" : "" }} {{ htmlspecialchars_decode($name) }}({{$param_join}})
                    @elseif (strtolower($type) == 'object')
                        {{($scope == "static") ? "<static>" : "" }} {{ htmlspecialchars_decode($name) }}
                    @endif
                @else
                    {{-- Name of card --}}
                    {!! $name !!}
                @endif
                @if ($kind === "constant" || $kind === "member")
                    :{!! resolve('get_types')($types) !!}
                @endif
            </div>
            @if($focus)
            <div class="d-flex">
                <div class="me-2 align-middle">
                    <a href="focus/{{$longname}}"><img src="{{asset('images/aim.png')}}" alt="Focus"></a>
                </div>
                <div class="copy-members-to-clipboard">
                    <a href="#{{$shortname}}"><img src="{{asset('images/hashtag.png')}}" alt="Focus" width="30" id="{{url()->to('')}}/{{Config::get('app.phaser_version')}}/focus/{{$longname}}"></a>
                </div>
            </div>
            @endif
        </div>
    @endif
    @if (!empty($description))
    <div class="border-top pt-2 mt-2">
        <h4>Description:</h4>
@markdown
{!! $description !!}
@endmarkdown
    </div>
    @endif
    @if (!empty($type))
    <div>
        <span class="font-weight-bold">Type:</span> <span class="text-danger">{!! resolve('get_api_link')($type) !!}</span>
    </div>
    @endif
    @if (count($properties) > 0)
    <h5>
        Properties:
    </h5>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                    @foreach ($create_table_params_properties as $key => $value)
                        @if($value)
                            @if($key == 'defaultValue')
                                <th scope="col">Default</th>
                            @else
                                <th scope="col">{{ ucfirst($key) }}</th>
                            @endif
                        @endif
                    @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($properties as $property)
            <tr>
                {{-- Name --}}
                @if ($create_table_params_properties()['name'])
                    <th scope="row">{{ $property->name }}</th>
                @endif
                {{-- Type --}}
                @if ($create_table_params_properties()['type'])
                <td>
                    {{-- <ul>
                    @foreach (explode('|', resolve('get_types')($property)) as $item )
                        <li>
                            {!! $item !!}
                        </li>
                    @endforeach
                    </ul> --}}
                    {!! resolve('get_types')($property) !!}
                </td>
                @endif
                {{-- Arguments --}}
                @if ($create_table_params_properties()['arguments'])
                <td>
                    @if ($property->optional == 1)
                    {{"<optional>"}}
                    @endif
                </td>
                @endif
                {{-- Default --}}
                @if ($create_table_params_properties()['defaultValue'])
                    <td>{{$property->defaultValue}}</td>
                @endif
                @if ($create_table_params_properties()['description'])
                {{-- Description --}}
                <td>
@markdown
{!! $property->description !!}
@endmarkdown
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    @if (count($params) > 0)
        <h4>
            Parameters:
        </h4>
        <table class="table table-light table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    @foreach ($create_table_params_properties as $key => $value)
                        @if ($value)
                            @if ($key == 'defaultValue')
                                <th scope="col">Default</th>
                            @else
                                <th scope="col">{{ ucfirst($key) }}</th>
                            @endif
                        @endif
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($params as $param)
                <tr>
                    {{-- Name --}}
                    @if ($create_table_params_properties()['name'])
                        <th scope="row" class="font-monospace">{{ $param->name }}</th>
                    @endif
                    {{-- Type --}}
                    @if ($create_table_params_properties()['type'])
                        <td>
                            {{-- <ul>
                                @foreach (explode('|', resolve('get_types')($param)) as $item )
                                    <li>
                                        {!! $item !!}
                                    </li>
                                @endforeach
                            </ul> --}}
                            {!! resolve('get_types')($param) !!}
                        </td>
                    @endif
                    {{-- Arguments --}}
                    @if ($create_table_params_properties()['arguments'])
                        <td>
                            @if ($param->optional == 1)
                            {{"<optional>"}}
                            @endif
                        </td>
                    @endif
                    {{-- Default --}}
                    @if ($create_table_params_properties()['defaultValue'])
                        <td>{{$param->defaultValue}}</td>
                    @endif
                    {{-- Description --}}
                    @if ($create_table_params_properties()['description'])
                        <td>
@markdown
{!! $param->description !!}
@endmarkdown
                        </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if(!empty($returnsdescription))
    <div class="ps-3">
        <h4>Returns:</h4>
        <div class="ps-4">
            @markdown
{!! $returnsdescription !!}
            @endmarkdown
        </div>
    </div>
    @endif
    @if(!empty($returnstype))
    <div class="ps-3">
        <h4>Type:</h4>
        <div class="ps-4">
            <ul>
                @foreach (explode('|', $returnstype) as $returntype)
                    <li>
                        {!! resolve('get_api_link')($returntype) !!}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
                        {{-- @php
                    if($member->name == 'cameraFilter') {
                        dd($member->name );
                    }
                @endphp --}}
    @if (!empty($defaultValue) || $defaultValue == "0")
    <div>
        <span class="font-weight-bold">Default:</span><span class="text-danger"> {{ $defaultValue }}</span>
    </div>
    @endif
    @if(!empty($inherits))
    <div>Inherited from: {!! resolve('get_api_link')($inherits) !!}</div>
    @endif
    @if(!empty($overrides))
    <div>Overrides:  {!! resolve('get_api_link')($overrides) !!}</div>
    @endif
    @if(!empty($fires))
    <div class="ps-4">
        <h4>Fires:</h4>
        <ul>
            @foreach (explode(',', $fires) as $fire)
                <li>{!! resolve('get_api_link')($fire) !!}</li>
            @endforeach
        </ul>
    </div>
    {{-- <div>Fires: {!! '<br />-'. implode('<br />-', explode(',', resolve('get_api_link')($fires))) !!}</div> --}}
    @endif

    @if(!empty($examples))
    <div>
        <span class="font-weight-bold">Examples:</span>
        <ul>

            @foreach ($examples as $example)
                <li>

@markdown
```javascript
{{$example->example}}
```
@endmarkdown
                </li>
            @endforeach
        </ul>
    </div>
    {{-- <div>Fires: {!! '<br />-'. implode('<br />-', explode(',', resolve('get_api_link')($fires))) !!}</div> --}}
    @endif

    <div class="border-top mt-2 pt-2">
        <div><span class="font-weight-bold">Since:</span> <span class="text-danger">{{ $since }}</span></div>
        <x-source-links metaFileRoute={{$metaFileRoute}} metalineno={{$metalineno}}/>
    </div>
</div>