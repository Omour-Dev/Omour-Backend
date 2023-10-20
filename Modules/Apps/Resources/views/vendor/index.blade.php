@extends('apps::vendor.layouts.app')
@section('title', __('apps::vendor.index.title'))
@section('content')

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('vendor.home')) }}">
                        {{ __('apps::vendor.index.title') }}
                    </a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"> {{ __('apps::vendor.index.welcome') }} ,
            <small>
                <b style="color:red">
                    {{ auth()->user()->name }}
                </b>
            </small>
        </h1>

    </div>
</div>

@stop
