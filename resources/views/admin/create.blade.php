@extends('layouts.app')

@section('content')
    <h1>Add New Property</h1>

    {!! Form::open(['url' => 'admin', 'files' => true]) !!}

    <div class="form-group">
        {!! Form::label('county') !!}
        {!! Form::text('county') !!}
    </div>

    <div class="form-group">
        {!! Form::label('country') !!}
        {!! Form::text('country') !!}
    </div>

    <div class="form-group">
        {!! Form::label('town') !!}
        {!! Form::text('town') !!}
    </div>

    <div class="form-group">
        {!! Form::label('description') !!}
        {!! Form::textarea('description') !!}
    </div>

    <div class="form-group">
        {!! Form::label('address') !!}
        {!! Form::text('address') !!}
    </div>

    <div class="form-group">
        {!! Form::label('image') !!}
        {!! Form::file('image') !!}
    </div>

    <div class="form-group">
        {!! Form::label('num_bedrooms') !!}
        {!! Form::selectRange('num_bedrooms', 1, 10) !!}
    </div>

    <div class="form-group">
        {!! Form::label('num_bathrooms') !!}
        {!! Form::selectRange('num_bathrooms', 1, 10) !!}
    </div>

    <div class="form-group">
        {!! Form::label('price') !!}
        {!! Form::text('price', null, ['patter'=> '[0-9.]+']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('property_type_id', 'Property Type') !!}
        {!! Form::select('property_type_id', $propertyType) !!}
    </div>

    <div class="form-group">
        {!! Form::label('type', 'Sale/Rent') !!}
        {!! Form::select('type', ['sale' => 'To Sale', 'rent' => 'To Rent']) !!}
    </div>

    {!! Form::submit('Add'); !!}

    {!! Form::close() !!}

    @if(count($errors)>0)
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <ul>
                    {{$error}}
                </ul>
            @endforeach
        </div>
    @endif
@stop
