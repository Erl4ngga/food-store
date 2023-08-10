@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Post</h5>
    <div class="card-body">
    <form method="post" action="{{route('custom.store')}}">
        @csrf 
        {{-- {{dd($data)}} --}}
        <div class="question">
          <label class="col-form-label">name</label>
          <textarea class="form-control" name="name" readonly>Instagram</textarea>
          @error('question')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="question">
          <label for="question" class="col-form-label">Link Instragram <span class="question">*</span></label>
          <textarea class="form-control" name="instagram">Instagram.com</textarea>
          @error('question')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
          <div class="input-group">
              <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                  <i class="fa fa-picture-o"></i> Choose
                  </a>
              </span>
            <input id="thumbnail" class="form-control" type="text" name="photo" value="">
          </div>
          <div id="holder" style="margin-top:15px;max-height:100px;"></div>
            @error('photo')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-control">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
            @error('status')
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
      $('#name').summernote({
        placeholder: "Write short name....",
          tabsize: 2,
          height: 100
      });
    });
    $(document).ready(function() {
      $('#instagram').summernote({
        placeholder: "Write detail instagram.....",
          tabsize: 2,
          height: 150
      });
    });
</script>
@endpush