@extends('layouts.app')

@section('content')
@include('layouts.upperbarmenu')
<div class="container p-4 d-flex flex-column align-content-center gap-3" style="overflow-y: scroll">
    <header>
        <h1 class="text-center fw-bolder">About Us</h1>
    </header>
    <div class="border border-top-2 rounded-4">
    <h2 class="p-2 pb-2 border-bottom border-1 text-center bg-dark text-white fw-bold rounded-top-4">What is Ypsilon?</h2>
    <p class="p-2 fw-bold">Ypsilon is a modern, web-based social network designed to foster relationships, share ideas, and enhance
        social interaction. Open to anyone above 16 years old, Ypsilon combines the best features of contemporary
        social networks into an easy-to-use and intuitive platform.</p>
    </div>
    <div class="border border-2 rounded-4">
    <h2 class="p-2 pb-2 border-bottom border-1 text-center bg-dark text-white fw-bold rounded-top-4">Our Mission</h2>
    <p class="p-2 fw-bold">Our mission at Ypsilon is to create a space where people can share their thoughts, feelings, and life
        highlights through text, images, videos, or even audio. We aim to bring people closer, whether they’re
        interacting with friends, following celebrities, or discovering new perspectives in the digital world.</p>
    </div>

    <div class="border border-2 rounded-4">
    <h2 class="p-2 pb-2 border-bottom border-1 text-center bg-dark text-white fw-bold rounded-top-4">What We Offer</h2>
    <p class="p-2 fw-bold">Ypsilon offers a dynamic and engaging social networking experience. Users can connect with others, express
        themselves creatively, and interact with posts by liking, replying, or reposting. The platform ensures
        seamless navigation and interaction, giving users the tools they need to stay connected and engaged.</p>

    <blockquote>"Ypsilon: Share your world, your way, with the people who matter."</blockquote>
    </div>  

    <div class="border border-2 rounded-4">
    <h2 class="p-2 pb-2 border-bottom border-1 text-center bg-dark text-white fw-bold rounded-top-4">How Ypsilon Works</h2>
    <p class="p-2 fw-bold">Users on Ypsilon are grouped into three distinct categories:</p>
    <ul>
        <li><strong>Guests:</strong> Visitors who can search for accounts and view posts without interacting.</li>
        <li><strong>Authenticated Users:</strong> Registered users with profiles who can create posts, like, reply,
            and repost content.</li>
        <li><strong>Admins:</strong> Elevated users with permissions to manage the platform, including banning users
            and moderating content.</li>
    </ul>
    <p class="p-2 fw-bold">These roles ensure a balanced, secure, and engaging environment for all users.</p>
    </div>

    <div class="border border-2 rounded-4">
    <h2 class="p-2 pb-2 border-bottom border-1 text-center bg-dark text-white fw-bold rounded-top-4">Our Goal</h2>
    <p class="p-2 fw-bold">The goal of Ypsilon is simple: to bring people together in a vibrant, interactive community where everyone
        can share their world and connect with others. Whether you're a casual observer, an active user, or a
        platform administrator, Ypsilon offers a place for everyone to belong.</p>
    </div>
</div>
@endsection