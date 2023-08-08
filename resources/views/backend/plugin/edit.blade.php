@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">plugin</h5>
    <div class="card-body">
    <form method="post" action="{{ route('plugin.update', $plugin->id) }}">
        @method('put')
        @csrf 
        {{-- {{dd($data)}} --}}
        <div class="question">
          <label  class="col-form-label">name <span class="question">*</span></label>
          <input class="form-control" name="name" value="{{ $items->first()->name }}" readonly>
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select name="category[]" class="form-control selectpicker"  multiple data-live-search="true">
                <option value="">--Select any Category--</option>
                @foreach($items as $item)              
                @php 
                $data = explode(',', $item->category);
                @endphp
            
                @foreach($data as $category)
                    <option value="{{$category}}" @if(in_array($category, $data)) selected @endif>{{$category}}</option>
                @endforeach
            @endforeach
            
            </select>
        </div>
        <div class="form-group">
            <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-control">
              <option value="active" {{(($plugin->status=='active') ? 'selected' : '')}}>Active</option>
              <option value="inactive" {{(($plugin->status=='inactive') ? 'selected' : '')}}>Inactive</option>
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