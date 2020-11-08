@extends('layout.default')

@section('content')

          {{Form::open(['url' => URL::route('postUpdateVehicle'), 'id'=>'edit_vehicle_form'])}}

          {{ Form::label('Vehicle Number Plate: ') }}
          {{ Form::text('plateNumber_edit', $data->plateNumber, ['class'=>'form-control', 'id'=>'plateNumber_edit']) }}
            @if($errors->has('plateNumber_edit'))
              <p style="color:red;">{{ $errors->first('plateNumber_edit') }}</p>
            @endif
            <br>
            {{ Form::label('Vehicle Capacity: ') }}
          {{ Form::text('capacity_edit', $data->capacity, ['class'=>'form-control', 'id'=>'capacity_edit']) }}
            @if($errors->has('capacity_edit'))
              <p style="color:red;">{{ $errors->first('capacity_edit') }}</p>
            @endif

            {{ Form::hidden('id_edit', $data->id, ['class'=>'form-control', 'id'=>'id_edit','readonly']) }}

            <p>{{ Form::submit('Edit') }}
            {{ Form::close() }}

@stop
