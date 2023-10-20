@extends('apps::dashboard.layouts.app')
@section('title', __('attribute::dashboard.attributes.routes.update'))
@section('content')

@include('attribute::dashboard.html.attribute_values_html')

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('dashboard.attributes.index')) }}">
                        {{__('attribute::dashboard.attributes.routes.index')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('attribute::dashboard.attributes.routes.update')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <form id="updateForm" page="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{route('dashboard.attributes.update',$attribute->id)}}">
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
                                                <a href="#genral" data-toggle="tab">
                                                    {{ __('attribute::dashboard.attributes.form.tabs.general') }}
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="#attribute_values" data-toggle="tab">
                                                    {{ __('attribute::dashboard.attributes.form.tabs.attribute_values') }}
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
                            <div class="tab-pane active fade in" id="genral">
                                <h3 class="page-title">{{__('attribute::dashboard.attributes.form.tabs.general')}}</h3>
                                <div class="col-md-10">

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('attribute::dashboard.attributes.form.code')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="text" name="code" class="form-control" data-name="code" value="{{ $attribute->code }}">
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    @foreach (config('translatable.locales') as $code)
                                      <div class="form-group">
                                          <label class="col-md-2">
                                              {{__('attribute::dashboard.attributes.form.title')}} - {{ $code }}
                                          </label>
                                          <div class="col-md-9">
                                              <input type="text" name="title[{{$code}}]" class="form-control" data-name="title.{{$code}}" value="{{ $attribute->translate($code)->title }}">
                                              <div class="help-block"></div>
                                          </div>
                                      </div>
                                    @endforeach

                                    <div class="form-group">
                                        <label class="col-md-2">
                                            {{__('attribute::dashboard.attributess.form.vendors')}}
                                        </label>
                                        <div class="col-md-9">
                                            <select name="vendor_id" id="single" class="form-control select2" data-name="vendor_id">
                                                <attribute value=""></attribute>
                                                @foreach ($vendors as $vendor)
                                                <attribute value="{{ $vendor['id'] }}" {{ ($attribute->vendor_id == $vendor->id) ? 'selected' : '' }}>
                                                    {{ $vendor->translate(locale())->title }}
                                                </attribute>
                                                @endforeach
                                            </select>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2">
                                          {{__('attribute::dashboard.attributes.form.status')}}
                                        </label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="make-switch" id="test" data-size="small" name="status" {{($attribute->status == 1) ? ' checked="" ' : ''}}>
                                            <div class="help-block"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade in" id="attribute_values">
                                <h3 class="page-title">{{__('attribute::dashboard.attributes.form.tabs.attribute_values')}}</h3>
                                <div class="col-md-10">

                                    <div class="attribute_values_form">
                                      @foreach ($attribute->values as $key => $attributeValues)
                                        <div class="content">
                                          <input type="hidden" name="attribute_values_ids[]" value="{{ $attributeValues->id }}">
                                          @foreach (config('translatable.locales') as $code)
                                            <div class="form-group">
                                                <label class="col-md-2">
                                                    {{__('attribute::dashboard.attributes.form.title')}} - {{ $code }}
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="attribute_value_title[{{$code}}][]" class="form-control" data-name="attribute_value_title.{{$code}}" value="{{ $attributeValues->translate($code)->title }}">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                          @endforeach
                                          <div class="form-group">
                                              <label class="col-md-2">
                                                  {{__('attribute::dashboard.attributes.form.status')}}
                                              </label>
                                              <div class="col-md-9">
                                                    <input type="checkbox" class="ischecked" name="attribute_value_status[]" value="1" onclick="checkFunction()" {{ $attributeValues->status ? 'checked' : '' }}>
                                                    <input type="hidden" class="isUnchecked" name="attribute_value_status[]" value="0" {{($attributeValues->status) ? 'disabled' : ''}}>
                                              </div>
                                          </div>
                                          <div class="form-group">
                                              <a href="javascript:;" class="remove_html btn red">
                                                  <i class="fa fa-times"></i>
                                              </a>
                                          </div>
                                          <hr>
                                        </div>
                                      @endforeach
                                    </div>

                                    <button id="copy" type="button" class="btn green btn-lg mt-ladda-btn ladda-button btn-circle btn-outline" data-style="slide-down" data-spinner-color="#333">
                                        <span class="ladda-label">
                                            <i class="icon-plus"></i>
                                        </span>
                                    </button>
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
                                <a href="{{url(route('dashboard.attributes.index')) }}" class="btn btn-lg red">
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
$(function(){
  var html = $("div.attribute_values_form_copier").html();
  $('#copy').click(function(event){
      $(".attribute_values_form").append(html);
  });

  $(".attribute_values_form").on("click",".remove_html", function(e){
      e.preventDefault();
      $(this).closest('.content').remove();
  });

});


function checkFunction(){

  $('[name="attribute_value_status[]"]').change(function(){
      if($(this).is(':checked'))
        $(this).next().prop('disabled', true);
      else
        $(this).next().prop('disabled', false);
  });

}

</script>
@stop
