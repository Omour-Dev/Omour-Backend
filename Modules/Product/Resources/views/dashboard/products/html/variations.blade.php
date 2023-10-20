<div class="form-group">
    <label class="col-md-2">
        {{__('product::dashboard.products.form.options')}}
    </label>
    <div class="col-md-9">
        @foreach ($options as $option)
        <select name="option_id[{{ $option['id'] }}][]" id="single" class="form-control select2" data-name="option_id" data-vendor="option_id" multiple>
            <option value="">
                {{__('product::dashboard.products.form.select')}}
            </option>
            <optgroup label="{{ $option->translate(locale())->title }}">
                @foreach ($option->values as $value)
                <option value="{{ $value['id'] }}">
                    {{ $value->translate(locale())->title }}
                </option>
                @endforeach
            </optgroup>
        </select>
        <br>
        @endforeach
        <div class="help-block"></div>
    </div>
</div>
