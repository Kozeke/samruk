<div id="messages" class="messages w-25">
    @if (request()->session()->has('success'))
        @foreach (request()->session()->get('success') as $success)
            <div class="alert alert-success border border-success" role="alert">
                <p class="m-0">{!! $success !!}</p>
                <button type="button" class="close">
                  <span aria-hidden="true">×</span>
                </button>
            </div>
        @endforeach
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger border border-danger" role="alert">
                <p class="m-0">{!! $error !!}</p>
                <button type="button" class="close">
                  <span aria-hidden="true">×</span>
                </button>
            </div>
        @endforeach
    @endif

    @if (request()->session()->has('success') || $errors->any() )
        <script type="text/javascript">
            $(document).ready(function() { alertClose(); });
        </script>
    @endif
</div>
