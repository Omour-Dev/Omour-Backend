@extends('apps::dashboard.layouts.app')
@section('title', __('vendor::dashboard.vendors.create.title'))
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
                    <a href="{{ url(route('dashboard.vendors.index')) }}">
                        {{__('vendor::dashboard.vendors.index.title')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('vendor::dashboard.vendors.create.title')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="form" role="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('dashboard.vendors.store')}}">
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
                                                <a href="#global_setting" data-toggle="tab">
                                                    {{ __('vendor::dashboard.vendors.create.form.general') }}
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="#gallery" data-toggle="tab">
                                                    {{ __('product::dashboard.products.form.tabs.gallery') }}
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
                            <div class="tab-pane active fade in" id="global_setting">
                                <h3 class="page-title">{{__('vendor::dashboard.vendors.create.form.general')}}</h3>
                                <div class="col-md-10">
                                    @foreach (config('translatable.locales') as $code)
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('vendor::dashboard.vendors.create.form.title')}} - {{ $code }}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="title[{{$code}}]" class="form-control" data-name="title.{{$code}}">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @foreach (config('translatable.locales') as $code)
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('vendor::dashboard.vendors.create.form.description')}} - {{ $code }}
                                        </label>
                                        <div class="col-md-9">
                                            <textarea name="description[{{$code}}]" rows="8" cols="80" class="form-control {{is_rtl($code)}}Editor" data-name="description.{{$code}}"></textarea>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    @endforeach

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('vendor::dashboard.vendors.create.form.sellers')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="sellers[]" id="single" class="form-control select2-allow-clear" multiple>
                                                <option value=""></option>
                                                @foreach ($sellers as $seller)
                                                <option value="{{ $seller['id'] }}">
                                                    {{ $seller->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('vendor::dashboard.vendors.create.form.delivery_time')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="delivery_time" class="form-control" data-name="delivery_time">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('vendor::dashboard.vendors.create.form.vendor_statuses')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="vendor_status_id" id="single" class="form-control select2-allow-clear">
                                                <option value=""></option>
                                                @foreach ($vendorStatuses as $vendorStatus)
                                                <option value="{{ $vendorStatus['id'] }}">
                                                    {{ $vendorStatus->translate(locale())->title }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('vendor::dashboard.vendors.create.form.areas')}}
                                        </label>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{-- {{__('vendor::dashboard.vendors.create.form.shipping_prices')}} --}}
                                            </label>
                                            <div class="col-md-9">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __('Area') }}</th>
                                                            <th>{{ __('Shipping Price') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($states as $state)
                                                            @foreach ($state->areas as $area)
                                                                <tr>
                                                                    <td>{{ $area->translate(locale())->title }}</td>
                                                                    <td>
                                                                        <input type="text" name="shipping_prices[{{ $area['id'] }}][area_id]" value="{{ $area['id'] }}" style="display:none;">
                                                                        <input type="text" name="shipping_prices[{{ $area['id'] }}][price]" class="form-control" data-name="shipping_prices[{{ $area['id'] }}][price]">
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="help-block"></div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group">
                                        <label class="col-md-2">
                                              {{__('vendor::dashboard.vendors.create.form.workers')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="worker_id[]" id="single" class="form-control select2-allow-clear" multiple>
                                                <option value=""></option>
                                                @foreach ($workers as $worker)
                                                <option value="{{ $worker['id'] }}">
                                                    {{ $worker['name'] }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('vendor::dashboard.vendors.create.form.sections')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="section_id[]" id="single" class="form-control select2-allow-clear" multiple>
                                                <option value=""></option>
                                                @foreach ($sections as $section)
                                                <option value="{{ $section['id'] }}">
                                                    {{ $section->translate(locale())->title }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('vendor::dashboard.vendors.create.form.image')}}
                                        </label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <a data-input="image" data-preview="holder" class="btn btn-primary lfm">
                                                        <i class="fa fa-picture-o"></i>
                                                        {{__('apps::dashboard.buttons.upload')}}
                                                    </a>
                                                </span>
                                                <input name="image" class="form-control image" type="text" readonly>
                                                <span class="input-group-btn">
                                                    <a data-input="image" data-preview="holder" class="btn btn-danger delete">
                                                        <i class="glyphicon glyphicon-remove"></i>
                                                    </a>
                                                </span>
                                            </div>
                                            <span class="holder" style="margin-top:15px;max-height:100px;">
                                            </span>
                                            <input type="hidden" data-name="image">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('vendor::dashboard.vendors.create.form.status')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="status">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane fade in" id="gallery">
                                <h3 class="page-title">{{__('product::dashboard.products.form.tabs.gallery')}}</h3>
                                <div class="col-md-10">
                                    <div class="galleryForm">

                                        <div class="form-group">
                                            <label class="col-md-2">
                                                {{__('product::dashboard.products.form.image')}}
                                            </label>
                                            <div class="input-group col-md-9">
                                                <span class="input-group-btn">
                                                    <a data-input="images" data-preview="holder" class="btn btn-primary lfm">
                                                        <i class="fa fa-picture-o"></i>
                                                        {{__('apps::dashboard.buttons.upload')}}
                                                    </a>
                                                </span>
                                                <input name="images[]" class="form-control images" type="text" readonly>
                                                <span class="input-group-btn">
                                                    <a data-input="images" data-preview="holder" class="btn btn-danger delete-gallery">
                                                        <i class="glyphicon glyphicon-remove"></i>
                                                    </a>
                                                </span>
                                            </div>
                                            <span class="holder" style="margin-top:15px;max-height:100px;"></span>
                                        </div>


                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn green btn-lg mt-ladda-btn ladda-button btn-circle btn-outline addGallery" data-style="slide-down" data-spinner-color="#333">
                                            <span class="ladda-label">
                                                <i class="icon-plus"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- END CREATE FORM --}}
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
                                <a href="{{url(route('dashboard.vendors.index')) }}" class="btn btn-lg red">
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

@section('scripts')
<script>
// GALLERY FORM / ADD NEW BUTTON UPLOAD
$(document).ready(function() {
    var html = $("div.galleryForm").html();
    $(".addGallery").click(function(e) {
        e.preventDefault();
        $(".galleryForm").append(html);
        $('.lfm').filemanager('image');
    });
});

// DELETE UPLOAD BUTTON
$(".galleryForm").on("click", ".delete-gallery", function(e) {
    e.preventDefault();
    $(this).closest('.form-group').remove();
});
</script>
@endsection
