@props(['textColor' => 'text-white' ])

<div>
    <center>
        @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show w-80 {{$textColor}}" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-slash"></i></span>
            <span class="alert-inner--text"><strong>error!</strong>
                {{ session('error') }}
            </span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif
        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show w-80 bg-success {{$textColor}}" role="alert">
            <span class="alert-inner--icon"><i class="fe fe-thumbs-up"></i></span>
            <span class="alert-inner--text"><strong>Success!</strong>
                {{ session('success') }}
            </span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif
    </center>
</div>