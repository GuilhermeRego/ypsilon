@extends('layouts.sidebar')

@section('content')
<h1>Discover Communities</h1>
<body class="bg-black text-white flex justify-center items-center min-h-screen">
  <div class="w-full max-w-md">
    @foreach ($groups as $group) <!-- Correct Blade syntax -->
    <!-- Community Item -->
    <div class="flex items-center border-b border-gray-700 py-4">
      <!-- Group Image -->
      <div class="flex-shrink-0">
        <img src="{{ $group->image_url ?? 'https://via.placeholder.com/50' }}" alt="{{ $group->name }} Image" class="w-12 h-12 rounded-md">
      </div>
      <!-- Group Details -->
      <div class="ml-4">
        <h3 class="text-lg font-bold">{{ $group->name }}</h3>
        <p class="text-sm text-gray-400">{{$group->memberCount()}} Members | {{ $group->description }}</p>
      </div>
    </div>
    @endforeach
  </div>
</body>
@endsection
