@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-20 min-h-[60vh]">
    <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 font-serif mb-8 border-b border-slate-200 pb-6">{{ $page->title }}</h1>
    <div class="text-slate-700 leading-relaxed space-y-6 text-sm sm:text-base prose max-w-none">
        {!! $page->content !!}
    </div>
</div>
@endsection