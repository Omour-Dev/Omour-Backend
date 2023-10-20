@extends('apps::dashboard.layouts.app')
@section('title', __('vendor::dashboard.vendor_statuses.update.title'))
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
                    <a href="{{ url(route('dashboard.vendor_statuses.index')) }}">
                        {{__('vendor::dashboard.vendor_statuses.index.title')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('vendor::dashboard.vendor_statuses.update.title')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="updateForm" user="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('dashboard.vendor_statuses.update',$vendorStatus->id)}}">
                @csrf
                @method('PUT')
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
                                                <a href="#global_setting" data-toggle="tab">
                                                    {{ __('vendor::dashboard.vendor_statuses.update.form.general') }}
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

                            {{-- UPDATE FORM --}}
                            <div class="tab-pane active fade in" id="global_setting">
                                <h3 class="page-title">{{__('vendor::dashboard.vendor_statuses.update.form.general')}}</h3>
                                <div class="col-md-10">

                                    @foreach (config('translatable.locales') as $code)
                                      <div class="form-group">
                                          <label class="col-md-2">
                                              {{__('vendor::dashboard.vendor_statuses.update.form.title')}} - {{ $code }}
                                          </label>
                                          <div class="col-md-9">
                                              <input type="text" name="title[{{$code}}]" class="form-control" data-name="title.{{$code}}" value="{{ $vendorStatus->translate($code)->title }}">
                                              <div class="help-block"></div>
                                          </div>
                                      </div>
                                    @endforeach

                                    <div class="form-group">
                                        <label class="col-md-2">
                                          {{__('vendor::dashboard.vendor_statuses.create.form.label_color')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="label_color" id="single" class="form-control select2-allow-clear">
                                                <option value=""></option>
                                                <option value="success" @if ($vendorStatus->label_color == "success")
                                                  selected
                                                @endif>  Green - Success </option>
                                                <option value="danger" @if ($vendorStatus->label_color == "danger")
                                                  selected
                                                @endif> Red - Danger </option>
                                                <option value="warning" @if ($vendorStatus->label_color == "warning")
                                                  selected
                                                @endif> Yellow - Warning </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('vendor::dashboard.vendor_statuses.create.form.accepted_orders')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="accepted_orders" {{($vendorStatus->accepted_orders == 1) ? ' checked="" ' : ''}}>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            {{-- END UPDATE FORM --}}
                        </div>
                    </div>

                    {{-- PAGE ACTION --}}
                    <div class="col-md-12">
                        <div class="form-actions">
                            @include('apps::dashboard.layouts._ajax-msg')
                            <div class="form-group">
                                <button type="submit" id="submit" class="btn btn-lg green">
                                    {{__('apps::dashboard.buttons.edit')}}
                                </button>
                                <a href="{{url(route('dashboard.vendor_statuses.index')) }}" class="btn btn-lg red">
                                    {{__('apps::dashboard.buttons.back')}}
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@stop
