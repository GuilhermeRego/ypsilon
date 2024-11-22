@extends('layouts.sidebar')

@section('content')
<div class="container mt-5">
  <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
          <a class="nav-link {{ Request::is('groups/discover') ? 'active' : '' }}" href="{{ url('groups/discover') }}" role="tab">First Panel</a>
      </li>
      <li class="nav-item">
          <a class="nav-link {{ Request::is('groups/test') ? 'active' : '' }}" href="{{ url('groups/test') }}" role="tab">Second Panel</a>
      </li>
  </ul>
  <div class="tab-content">
      <div class="tab-pane p-3 active" role="tabpanel">
          <p>Second Panel Content</p>
      </div>
  </div>
</div>
@endsection
