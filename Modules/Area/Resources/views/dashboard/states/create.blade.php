@extends('apps::dashboard.layouts.app')
@section('title', __('area::dashboard.states.routes.create'))
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('dashboard.states.index')) }}">
                        {{__('area::dashboard.states.routes.index')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('area::dashboard.states.routes.create')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="form" role="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('dashboard.states.store')}}">
                @csrf
                <div class="col-md-12">

                    {{-- RIGHT SIDE --}}
                    <div class="col-md-3">
                        <div class="panel-group accordion scrollable" id="accordion2">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a class="accordion-toggle"></a></h4>
                                </div>
                                <div id="collapse_2_1" class="panel-collapse in">
                                    <div class="panel-body">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li class="active">
                                                <a href="#general" data-toggle="tab">
                                                    {{ __('area::dashboard.states.form.tabs.general') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- PAGE CONTENT --}}
                    <div class="col-md-9">
                        <div class="tab-content">

                            {{-- CREATE FORM --}}
                            <div class="tab-pane active fade in" id="general">
                                <h3 class="page-title">{{__('area::dashboard.states.form.tabs.general')}}</h3>
                                <div class="col-md-10">

                                    <div class="tabbable">
                                        <ul class="nav nav-tabs bg-slate nav-tabs-component">
                                            @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
                                            <li class=" {{ ($code == locale()) ? 'active' : '' }}">
                                                <a href="#colored-rounded-tab-general-{{$code}}" data-toggle="tab" aria-expanded="false"> {{ $lang['native'] }}
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <div class="tab-content">
                                        @foreach (config('laravellocalization.supportedLocales') as $code => $lang)
                                        <div class="tab-pane fade in {{ ($code == locale()) ? 'active' : '' }}" id="colored-rounded-tab-general-{{$code}}">
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('area::dashboard.states.form.title')}}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="title[{{$code}}]" class="form-control" data-name="title.{{$code}}" {{ (is_rtl($code) == 'rtl') ? 'dir=rtl' : '' }}>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('area::dashboard.states.form.cities')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="city_id" id="single" class="form-control select2">
                                                <option value=""></option>
                                                @foreach ($cities as $city)
                                                <option value="{{ $city['id'] }}">
                                                    {{ $city->translate(locale())->title }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('area::dashboard.states.form.status')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="status">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- PAGE ACTION --}}
                            <div class="col-md-12">
                                <div class="form-actions">
                                    @include('apps::dashboard.layouts._ajax-msg')
                                    <div class="form-group">
                                        <button type="submit" id="submit" class="btn btn-lg blue">
                                            {{__('apps::dashboard.buttons.add')}}
                                        </button>
                                        <a href="{{url(route('dashboard.states.index')) }}" class="btn btn-lg red">
                                            {{__('apps::dashboard.buttons.back')}}
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
