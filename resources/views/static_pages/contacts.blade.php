@extends('layouts.app')

@section('content')
@include('layouts.upperbarmenu')
<div class="info-page">
    <header>
        <h1>Contact Us</h1>
    </header>

        <section class="info-content" style="overflow-y:scroll">
            <h2>Our Team</h2>
            <ul class="contact-list">
                <li><strong>Gabriel Braga</strong> — <a href="mailto:up202109246@edu.fe.up.pt">up202207784@edu.fe.up.pt</a></li>
                <li><strong>Gonçalo Barroso</strong> — <a href="mailto:up202206636@edu.fe.up.pt">up202207832@edu.fe.up.pt</a></li>
                <li><strong>Guilherme Silva</strong> — <a href="mailto:up202207183@up.pt">up202207041@up.pt</a></li>
                <li><strong>Tomás Vinhas</strong> — <a href="mailto:up202209448@edu.fe.up.pt">up202208437@edu.fe.up.pt</a></li>
            </ul>
        </section>
</div>
@endsection