<div class="form-group">
    <label class="col-md-2">
        {{__('product::dashboard.products.form.attributes')}}
    </label>
    <div class="col-md-9">
        @foreach ($attributes as $attribute)
        <select name="attribute_id[{{ $attribute['id'] }}][]" id="single" class="form-control select2" data-name="attribute_id" data-vendor="attribute_id" multiple>
            <option value="">
                {{__('product::dashboard.products.form.select')}}
            </option>
            <optgroup label="{{ $attribute->translate(locale())->title }}">
                @foreach ($attribute->values as $value)
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
