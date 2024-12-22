@extends('layouts.app')

@section('content')
@include('layouts.upperbarmenu')
<div class="info-page">
    <header>
        <h1>About Us</h1>
    </header>

    <section class="info-content" style="overflow-y:scroll">
        <h2>What is Ypsilon?</h2>
        <p>Ypsilon is a modern, web-based social network designed to foster relationships, share ideas, and enhance
            social interaction. Open to anyone above 16 years old, Ypsilon combines the best features of contemporary
            social networks into an easy-to-use and intuitive platform.</p>

        <h2>Our Mission</h2>
        <p>Our mission at Ypsilon is to create a space where people can share their thoughts, feelings, and life
            highlights through text, images, videos, or even audio. We aim to bring people closer, whether they’re
            interacting with friends, following celebrities, or discovering new perspectives in the digital world.</p>

        <h2>What We Offer</h2>
        <p>Ypsilon offers a dynamic and engaging social networking experience. Users can connect with others, express
            themselves creatively, and interact with posts by liking, replying, or reposting. The platform ensures
            seamless navigation and interaction, giving users the tools they need to stay connected and engaged.</p>

        <blockquote>"Ypsilon: Share your world, your way, with the people who matter."</blockquote>

        <h2>How Ypsilon Works</h2>
        <p>Users on Ypsilon are grouped into three distinct categories:</p>
        <ul>
            <li><strong>Guests:</strong> Visitors who can search for accounts and view posts without interacting.</li>
            <li><strong>Authenticated Users:</strong> Registered users with profiles who can create posts, like, reply,
                and repost content.</li>
            <li><strong>Admins:</strong> Elevated users with permissions to manage the platform, including banning users
                and moderating content.</li>
        </ul>
        <p>These roles ensure a balanced, secure, and engaging environment for all users.</p>

        <h2>Our Goal</h2>
        <p>The goal of Ypsilon is simple: to bring people together in a vibrant, interactive community where everyone
            can share their world and connect with others. Whether you're a casual observer, an active user, or a
            platform administrator, Ypsilon offers a place for everyone to belong.</p>
    </section>
</div>
@endsection