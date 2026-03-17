@extends('layouts.layout')


@section('content')



@include('components.propis.subheader', ['titol' => 'Reserves'])

<!-- Classes que utilitzen daisy -->
<div class="flex justify-center items-center mt-8">
    <calendar-date class="cally bg-base-100 border border-gray-300 shadow-lg rounded-lg p-4"> <!-- Cally fa que actualitzi el calendari -->
        <svg aria-label="Previous" slot="previous" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg"><path d="M15.75 19.5 8.25 12l7.5-7.5"></path></svg>
        <svg aria-label="Next" slot="next" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg"><path d="m8.25 4.5 7.5 7.5-7.5 7.5"></path></svg>
        <calendar-month></calendar-month>
    </calendar-date>
</div>

@endsection

