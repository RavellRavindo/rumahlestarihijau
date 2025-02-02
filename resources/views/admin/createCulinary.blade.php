@extends('template.admintemplate')

@section('title', 'Create Culinary - Rumah Hijau')

@section('content2')
<style>
    form {
        box-sizing: border-box;
        padding: 30px 50px;
    }

</style>

<form method='POST' enctype="multipart/form-data" action="{{ route('adminAddTable', 'culinary') }}">
    @csrf
    <div class="form-group">
        <label for="name">Name Culinary</label>
        <input id="name" type="text" class="form-control" name='name' placeholder="Sop Buntut">
        @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">Description Culinary</label>
        <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
        @error('description')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="type">Culinary Type</label>
        <input id="type" type="text" class="form-control" name='type' placeholder="main_course">
        @error('price')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="price">Price Culinary</label>
        <input id="price" type="number" class="form-control" name='price' placeholder="100000">
        @error('price')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="like">Likes Culinary</label>
        <input id="like" type="number" class="form-control" name='like' placeholder="9600">
        @error('like')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="image">Image Culinary</label>
        <input id="image" type="file" class="form-control" name='image'  accept=".png,.jpg,.jpeg">
        @error('image')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">{{ __('Add Culinary') }}</button>
</form>

@endsection
