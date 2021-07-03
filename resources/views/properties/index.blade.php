@extends('layouts.master')

@section('content')
<div class="container">
@include('properties.parts.form-filter')
    <div class="row">
        <table>
            <thead>
                <tr>
                    <th>County</th>
                    <th style="width: 13%;">Country</th>
                    <th>Town</th>
                    <th style="width: 25%;">Address</th>
                    <th>Bedrooms / Bathrooms</th>
                    <th>Price</th>
                    <th>Type</th>
                    <th style="width: 8%;">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($properties as $property)
                <tr>
                    <td>{{ $property->county }}</td>
                    <td>{{ $property->country }}</td>
                    <td>{{ $property->town }}</td>
                    <td>{{ $property->address }}</td>
                    <td>{{ $property->num_bedrooms }} / {{ $property->num_bathrooms }}</td>
                    <td>{{ $property->price }}</td>
                    <td>{{ $property->property_types->title }}</td>
                    <td><form action="{{route('properties.destroy',[$property->uuid])}}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit">Delete</button>               
                    </form>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection