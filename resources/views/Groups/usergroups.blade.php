@extends('layouts.sidebar')

@section('content')

<div class="container mt-5">
  <!-- Tabs -->
  <ul class="nav nav-tabs mb-4" role="tablist">
    <li class="nav-item">
      <a class="nav-link {{ Request::is('groups/discover') ? 'active' : '' }}" href="{{ url('groups/discover') }}" role="tab">Discover</a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ Request::is('groups/your-groups') ? 'active' : '' }}" href="{{ url('groups/your-groups') }}" role="tab">Your Groups</a>
    </li>
  </ul>

  <!-- Content -->
  <div class="tab-content">
    <div class="tab-pane p-3 active" role="tabpanel">
      <h1 class="mb-4">Your Groups</h1>
      <div>
        @foreach ($groups as $group) 
        <div class="card my-2 p-3">
          <div class="d-flex align-items-center">
            <img src="{{ $group->image_url ?? 'https://via.placeholder.com/50' }}" class="rounded-circle me-3" alt="Group Image">
            <div>
              <h3>{{ $group->name }}</h3>
              <p>{{ $group->memberCount() }} Members | {{ $group->description }}</p>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

<!-- Floating Add Group Button -->
<a href="{{  url('group/create') }}" class="floating-add-group-btn">
  <i class="fa fa-plus"></i>
</a>

@endsection
