<x-layout>
    <x-slot name="title">заголовок</x-slot>
    @foreach($emails as $email )
        <div>
            <li>{{$email}}</li>
        </div>
    @endforeach
</x-layout>
