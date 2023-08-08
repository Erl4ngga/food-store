@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add FAQ</h5>
    <div class="card-body">
      <form method="post" action="{{route('faq.store')}}">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">question <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="question" placeholder="Question"  value="{{old('question')}}" class="form-control">
          @error('question')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
            <label for="answer" class="col-form-label">answer</label>
            <textarea class="form-control" id="answer" name="answer">{{old('answer')}}</textarea>
            @error('answer')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        {{-- {{$parent_cats}} --}}
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
           <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
      $('#summary').summernote({
        placeholder: "Write short description.....",
          tabsize: 2,
          height: 120
      });
    });
</script>

<script>
  $('#is_parent').change(function(){
    var is_checked=$('#is_parent').prop('checked');
    // alert(is_checked);
    if(is_checked){
      $('#parent_cat_div').addClass('d-none');
      $('#parent_cat_div').val('');
    }
    else{
      $('#parent_cat_div').removeClass('d-none');
    }
  })

  $(document).ready(function() {
      $('#answer').summernote({
        placeholder: "Write detail answer.....",
          tabsize: 2,
          height: 150
      });
    });
</script>
@endpush