<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    </head>
    <body class="container">
        <main>
            <section>
                <ul>
                    @foreach ($allNews as $news)
                        <li class="border-bottom">
                            <a href="{{ $news->link }}" title="{{ $news->title }}">{{ $news->title }}</a>
                            <br>
                            <small>Author: {{ $news->author_name }} | Votes: {{ $news->upvotes }} | Date:</small>
                        </li>
                    @endforeach
                </ul>
            </section>
        </main>
    </body>
</html>
