@extends('dashboard.student.layout.contentsection')

@section('content')

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('marksheets.store') }}" 
                      method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="form-group mb-3">
                        <label for="description" class="fw-semibold">Description*</label>
                        <input type="text" name="description" id="description"
                               class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="image" class="fw-semibold">Choose Image*</label>
                        <input class="upload form-control" id="image" name="image"
                               type="file" required>
                    </div>

                    <button type="submit"
                            class="btn"
                            style="background:#065f46; color:white; width:100%; font-weight:600;">
                        Add Certificate
                    </button>

                </form>
            </div>

        </div>
    </div>

</div>

<style>
@media(max-width: 992px) {
    .content-wrapper {
        margin-left: 0 !important;
        border-radius: 0 !important;
    }
}
</style>

@stop
