@extends('template.template')

@section('title', 'Souvenir - Rumah Hijau')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
{{-- Tulisan Besar Souvenir --}}

<div class="souvenirTittle" style="color:#3bb143">
    Choose The Perfect <b style="color: #FF6700">Souvenir</b><br>for Your Family</div>

{{-- Kotak Gambar dan Deskripsi Souvenir --}}
<div class="sectionContainer">
    <div class="souvenirContainer">
        @foreach ($souvenirs as $data)
        <div class="souvenirImgContainer">
            <img class="souvenirImg" src="{{Storage::url($data->photo)}}">
            <div style="padding: 4%;">
                <div style="text-align: justify; margin-bottom: 3%">{{$data->name}}</div>
                <div class="hargaSouvenir">Rp. {{$data->price}}</div>
                <button id="openModal" class="checkButtonSouvenir" onclick="openForm('{{$data->id}}')">Check</button>
            </div>
        </div>
        @endforeach

    </div>

</div>

{{-- Untuk Function Button Check Souvenir --}}
@foreach ($souvenirs as $data)

<div id="myOverlay {{$data->id}}" class="overlayCulinary">

    <div class="wrapSouvenir">
        <span class="closebtnCulinary" onclick="closeForm('{{$data->id}}')" title="Close"> X </span>
        <img class="souvenirOverlayImg" src="{{Storage::url($data->photo)}}">
        <div style="text-align: center; font-weight: bold; color: green; margin-bottom: 3%">{{$data->name}}</div>
        <div style="text-align: justify; margin-bottom: 4%">{{$data->description}}</div>
        <div class="souvenirOverlayPrice">Rp. {{$data->price}}</div>
        <!-- <button class="buyNowSouvenir">Buy Now</button> -->
        <a href="https://api.whatsapp.com/send?phone=6285155488011&text=Saya%20Ingin%20Membeli%20Souvenir%20{{ $data->name }}"
            class="buyNowSouvenir">Buy
            Now</a>
    </div>
</div>
@endforeach

<script>
    function openForm(id) {
        name = "myOverlay " + id;
        document.getElementById(name).style.display = "block";
    }

</script>

<script>
    function closeForm(id) {
        name = "myOverlay " + id;
        document.getElementById(name).style.display = "none";
    }

</script>
@endsection
