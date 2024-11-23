<!-- FILE: resources/views/layouts/upperbarmenu.blade.php -->
<div class="upperbar">
    <a href="{{ url('/home') }}">Trending</a>
    @auth
        <a href="{{ url('/following') }}">Following</a>
    @else
        <a href="{{ url('/login') }}">Following</a>
    @endauth
</div>