@extends('layouts.main') 
@section('title', 'Case Photos')
@section('content')


@push('head')

@endpush


<h1>{{$case->subject}}</h1>

<div class="mb-3"><a href="{{route('cases.review',$case->id)}}" class="link-primary">Return to Case Review</a></div>


<div class="gallery-grid">
    @foreach ($photos as $photo)
        <figure class="figure">
            <a href="{{$photos_path.basename($photo)}}"><img src="{{$photos_path.basename($photo)}}" class="figure-img img-fluid rounded" alt="..."></a>
            <figcaption class="figure-caption">{{basename($photo)}}</figcaption>
        </figure>
    @endforeach
</div>


@endsection
