<x-layout>
    <x-slot name="title">заголовок</x-slot>
@foreach($myusers as $user)
        <div>
            <h2>{{ $user->id }}</h2>
            <div>
                {{ $user->age }}
            </div>
            <div>
                {{ $user->salary }}
            </div>
        </div>

    @endforeach
</x-layout>
