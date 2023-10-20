@extends('apps::frontend.layouts.app')
@section('title', $page->translate(locale())->title)
@section('content')

  <!-- start main -->
  <main class="page cat-page"></main>
  <!-- end main -->

  <!-- start page-content -->
  <div class="page-cont">
      <div class="container">
          <div class="page-head">
              <h2 class="sec-head fixall">{{ $page->translate(locale())->title }}</h2>
          </div>
          <div class="pepole-page">
              <div class="row">
                {!! $page->translate(locale())->description !!}
              </div>
          </div>
      </div>
  </div>
  <!-- end page-content -->
@stop
