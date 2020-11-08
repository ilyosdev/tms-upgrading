@extends('layout.default')

@section('content')
    {{Form::open(['url'=>URL::route('postCreateVehicle'),'id'=>'add_vehicle_form'])}}

    {{ Form::label('Vehicle Number Plate: ') }}
    {{ Form::text('plateNumber', old('plateNumber'), ['class'=>'form-control', 'id'=>'numberPlate']) }}
    @if($errors->has('plateNumber'))
        <p style="color:red;">{{ $errors->first('plateNumber') }}</p>
    @endif
    <br>
    {{ Form::label('Vehicle Capacity: ') }}
    {{ Form::text('capacity', old('capacity'), ['class'=>'form-control', 'id'=>'capacity']) }}
    @if($errors->has('capacity'))
        <p style="color:red;">{{ $errors->first('capacity') }}</p>
    @endif
    <br>
    <p>{{ Form::submit('Save') }}
    {{ Form::close()}}
@stop
