<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div>
            @include('layouts.navigation')

            <main>
                {{ $slot }}
            </main>
        </div>

        <style>

            :root {
                --primary-color: rgb(0, 100, 255);
                --primary-border: 3px solid var(--primary-color);
                --block-border-radius: 15px;
            }

            * {
                padding: 0;
                margin: 0;
                transition: 150ms;
                font-family: "Ubuntu", sans-serif;
                font-weight: 300;
            }

            a {
                text-decoration: none;
                outline: none;
                color: black;

                &.link {
                    color: rgb(100, 100, 100);
                    font-family: 'Courier New', Courier, monospace;
                    font-size: .75rem;
                    padding: 10px 15px;
                }

                &.link:hover {
                    text-decoration: underline;
                }

                &.no-padding {
                    padding: 0;
                }
            }

            button,
            input,
            select {
                border: 2px solid transparent;
                border-radius: 10px;
                background-color: transparent;
            }

            button {
                padding: 10px 15px;
                font-weight: 700;
                cursor: pointer;
                color: var(--primary-color);

                &.primary,
                &.secondary:hover,
                &.secondary:focus {
                    border-color: var(--primary-color);
                }

                &.primary:hover,
                &.primary:focus {
                    background-color: var(--primary-color);
                    color: white;
                }
            }

            input,
            select {
                padding: 7px;
                border-color: var(--primary-color);
            }
            
            main {
                padding: 0 10%;
            }

            .debug {
                background-color: rgb(221, 221, 221);
                border-radius: 5px;
                padding: 3px;
                font-family: 'Courier New', Courier, monospace;
                font-size: .65rem;
            }

            .monospace {
                font-family: 'Courier New', Courier, monospace;
                font-size: .8rem;
                align-content: center;
            }

        </style>
    </body>
</html>
