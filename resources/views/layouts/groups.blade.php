@extends('layouts.app')

@section('content')
@include('layouts.upperbarmenu')
<div class="container mt-5">

  <!-- Content -->
  <div class="tab-content">
    <div class="tab-pane p-3 active" role="tabpanel">
      @yield('groups-content')
      <div>
        @foreach ($groups as $group) 
        <a href="{{ url('groups/' . $group->id) }}" class="text-decoration-none text-dark">
          <div class="card my-2 p-3">
            <div class="d-flex align-items-center">
              <img src="{{ asset('storage/' . ($group->groupImage ? $group->groupImage->url : 'https://via.placeholder.com/50')) }}" class="rounded-circle me-3" alt="Group Image">
              <div>
                <h3>{{ $group->name }}</h3>
                @if ($group->memberCount() == 1)
                  <p>{{ $group->memberCount() }} Member | {{ $group->description }}</p>
                @else
                  <p>{{ $group->memberCount() }} Members | {{ $group->description }}</p>
                @endif
              </div>
            </div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </div>
</div>

<!-- Floating Add Group Button -->
<a href="{{  url('groups/create') }}" class="floating-add-group-btn">
  <i class="fa fa-plus"></i>
</a>

@endsection
