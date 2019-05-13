@extends('layouts.app')

@section('content')
    <style>
        @media (max-width: 1249px) {
            .filter__header {
                display: block
            }
        }
    </style>
    <div class="page-default__inner">
        <div class="container section__body" style="padding-top: 10px;">
            <span id="cabinet_app">
                <img src="{{asset('spinner.gif')}}" style="margin: 0 auto; display: flex;"/>
                <h3 style="text-align: center;">Building...</h3>
            </span>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    window.user = {!! json_encode(Auth::user()->toArray()) !!};
</script>

{!! include_vue_scripts('app') !!}

@endpush