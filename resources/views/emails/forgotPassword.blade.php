@component('mail::layout')
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="http://localhost:8002/B-healthy.png" alt="B-healthy" height="150" width="150">
        @endcomponent
    @endslot

        ## Bonjour,
        Votre nouveau mot de passe est : {{$password}}

        Merci,
        {{ config('app.name') }}


    @slot('footer')
        @component('mail::footer')
            © 2020  {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
