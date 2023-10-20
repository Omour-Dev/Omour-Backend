@extends('apps::dashboard.layouts.app')
@section('title', __('apps::dashboard.index.title'))
@section('content')

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('dashboard.home')) }}">
                        {{ __('apps::dashboard.index.title') }}
                    </a>
                </li>
            </ul>
        </div>
        <h1 class="page-title"> {{ __('apps::dashboard.index.welcome') }} ,
            <small><b style="color:red">{{ Auth::user()->name }} </b></small>
        </h1>

    </div>
</div>

@stop
