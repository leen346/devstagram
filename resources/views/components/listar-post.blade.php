<div>
    <!-- Walk as if you are kissing the Earth with your feet. - Thich Nhat Hanh -->
    {{-- {{$titulo}}
    <h1>{{$slot}}</h1> --}}
    @if ($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach ($posts as $post)
            <div>
                <a href="{{route('posts.show', ['post' => $post, 'user' => $post->user])}}">{{-- post apunta al id del post seleccionado --}}
                <img src="{{asset('uploads').'/'.$post->imagen}}" alt="Imagen del post {{$post->titulo}}">
                </a>
            </div>
        @endforeach
        </div>
        <div class="my-10">
        {{$posts->links('pagination::tailwind')}}
        </div>
    @else 
        <p class="text-center">No Hay Posts, sigue a alguien para poder mostrar sus posts</p>
    @endif
</div>