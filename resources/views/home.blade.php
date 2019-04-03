@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard <div><button onclick="window.location.href = '/mail';">email me this pics</button></div></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                   
                    <form method="post" action="{{url('home')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="filename" class="form-control" /><br/>
                        <input type="submit"/>
                    </form>
                    @if (!empty($urls))
                        @foreach ($urls as $url)
                        <pre><img src="{{asset($url)}}" height="200px" width="300px"></pre>
                        @endforeach
                    @endif
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
