@component('mail::message')
    # Dear {{ $request->name }},
    Thanks for you message.
    We'll contact you as soon as possible.


    Your name: {{ $request->name }}
    Your email: {{ $request->email }}
    Your contact: {{$request->contact}}
    Your message:{{ $request->message }}

    Thanks,
    {{ env('APP_NAME') }}

@endcomponent
