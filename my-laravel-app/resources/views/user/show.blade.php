<x-layout xmlns:x-slot="http://www.w3.org/1999/xlink">
    <x-slot:title>
        {{$title}}
    </x-slot:title>
    <p>{{$name}}</p>
    <p>{{$age}}</p>
    <p>{{$salary}}</p>
    <p class="{{$css}}">{{$name}}</p>
    <input value="{{$name}}">
    <input value="{{$age}}">
    <input value="{{$salary}}">
    <p style="color: {{$redColor}}">{{$name}}</p>
    <a href="{{$href}}">{{$text}}</a>

</x-layout>
