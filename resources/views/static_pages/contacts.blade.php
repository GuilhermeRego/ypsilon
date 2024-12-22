@extends('layouts.app')

@section('content')
@include('layouts.upperbarmenu')
<div class="container p-4 d-flex flex-column align-content-center gap-3" style="overflow-y: scroll">
    <header>
        <h1 class="text-center fw-bolder">Contact Us</h1>
    </header>
    <div class="border border-top-2 rounded-4">
        <h2 class="p-2 pb-2 border-bottom border-1 text-center bg-dark text-white fw-bold rounded-top-4">Our Team</h2>
        <ul class="contact-list">
            <li><strong>Gabriel Braga</strong> — <a href="mailto:up202109246@edu.fe.up.pt">up202207784@edu.fe.up.pt</a></li>
            <li><strong>Gonçalo Barroso</strong> — <a href="mailto:up202206636@edu.fe.up.pt">up202207832@edu.fe.up.pt</a></li>
            <li><strong>Guilherme Rego</strong> — <a href="mailto:up202207183@edu.fe.up.pt">up202207041@edu.fe.up.pt</a></li>
            <li><strong>Tomás Vinhas</strong> — <a href="mailto:up202209448@edu.fe.up.pt">up202208437@edu.fe.up.pt</a></li>
        </ul>
    </div>
</div>
@endsection