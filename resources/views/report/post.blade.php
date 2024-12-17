@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Report Submission</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container mt-5">
            <h2>Report Submission</h2>
            <form action="{{ route('report.store', ['post' => $post->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="justification">Tell us why do you want to report this:</label>
                    <textarea class="form-control" id="justification" name="justification" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Report</button>
            </form>
        </div>
    </body>
</html>
@endsection