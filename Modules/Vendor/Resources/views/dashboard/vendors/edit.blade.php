@extends('apps::dashboard.layouts.app')
@section('title', __('vendor::dashboard.vendors.update.title'))
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
                    <a href="#">{{__('vendor::dashboard.vendors.update.title')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('dashboard.vendors.update',$vendor->id)}}">
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
                                                    {{ __('vendor::dashboard.vendors.update.form.general') }}
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

                            {{-- UPDATE FORM --}}
                            <div class="tab-pane active fade in" id="global_setting">
                                <h3 class="page-title">{{__('vendor::dashboard.vendors.update.form.general')}}</h3>
                                <div class="col-md-10">

                                    @foreach (config('translatable.locales') as $code)
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('vendor::dashboard.vendors.update.form.title')}} - {{ $code }}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="title[{{$code}}]" class="form-control" data-name="title.{{$code}}" value="{{ $vendor->translate($code)->title }}">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    @endforeach

                                    @foreach (config('translatable.locales') as $code)
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('vendor::dashboard.vendors.update.form.description')}} - {{ $code }}
                                        </label>
                                        <div class="col-md-9">
                                            <textarea name="description[{{$code}}]" rows="8" cols="80" class="form-control {{is_rtl($code)}}Editor" data-name="description.{{$code}}">{{ $vendor->translate($code)->description }}</textarea>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    @endforeach

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('vendor::dashboard.vendors.update.form.sellers')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="sellers[]" id="single" class="form-control select2-allow-clear" multiple>
                                                <option value=""></option>
                                                @foreach ($sellers as $seller)
                                                <option value="{{ $seller['id'] }}" {{ $vendor->sellers->contains($seller->id) ? 'selected=""' : ''}}>
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
                                            <input type="text" name="delivery_time" class="form-control" data-name="delivery_time" value="{{ $vendor->delivery_time }}">
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
                                                <option value="{{ $vendorStatus['id'] }}" @if ($vendor->vendor_status_id == $vendorStatus['id'])
                                                selected
                                                @endif>
                                                    {{ $vendorStatus->translate(locale())->title }}
                                                    </option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('vendor::dashboard.vendors.update.form.sections')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="section_id[]" id="single" class="form-control select2-allow-clear" multiple>
                                                <option value=""></option>
                                                @foreach ($sections as $section)
                                                <option value="{{ $section['id'] }}" {{ $vendor->sections->contains($section->id) ? 'selected=""' : ''}}>
                                                    {{ $section->translate(locale())->title }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('vendor::dashboard.vendors.create.form.areas')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="area_id[]" id="single" class="form-control select2-allow-clear" multiple>
                                                <option value=""></option>
                                                @foreach ($states as $state)
                                                <optgroup label="{{ $state->translate(locale())->title }}">
                                                    @foreach ($state->areas as $area)
                                                    <option value="{{ $area['id'] }}" {{ $vendor->areas->contains($area->id) ? 'selected=""' : ''}}>
                                                        {{ $area->translate(locale())->title }}
                                                    </option>
                                                    @endforeach
                                                </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('vendor::dashboard.vendors.update.form.image')}}
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
                                                <img src="{{url($vendor->image)}}" style="height: 15rem;">
                                            </span>
                                            <input type="hidden" data-name="image">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('vendor::dashboard.vendors.update.form.status')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="status" {{($vendor->status == 1) ? ' checked="" ' : ''}}>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    @if ($vendor->trashed())
                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('apps::dashboard.buttons.restore')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="restore">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                            </div>



                            <div class="tab-pane fade in" id="gallery">
                                <h3 class="page-title">{{__('product::dashboard.products.form.tabs.gallery')}}</h3>
                                <div class="col-md-10">
                                    <div class="galleryForm">
                                        @foreach ($vendor->images as $image)
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
                                                <input name="images[]" class="form-control images" type="text" readonly value="{{ url($image->image) }}">
                                                <span class="input-group-btn">
                                                    <a data-input="images" data-preview="holder" class="btn btn-danger delete-gallery">
                                                        <i class="glyphicon glyphicon-remove"></i>
                                                    </a>
                                                </span>
                                            </div>
                                            <span class="holder" style="margin-top:15px;max-height:100px;">
                                                <img src="{{ url($image->image) }}" alt="" style="height:15rem">
                                            </span>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="getGalleryForm" style="display:none">
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
// GALLERY FORM / ADD NEW UPLOAD BUTTON
$(document).ready(function() {
    var html = $("div.getGalleryForm").html();
    $(".addGallery").click(function(e) {
        e.preventDefault();
        $(".galleryForm").append(html);
        $('.lfm').filemanager('image');
    });
});

// DELETE UPLOAD BUTTON & IMAGE
$(".galleryForm").on("click", ".delete-gallery", function(e) {
    e.preventDefault();
    $(this).closest('.form-group').remove();
});
</script>
@endsection
