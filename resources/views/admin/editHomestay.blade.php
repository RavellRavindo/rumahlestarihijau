@extends('template.admintemplate')

@section('title', 'Edit Homestay - Rumah Hijau')

@section('content2')
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script> --}}

<style>
    form {
        box-sizing: border-box;
        padding: 30px 50px;
    }

</style>
@foreach ($errors->all() as $error)
    <div class="alert alert-danger">
      <p>{{ $error }}</p>
</div>
@endforeach

<form method='POST' action="{{ route('adminEditTable', ['homestay', $homestay->id]) }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Homestay Name</label>
        <input id="name" type="text" class="form-control" name='name' placeholder="Homestay" value="{{$homestay->name}}">
        @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="host">Homestay Host</label>
        <input id="host" type="text" class="form-control" name='host' value="{{$homestay->host}}" placeholder="host">
        @error('host')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="location">Homestay Location</label>
        <input id="location" value="{{$homestay->location}}" type="text" class="form-control" name='location'
            placeholder="Jakarta">
        @error('location')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="address">Homestay Address</label>
        <input id="address" type="text" class="form-control" name='address' placeholder="Jl. Anggrek No. 71"
            value="{{$homestay->address}}">
        @error('address')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="price">Homestay Price / Night</label>
        <input id="price" type="text" class="form-control" name='price' placeholder="300000" value="{{$homestay->price}}">
        @error('price')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="rating">Rating Homestay</label>
        <input id="rating" type="text" class="form-control" name='rating' placeholder="5" value="{{$homestay->rating}}">
        @error('rating')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="like">Like Homestay</label>
        <input id="like" type="text" class="form-control" name='like' placeholder="5" value="{{$homestay->like}}">
        @error('like')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="guest">Guest Room Capacity</label>
        <input id="guest" type="number" class="form-control" name='guest' placeholder="5" value="{{$homestay->guest}}">
        @error('guest')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="bedroom">Bedroom Capacity</label>
        <input id="bedroom" type="number" class="form-control" name='bedroom' placeholder="2"
            value="{{$homestay->bedroom}}">
        @error('bedroom')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="bed">Bed/room</label>
        <input id="bed" type="number" class="form-control" name='bed' placeholder="2" value="{{$homestay->bed}}">
        @error('bed')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="bath">Bath/room</label>
        <input id="bath" type="number" class="form-control" name='bath' placeholder="2" value="{{$homestay->bath}}">
        @error('bath')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    {{-- @foreach ($np as $nearbyplace)
    <strong>Nearby Place {{$loop->index+1}}</strong><br>
    <div class="form-group">
        <label for="nearbyplace{{$loop->index+1}}">Place name</label>

        @empty($np)
        <input id="nearbyplace{{$loop->index+1}}" type="text" class="form-control" name='nearbyplace{{$loop->index+1}}'
            placeholder="Nearby Place {{$loop->index+1}}">
        @else
        <input id="nearbyplace{{$loop->index+1}}" type="text" class="form-control" name='nearbyplace{{$loop->index+1}}'
            placeholder="Nearby Place {{$loop->index+1}}" value="{{$np[$loop->index]->name}}">
        @endempty

        @error('nearbyplace{{$loop->index+1}}')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="nearbydistance{{$loop->index+1}}">Place Distance (km)</label>
        @empty($np)
        <input id="nearbydistance{{$loop->index+1}}" type="text" class="form-control" name='nearbydistance{{$loop->index+1}}'
            placeholder="3">
        @else
        <input id="nearbydistance{{$loop->index+1}}" type="text" class="form-control" name='nearbydistance{{$loop->index+1}}'
            placeholder="3" value="{{$np[$loop->index]->distance}}">
        @endempty

        @error('nearbydistance{{$loop->index+1}}')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    @endforeach

    @foreach ($pp as $popularplace)
    <strong>Popular Place {{$loop->index+1}}</strong><br>
    <div class="form-group">
        <label for="popularplace{{$loop->index+1}}">Place name</label>
        @empty($pp)
        <input id="popularplace{{$loop->index+1}}" type="text" class="form-control" name='popularplace{{$loop->index+1}}'
            placeholder="Popular Place {{$loop->index+1}}">
        @else
        <input id="popularplace{{$loop->index+1}}" type="text" class="form-control" name='popularplace{{$loop->index+1}}'
            placeholder="Popular Place {{$loop->index+1}}" value="{{$pp[$loop->index]->name}}">
        @endempty

        @error('place{{$loop->index+1}}')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="populardistance{{$loop->index+1}}">Place Distance (km)</label>
        @empty($pp)
        <input id="populardistance{{$loop->index+1}}" type="text" class="form-control" name='populardistance{{$loop->index+1}}'
            placeholder="3">
        @else
        <input id="populardistance{{$loop->index+1}}" type="text" class="form-control" name='populardistance{{$loop->index+1}}'
            placeholder="3" value="{{$pp[$loop->index]->distance}}">
        @endempty
        @error('distance{{$loop->index+1}}')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    @endforeach --}}

    <div class="form-group">
        <p>Resource</p>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="wifi" name="wifi" @if ($homestay->has_wifi==1)
            checked
            @endif>
            <label class="form-check-label" for="wifi">Wifi</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="parking" name="parking" @if ($homestay->has_parking==1)
            checked
            @endif>
            <label class="form-check-label" for="parking">Parking</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="restaurant" name="restaurant" @if($homestay->has_restaurant==1)
            checked
            @endif>
            <label class="form-check-label" for="restaurant">Restaurant</label>
        </div>
        <div class="form-check form-check-inline">
<<<<<<< HEAD
            <input class="form-check-input" type="checkbox" id="3" name="ac" @if ($homestay->ac==1)
            checked @endif>
=======
            <input class="form-check-input" type="checkbox" id="ac" name="ac" @if ($homestay->has_ac==1)
            checked
            @endif>
>>>>>>> 60a5990176d1decb0f29db97f85e4044621387ec
            <label class="form-check-label" for="ac">AC</label>
        </div>
    </div>


    <div class="form-group">
        <label for="thumbnail">Upload Gambar Thumbnail</label>
        <input id="thumbnail" type="file" class="form-control" name='thumbnail' placeholder="Example input"
            accept=".png,.jpg,.jpeg">
        @error('thumbnail')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="upload">Upload Foto Homestay</label>
        <input id="upload" type="file" multiple class="form-control" name='upload' placeholder="Example input"
            accept=".png,.jpg,.jpeg">
        @error('upload')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">{{ __('Edit Homestay') }}</button>
</form>

{{-- <div class="mapouter">
    <div class="gmap_canvas">
        <iframe width="770" height="510" id="gmap_canvas" src="https://maps.google.com/maps?q=Jalan Asia Afrika Senayan, RT.1/RW.3, Gelora, Kecamatan Tanah Abang, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10270&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
        <a href="https://2yu.co">2yu</a><br>
        <style>.mapouter{position:relative;text-align:right;height:510px;width:770px;}</style>
        <a href="https://embedgooglemap.2yu.co">html embed google map</a>
        <style>.gmap_canvas {overflow:hidden;background:none!important;height:510px;width:770px;}</style>
    </div>
</div> --}}

@endsection
