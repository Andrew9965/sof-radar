@extends('layouts.app')

@section('content')
<div class="page-default__inner">
    @include('sections.soft.soft-header')
    @yield('soft-content')
</div>
@endsection