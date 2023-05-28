@extends('app')

@section('content')
    <div class="page">
        <div class="page-content">
            <div class="container text-center">
                <div class="display-1 text-muted mb-5"><i class="si si-exclamation"></i> 550</div>
                <h1 class="h2 mb-3">Oops.. Permission denied..</h1>
                <p class="h4 text-muted font-weight-normal mb-7">Unfortunately you do not have access to this screen.</p>
                <a class="btn btn-primary" href="javascript:history.back()">
                    <i class="fe fe-arrow-left mr-2"></i>
Back to previous screen
                </a>
            </div>
        </div>
    </div>
@endsection
