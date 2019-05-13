@extends('layouts.app')

@section('content')
    <div class="page-default__inner">

        <div class="breadcrumbs ">
            <div class="container">
                <div class="breadcrumbs-inner">
                    <a href="{{route('page', ['page' => $page->uri])}}">{{$page->name}}</a>
                </div>
            </div>
        </div>

        <div class="container section__body">
            @include('sections.page_template', ['page' => $page])
        </div>
    </div>
@endsection