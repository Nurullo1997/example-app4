<x-layaouts.main>
    <x-slot:title>
        Blog
    </x-slot:title>

    <x-page-header>

        Blog

    </x-page-header>


    <!-- Blog Start -->
    <div class="container-fluid py-5">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row align-items-end mb-4">
                <div class="col-lg-6">
                    <h6 class="text-secondary font-weight-semi-bold text-uppercase mb-3">Latest Blog</h6>
                    <h1 class="section-title mb-3">Oxirgi Postlar</h1>
                </div>
            </div>

            <div class="row">

                @foreach ($posts as $post)
                    <div class="col-lg-4 col-md-6 mb-5">
                        <div class="position-relative mb-4">
                            <img class="img-fluid rounded w-100" src="{{ asset('storage/'.$post->photo) }}"
                                alt="">
                            <div class="blog-date">
                                <h4 class="font-weight-bold mb-n1">01</h4>
                                <small class="text-white text-uppercase">Jan</small>
                            </div>
                        </div>
                        <div class="d-flex mb-2">

                            @foreach ($post->tags as $tag)
                                <a class="text-secondary text-uppercase font-weight-medium">{{ $tag->name }}</a>
                                <span class="text-primary px-2">|</span>
                            @endforeach

                        </div>

                        <div class="d-flex mb-2">
                            <a class="text-danger text-uppercase font-weight-medium"
                                href="">{{ $post->category->name }}</a>
                        </div>
                        <h5 class="font-weight-medium mb-2">{{ $post->title }}</h5>
                        <p class="mb-4">{{ $post->short_content }}</p>
                       {{--  @if (auth()->check() && auth()->user()->hasRole('admin'))
                            <a class="btn btn-sm btn-primary py-2"
                                href="{{ route('posts.show', ['post' => $post->id]) }}">O'qish</a>
                        @endif --}}
                           @if (auth()->user()->hasRole('blogger'))
                            <a class="btn btn-sm btn-primary py-2"
                                href="{{ route('posts.show', ['post' => $post->id]) }}">O'qish</a>
                        @endif
                    </div>
                @endforeach



                <div class="col-12">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-lg justify-content-center mb-0">
                            <li class="page-item disabled">

                            </li>
                            {{ $posts->links() }}

                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog End -->









</x-layaouts.main>
