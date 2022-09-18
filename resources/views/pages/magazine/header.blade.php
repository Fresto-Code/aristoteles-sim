@if (isset($cover))
    <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center"
        style="background-image: url({{ env('DO_SPACES_ENDPOINT') . "/" . $cover }}); background-size: cover; background-position: center top;">
        <!-- Mask -->
        <span class="mask bg-gradient-default opacity-8"></span>
        <!-- Header container -->
        <div class="container-fluid d-flex align-items-center">
            <div class="row">
                <div class="col-md-12 {{ $class ?? '' }}">
                    <h1 class=" text-white">{{ $title }} </h1>
                    @if ($status === "draft")
                    <h2 class="text-danger">{{ $status }} <i class="ni ni-settings text-danger"></i></h2>
                    @else
                    <h2 class="text-success">{{ $status }} <i class="ni ni-check-bold text-success"></i></h2>
                    @endif
                   
                    @if (isset($description) && $description)
                        <p class="text-white mt-0 mb-5">{{ $description }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@else
    <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center"
        style="background-image: url(); background-size: cover; background-position: center top;">
        <!-- Mask -->
        <span class="mask bg-gradient-default opacity-8"></span>
        <!-- Header container -->
        <div class="container-fluid d-flex align-items-center">
            <div class="row">
                <div class="col-md-12 {{ $class ?? '' }}">
                    <h1 class="display-2 text-white">{{ $title }} </h1>
                    @if (isset($description) && $description)
                        <p class="text-white mt-0 mb-5">{{ $description }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
