@extends('layouts.app')

@section('title', 'Home - Portfolio')

@section('content')
    <h1>Welcome</h1>
    <p>This is the home page.</p>
@endsection

@push('scripts')
    <script>console.log('home loaded');</script>
@endpush
