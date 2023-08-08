@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Post</h5>
    <div class="card-body">
    <form method="post" action="{{route('custom.update',$custom->id)}}">
        @csrf 
        @method('PATCH')
        {{-- {{dd($data)}} --}}
        <div class="question">
          <label class="col-form-label">name</label>
          <textarea class="form-control" name="question" readonly>{{$custom->name}}</textarea>
          @error('question')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="question">
          <label for="question" class="col-form-label">Footer 1 <span class="question">*</span></label>
          <textarea class="form-control" name="footer1">{{$custom->footer1}}</textarea>
          @error('question')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="question">
          <label for="question" class="col-form-label">Footer 2 <span class="question">*</span></label>
          <textarea class="form-control" name="footer2">{{$custom->footer2}}</textarea>
          @error('question')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="question">
          <label for="question" class="col-form-label">Footer 3 <span class="question">*</span></label>
          <textarea class="form-control" name="footer3">{{$custom->footer3}}</textarea>
          @error('question')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="question">
          <label for="question" class="col-form-label">Footer 4 <span class="question">*</span></label>
          <textarea class="form-control" name="footer4">{{$custom->footer4}}</textarea>
          @error('question')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Update</button>
        </div>
    </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $('#lfm').filemanager('image');
    $('#lfm1').filemanager('image');
    $(document).ready(function() {
    $('#summary').summernote({
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
    });

    $(document).ready(function() {
      $('#quote').summernote({
        placeholder: "Write short Quote.....",
          tabsize: 2,
          height: 100
      });
    });
    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Write detail description.....",
          tabsize: 2,
          height: 150
      });
    });
</script>
@endpush