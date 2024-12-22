@extends('layouts.app')

@section('content')
@include('layouts.upperbarmenu')
<div class="container p-4 d-flex flex-column align-content-center gap-3" style="overflow-y: scroll">
    <header>
        <h1 class="text-center fw-bolder">Our Services</h1>
    </header>
      <div class="border border-top-2 rounded-4">
        <h2 class="p-2 pb-2 border-bottom border-1 text-center bg-dark text-white fw-bold rounded-top-4">Seamless Social Interaction</h2>
        <p class="p-2 fw-bold">Ypsilon enables users to connect and interact in a meaningful way. Whether it’s through posting text, or images, the platform provides the tools needed to share thoughts, experiences, and moments with friends and followers.</p>
     </div>

    <div class="border border-top-2 rounded-4">
        <h2 class="p-2 pb-2 border-bottom border-1 text-center bg-dark text-white fw-bold rounded-top-4">Customizable User Experience</h2>
        <p class="p-2 fw-bold">With Ypsilon, users can personalize their profiles, organize posts, and choose how they interact with others. The platform's intuitive interface ensures that even first-time users can navigate with ease and enjoy a tailored social networking experience.</p>
    </div>

    <div class="border border-top-2 rounded-4">
        <h2 class="p-2 pb-2 border-bottom border-1 text-center bg-dark text-white fw-bold rounded-top-4">Content Engagement</h2>
        <p class="p-2 fw-bold">Ypsilon makes it easy for users to engage with content by liking, commenting, or reposting. This feature not only helps in building connections but also creates an interactive and dynamic community where everyone’s voice is heard.</p>
    </div>

    <div class="border border-top-2 rounded-4">
        <h2 class="p-2 pb-2 border-bottom border-1 text-center bg-dark text-white fw-bold rounded-top-4">Role-Based Access</h2>
        <p class="p-2 fw-bold">To ensure a secure and enjoyable experience, Ypsilon categorizes users into three roles:
            <ul>
                <li><strong>Guests:</strong> Explore content without needing to register.</li>
                <li><strong>Authenticated Users:</strong> Full platform access, including posting, commenting, and following accounts.</li>
                <li><strong>Admins:</strong> Oversee platform integrity with permissions to manage users and content.</li>
            </ul>
        </p>
    </div>
</div>
@endsection