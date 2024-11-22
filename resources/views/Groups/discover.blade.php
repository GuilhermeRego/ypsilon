@extends('layouts.sidebar')

@section('content')

<div class="container mt-5">
  <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
          <a class="nav-link {{ Request::is('groups/discover') ? 'active' : '' }}" href="{{ url('groups/discover') }}" role="tab">Discover</a>
      </li>
      <li class="nav-item">
          <a class="nav-link {{ Request::is('groups/your-groups') ? 'active' : '' }}" href="{{ url('groups/your-groups') }}" role="tab">Your Groups</a>
      </li>
  </ul>
  <div class="tab-content">
      <div class="tab-pane p-3 active" role="tabpanel">
        <h1>Discover Communities</h1>
        <div>
          @foreach ($groups as $group) 
          <div>
            <div>
              <img src="{{ $group->image_url ?? 'https://via.placeholder.com/50' }}" >
            </div>
            
            <div >
              <h3 >{{ $group->name }}</h3>
              <p >{{$group->memberCount()}} Members | {{ $group->description }}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>
  </div>
</div>



@endsection
