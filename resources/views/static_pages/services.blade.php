@extends('layouts.app')

@section('content')
@include('layouts.upperbarmenu')
<div class="info-page">
    <header>
        <h1>Our Services</h1>
    </header>

        <section class="info-content" style="overflow-y:scroll">
            <h2>Seamless Social Interaction</h2>
            <p>Ypsilon enables users to connect and interact in a meaningful way. Whether it’s through posting text, or images, the platform provides the tools needed to share thoughts, experiences, and moments with friends and followers.</p>

            <h2>Customizable User Experience</h2>
            <p>With Ypsilon, users can personalize their profiles, organize posts, and choose how they interact with others. The platform's intuitive interface ensures that even first-time users can navigate with ease and enjoy a tailored social networking experience.</p>

            <h2>Content Engagement</h2>
            <p>Ypsilon makes it easy for users to engage with content by liking, commenting, or reposting. This feature not only helps in building connections but also creates an interactive and dynamic community where everyone’s voice is heard.</p>

            <h2>Role-Based Access</h2>
            <p>To ensure a secure and enjoyable experience, Ypsilon categorizes users into three roles:
                <ul>
                    <li><strong>Guests:</strong> Explore content without needing to register.</li>
                    <li><strong>Authenticated Users:</strong> Full platform access, including posting, commenting, and following accounts.</li>
                    <li><strong>Admins:</strong> Oversee platform integrity with permissions to manage users and content.</li>
                </ul>
            </p>
        </section>
</div>
@endsection