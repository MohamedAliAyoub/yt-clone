<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @if($videos->count() > 0)
                    @foreach($videos as $video)
                        <div class="card my-2">

                            <div class="card-body">
                                <div class="row">
                                    <a href="{{route('video.watch' , $video)}}">
                                        <div style="width: 333px;">
                                            @include('includes.videoThumbnail')
                                        </div>
                                    </a>
                                    <div class="col-md-3">
                                        <h5>{{$video->title}}</h5>
                                        <p class="text-truncate">{{$video->description}}</p>
                                    </div>
                                    <div class="col-md-2">
                                        {{$video->visibility}}
                                    </div>
                                    <div class="col-md-2">
                                        {{$video->created_at->format('d/m/Y')}}
                                    </div>
                                    @if( auth()->user()->owns($video))
                                        <div class="col-md-2">
                                            <a href="{{ route('video.edit' , ['channel'=> auth()->user()->channel, 'video' => $video->uid])}}"
                                               class="btn btn-light btn-sm">Edit</a>
                                            <a wire:click.prevent="delete('{{$video->uid}}')"
                                               class="btn btn-danger btn-sm">Delete</a>
                                        </div>
                                    @endif


                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h1>No Videos Uploaded</h1>
                @endif
            </div>
            {{ $videos->links()}}
        </div>
    </div>
</div>
