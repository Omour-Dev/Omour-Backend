@extends('apps::dashboard.layouts.app')
@section('title', __('order::dashboard.orders.show.title'))
@section('content')
  <style type="text/css" media="print">
  	@page {
  		size  : auto;
  		margin: 0;
  	}
  	@media print {
  		a[href]:after {
  		content: none !important;
  	}
  	.contentPrint{
  			width: 100%;
  		}
  		.no-print, .no-print *{
  			display: none !important;
  		}
  	}
  </style>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('dashboard.home')) }}">{{ __('apps::dashboard.index.title') }}</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('dashboard.orders.index')) }}">
                        {{__('order::dashboard.orders.index.title')}}
                    </a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">{{__('order::dashboard.orders.show.title')}}</a>
                </li>
            </ul>
        </div>

        <h1 class="page-title"></h1>

        <div class="row">
            <div class="col-md-12">
                <div class="no-print">
                    <div class="col-md-3">
                        <ul class="ver-inline-menu tabbable margin-bottom-10">

                            <li class="active">
                                <a data-toggle="tab" href="#order">
                                    <i class="fa fa-cog"></i> {{__('order::dashboard.orders.show.invoice')}}
                                </a>
                                <span class="after"></span>
                            </li>
                            <li class="">
                                <a data-toggle="tab" href="#update">
                                    <i class="fa fa-cog"></i> {{__('order::dashboard.orders.show.update')}}
                                </a>
                                <span class="after"></span>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="col-md-9 contentPrint">
                    <div class="tab-content">

                        <div class="tab-pane active" id="order">
                            <div class="invoice-content-2 bordered">

                                <div class="col-md-12" style="margin-bottom: 24px;">

                                    <center>
                                        <img src="{{ url(setting('logo')) }}" class="img-responsive" style="width:18%" />
                                        <b>
                                            #{{ $order['id'] }} -
                                            {{ date('Y-m-d / H:i:s' , strtotime($order->created_at)) }}
                                        </b>
                                    </center>

                                </div>

                                @if ($order->user)
                                    <div class="row">
                                        <div class="col-xs-12 table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{__('order::dashboard.orders.show.username')}}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{__('order::dashboard.orders.show.email')}}
                                                        </th>
                                                        <th class="invoice-title uppercase text-center">
                                                            {{__('order::dashboard.orders.show.mobile')}}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center sbold"> {{ $order->user->name }}</td>
                                                        <td class="text-center sbold"> {{ $order->user->email }}</td>
                                                        <td class="text-center sbold"> {{ $order->user->mobile }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-xs-12 table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{ __('order::dashboard.orders.show.area') }}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.street')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.building')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.floor')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{ __('order::dashboard.orders.show.address_note') }}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.username') }}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.mobile')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.email')}}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center sbold">
                                                        {{ $order->address->area ? $order->address->area->translate(locale())->title : '' }}
                                                    </td>
                                                    <td class="text-center sbold">
                                                        {{ $order->address->street }}
                                                    </td>
                                                    <td class="text-center sbold">
                                                        {{ $order->address->building }}
                                                    </td>
                                                    <td class="text-center sbold">
                                                        {{ $order->address->floor }}
                                                    </td>
                                                    <td class="text-center sbold">
                                                        {{ $order->address->address }}
                                                    </td>
                                                    <td class="text-center sbold">
                                                        {{ $order->address->username }}
                                                    </td>
                                                    <td class="text-center sbold">
                                                        {{ $order->address->mobile }}
                                                    </td>
                                                    <td class="text-center sbold">
                                                        {{ $order->address->email }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.product_title')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.product_price')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.product_qty')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.total')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.options')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.addons')}}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->orderProducts as $product)
                                                    <tr>
                                                        <td class="text-center sbold">
                                                            {{ $product->product->translate(locale())->title }}
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ $product->price }}
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ $product->qty }}
                                                        </td>
                                                        <td class="text-center sbold">
                                                            {{ $product->total }}
                                                        </td>
                                                        @if (count($product->orderProductOptions) > 0)
                                                            <td class="text-center sbold">
                                                                @foreach ($product->orderProductOptions as $option)
                                                                    <b>
                                                                        {{ $option->option->translate(locale())->title }} :
                                                                        {{ $option->orderProductOptionValues->optionValue->translate(locale())->title }}
                                                                    </b>

                                                                @endforeach
                                                            </td>
                                                        @endif
                                                        @if (count($product->orderProductAttributes) > 0)
                                                            <td class="text-center sbold">
                                                                @foreach ($product->orderProductAttributes as $attr)
                                                                    <b>
                                                                        {{ $attr->attribute->translate(locale())->title }} :
                                                                        @foreach ($attr->orderProductAttributeValues as $attrValues)
                                                                            {{ $attrValues->attributeValue->translate(locale())->title }}
                                                                            <br>
                                                                        @endforeach
                                                                    </b>
                                                                    <br>
                                                                @endforeach
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.order.subtotal')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.order.off')}}
                                                    </th>
                                                    <th class="invoice-title uppercase text-center">
                                                        {{__('order::dashboard.orders.show.order.total')}}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center sbold">
                                                        {{ $order->subtotal }} {{ setting('default_currency') }}
                                                    </td>
                                                    <td class="text-center sbold">
                                                        {{ $order->discount }} {{ setting('default_currency') }}
                                                    </td>
                                                    <td class="text-center sbold">
                                                        {{ $order->total }} {{ setting('default_currency') }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane" id="update">
                            <form id="updateForm" role="form" class="form-horizontal form-row-seperated" method="post" enctype="multipart/form-data" action="{{ route('dashboard.orders.update',$order['id']) }}">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label class="col-md-2">
                                        {{__('order::dashboard.orders.show.driver')}}
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <div class="col-md-9">
                                        <select name="driver" id="single" class="form-control select2" data-name="driver">
                                            <option value=""></option>
                                            @foreach ($drivers as $driver)
                                            <option value="{{ $driver['id'] }}" {{ $order->driver ? $order->driver->driver_id == $driver->id ? 'selected' : '' : ''}}>
                                                {{ $driver->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="help-block"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2">
                                        {{__('order::dashboard.orders.show.status')}}
                                        <span class="required" aria-required="true">*</span>
                                    </label>
                                    <div class="col-md-9">
                                        <select name="status_id" id="single" class="form-control select2" data-name="status_id">
                                            <option value=""></option>
                                            @foreach ($statuses as $status)
                                            <option value="{{ $status['id'] }}" {{ $order->order_status_id == $status->id ? 'selected' : '' }}>
                                                {{ $status->translate(locale())->title }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="help-block"></div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-actions">
                                        @include('apps::dashboard.layouts._ajax-msg')
                                        <div class="form-group">
                                            <button type="submit" id="submit" class="btn btn-lg green">
                                                {{__('apps::dashboard.buttons.edit')}}
                                            </button>
                                            <a href="{{url(route('dashboard.orders.index')) }}" class="btn btn-lg red">
                                                {{__('apps::dashboard.buttons.back')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();">
                        {{__('apps::dashboard.buttons.print')}}
                        <i class="fa fa-print"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
