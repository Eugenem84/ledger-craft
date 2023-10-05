<x-layout xmlns:x-slot="http://www.w3.org/1999/xlink">
    <x-slot name="title">заголовок</x-slot>
    @foreach($posts as $post)
        <div>
            <h2>{{$post->title}}</h2>
            <div>
                {{$post->text}}
            </div>
        </div>
    @endforeach
</x-layout>
