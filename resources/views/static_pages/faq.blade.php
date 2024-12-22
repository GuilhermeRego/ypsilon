@extends('layouts.app')

@section('content')
@include('layouts.upperbarmenu')
<div class="info-page" style="overflow-y:scroll">
    <header>
        <h1>Frequently Asked Questions</h1>
    </header>

        <section class="info-content">

        <h2>General Questions</h2>

        <div class="faq-item">
            <h3>1. What is Ypsilon?</h3>
            <p>Ypsilon is a modern social network designed for users to share thoughts, experiences, and moments through text, images, videos, and audio. It fosters interaction and connection among friends, followers, and communities.</p>
        </div>

        <div class="faq-item">
            <h3>2. Who can use Ypsilon?</h3>
            <p>Ypsilon is open to anyone aged 16 and above. Guests can explore content, authenticated users can post and interact, and admins manage and maintain the platform’s integrity.</p>
        </div>

        <div class="faq-item">
            <h3>3. What makes Ypsilon different from other social networks?</h3>
            <p>Ypsilon combines the best features of modern social networks while maintaining a simple and intuitive interface. It emphasizes user interaction, content sharing, and a structured role-based access system for security and convenience.</p>
        </div>

        <h2>Account Management</h2>

        <div class="faq-item">
            <h3>4. How do I create an account?</h3>
            <p>Click the "Sign Up" button, fill in your details, and verify your email address through the confirmation link sent to you. Once verified, you can start using Ypsilon immediately.</p>
        </div>

        <div class="faq-item">
            <h3>5. Can I change my profile information?</h3>
            <p>Yes, you can update your profile by visiting the "Profile" section in your account settings. Changes to your name, email, and other details can be made easily.</p>
        </div>

        <div class="faq-item">
            <h3>6. What should I do if I forget my password?</h3>
            <p>If you forget your password, click on the "Forgot Password" link on the login page. You’ll receive an email with a reset link to create a new password.</p>
        </div>

        <h2>Content Sharing</h2>

        <div class="faq-item">
            <h3>7. What types of content can I share?</h3>
            <p>Users can share text posts, images, videos, and audio clips. This versatility allows you to express yourself in the way that suits you best.</p>
        </div>

        <div class="faq-item">
            <h3>8. How do I interact with other users' content?</h3>
            <p>You can like, comment on, and repost content shared by others. These interactions foster connections and make the platform dynamic and engaging.</p>
        </div>

        <h2>Roles and Permissions</h2>

        <div class="faq-item">
            <h3>9. What roles exist on Ypsilon?</h3>
            <p>There are three roles:
                <ul>
                    <li><strong>Guests:</strong> Can view profiles and posts but cannot interact with content.</li>
                    <li><strong>Authenticated Users:</strong> Have full access to create posts, interact with others, and manage their profiles.</li>
                    <li><strong>Admins:</strong> Can perform all actions and are responsible for managing users and content.</li>
                </ul>
            </p>
        </div>

        <div class="faq-item">
            <h3>10. Can an admin remove my content?</h3>
            <p>Yes, admins have the authority to moderate the platform, which includes removing inappropriate or offensive content and managing user accounts.</p>
        </div>

        <h2>Platform Features</h2>

        <div class="faq-item">
            <h3>11. Are there privacy settings?</h3>
            <p>Yes, Ypsilon offers privacy settings that allow users to control who can view their posts, profile, and interactions.</p>
        </div>

        <h2>Other Questions</h2>

        <div class="faq-item">
            <h3>12. How do I report inappropriate content?</h3>
            <p>You can report inappropriate content or users by clicking the "Report" button available on posts and profiles. Admins review reports and take necessary actions.</p>
        </div>

        <div class="faq-item">
            <h3>13. Can I delete my account?</h3>
            <p>Yes, you can delete your account through the "Account Settings" page. Deleting your account will permanently remove all your data from the platform.</p>
        </div>

        <div class="faq-item">
            <h3>14. How does Ypsilon ensure a safe community?</h3>
            <p>Ypsilon employs active moderation, community guidelines, and a reporting system to maintain a safe and respectful environment for all users.</p>
        </div>

        </section>
</div>
@endsection
