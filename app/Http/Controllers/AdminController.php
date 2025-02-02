<?php

namespace App\Http\Controllers;

use App\Models\Homestay;
use App\Models\HomestayPhoto;
use App\Models\Culinary;
use App\Models\Destination;
use App\Models\Souvenir;
use App\Models\Promo;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function homePage()
    {
        return view('admin.home');
    }

    public function tablePage($table)
    {
        switch ($table) {
        case 'homestay':    return view('admin.tableHomestay',    ['homestays'    => Homestay::paginate(10)]);
        case 'culinary':    return view('admin.tableCulinary',    ['culinaries'   => Culinary::paginate(10)]);
        case 'destination': return view('admin.tableDestination', ['destinations' => Destination::paginate(10)]);
        case 'souvenir':    return view('admin.tableSouvenir',    ['souvenirs'    => Souvenir::paginate(10)]);
        case 'promo':       return view('admin.tablePromo',       ['promos'       => Promo::paginate(10)]);
        default:            return response([], 404);
        }
    }

    public function addTablePage($table)
    {
        switch ($table) {
        case 'homestay':    return view('admin.createHomestay');
        case 'culinary':    return view('admin.createCulinary');
        case 'destination': return view('admin.createDestination');
        case 'souvenir':    return view('admin.createSouvenir');
        case 'promo':       return view('admin.createPromo');
        default:            return response([], 404);
        }
    }

    public function editTablePage($table, $id)
    {
        switch ($table) {
        case 'homestay':    return view('admin.editHomestay',    ['homestay'    => Homestay::findOrFail($id)]);
        case 'culinary':    return view('admin.editCulinary',    ['culinary'    => Culinary::findOrFail($id)]);
        case 'destination': return view('admin.editDestination', ['destination' => Destination::findOrFail($id)]);
        case 'souvenir':    return view('admin.editSouvenir',    ['souvenir'    => Souvenir::findOrFail($id)]);
        case 'promo':       return view('admin.editPromo',       ['promo'       => Promo::findOrFail($id)]);
        default:            return response([], 404);
        }
    }

    public function addTable($table)
    {
        switch ($table) {
        case 'homestay':    return $this->addHomestay();
        case 'culinary':    return $this->addCulinary();
        case 'destination': return $this->addDestination();
        case 'souvenir':    return $this->addSouvenir();
        case 'promo':       return $this->addPromo();
        default:            return response([], 404);
        }
    }

    public function editTable($table, $id)
    {
        switch ($table) {
        case 'homestay':    return $this->editHomestay($id);
        case 'culinary':    return $this->editCulinary($id);
        case 'destination': return $this->editDestination($id);
        case 'souvenir':    return $this->editSouvenir($id);
        case 'promo':       return $this->editPromo($id);
        default:            return response([], 404);
        }
    }

    public function deleteTable($table, $id)
    {
        switch ($table) {
        case 'homestay':    return $this->deleteHomestay($id);
        case 'culinary':    return $this->deleteCulinary($id);
        case 'destination': return $this->deleteDestination($id);
        case 'souvenir':    return $this->deleteSouvenir($id);
        case 'promo':       return $this->deletePromo($id);
        default:            return response([], 404);
        }
    }

    private function saveImage($image)
    {
        $savefile = Str::orderedUuid().'.'.$image->getClientOriginalExtension();
        Storage::putFileAs('assets/', $image, $savefile);
        return $savefile;
    }

    private function deleteImage($imagePath)
    {
        Storage::delete($imagePath);
    }

    public function addHomestay()
    {
        $attr = request()->validate([
            'name'      => 'required|max:255',
            'location'  => 'required|max:255',
            'host'      => 'required|max:255',
            'address'   => 'required|max:255',
            'rating'    => 'required',
            'like'      => 'required',
            'price'     => 'required',
            'guest'     => 'required',
            'bedroom'   => 'required',
            'bed'       => 'required',
            'bath'      => 'required',
            'thumbnail' => 'required',
            'upload'    => 'required'
        ]);

        $thumb  = request()->file('thumbnail');
        $images = request()->file('upload');

        $hs                 = new Homestay();
        $hs->name           = $attr['name'];
        $hs->location       = $attr['location'];
        $hs->host           = $attr['host'];
        $hs->address        = $attr['address'];
        $hs->rating         = $attr['rating'];
        $hs->like           = $attr['like'];
        $hs->price          = $attr['price'];
        $hs->guest          = $attr['guest'];
        $hs->bedroom        = $attr['bedroom'];
        $hs->bed            = $attr['bed'];
        $hs->bath           = $attr['bath'];

        $hs->has_wifi       = $attr['has_wifi'] ?? false;
        $hs->has_parking    = $attr['has_parking'] ?? false;
        $hs->has_restaurant = $attr['has_restaurant'] ?? false;
        $hs->has_ac         = $attr['has_ac'] ?? false;
        $hs->save();

        $photo              = new HomestayPhoto();
        $photo->homestay_id = $hs->id;
        $photo->index       = 0;
        $photo->path        = $this->saveImage($thumb);
        $photo->save();

        foreach ($images as $key => $img) {
            if (! $img) continue;
            $photo              = new HomestayPhoto();
            $photo->homestay_id = $hs->id;
            $photo->index       = $key + 1;
            $photo->path        = $this->saveImage($img);
            $photo->save();
        }

        return redirect('/admin/homestay/');
    }

    public function editHomestay($id)
    {
        $hs = Homestay::findOrFail($id);

        $attr = request()->validate([
            'name'      => 'required|max:255',
            'location'  => 'required|max:255',
            'host'      => 'required|max:255',
            'address'   => 'required|max:255',
            'rating'    => 'required',
            'like'      => 'required',
            'price'     => 'required',
            'guest'     => 'required',
            'bedroom'   => 'required',
            'bed'       => 'required',
            'bath'      => 'required',
            // 'thumbnail' => 'required',
            // 'upload'    => 'required'
        ]);

        $thumb  = request()->file('thumbnail');
        $images = request()->file('upload');

        $hs->name           = $attr['name'];
        $hs->location       = $attr['location'];
        $hs->host           = $attr['host'];
        $hs->address        = $attr['address'];
        $hs->rating         = $attr['rating'];
        $hs->like           = $attr['like'];
        $hs->price          = $attr['price'];
        $hs->guest          = $attr['guest'];
        $hs->bedroom        = $attr['bedroom'];
        $hs->bed            = $attr['bed'];
        $hs->bath           = $attr['bath'];

        $hs->has_wifi       = $attr['has_wifi'] ?? false;
        $hs->has_parking    = $attr['has_parking'] ?? false;
        $hs->has_restaurant = $attr['has_restaurant'] ?? false;
        $hs->has_ac         = $attr['has_ac'] ?? false;
        $hs->save();

        if ($thumb) {
            $oldThumb = $hs->homestayPhoto->find(0);

            if ($oldThumb) {
                $this->deleteImage($oldThumb->path);
                $oldThumb->delete();
            }

            $photo              = new HomestayPhoto();
            $photo->homestay_id = $hs->id;
            $photo->index       = 0;
            $photo->path        = $this->saveImage($thumb);
            $photo->save();
        }

        if ($images) {
            $oldImages = $hs->homestayPhoto->where('id', '>', 0);

            if ($oldImages->count() > 0) {
                foreach ($oldImages as $oi) {
                    $this->deleteImage($oi->path);
                    $oi->delete();
                }
            }

            foreach ($images as $key => $img) {
                $photo->homestay_id = $hs->id;
                $photo->index       = $key + 1;
                $photo->path        = $this->saveImage($img);
                $photo->save();
            }
        }

        return redirect('/admin/homestay/');
    }

    public function deleteHomestay($id)
    {
        $hs = Homestay::find($id);

        $hs->nearbyPlace->each->delete();
        $hs->popularPlace->each->delete();

        foreach ($hs->homestayPhoto as $photo) {
            $this->deleteImage($photo->path);
        }

        $hs->homestayPhoto->each->delete();
        $hs->commentList->each->delete();

        $hs->delete();

        return redirect()->back()->with('success', 'Homestay deleted successfully');
    }

    public function addCulinary()
    {
        $attr = request()->validate([
            'name' => 'required|min:7|max:255',
            'description'=>'required|min:10|max:600',
            'type' => 'required|in:main_course,side_dish',
            'like' => 'required',
            'price' => 'required',
            'image' => 'required|image',
        ]);

        $savedImage = $this->saveImage(request()->file('image'));

        $data = new Culinary();
        $data->name = $attr['name'];
        $data->description = $attr['description'];
        $data->type = $attr['type'];
        $data->like = $attr['like'];
        $data->price = $attr['price'];
        $data->photo = $savedImage;
        $data->save();

        return redirect('/admin/culinary/');
    }

    public function editCulinary($id)
    {
        $attr = request()->validate([
            'name' => 'required|min:7|max:255',
            'description'=>'required|min:10|max:600',
            'type' => 'required|in:main_course,side_dish',
            'image' => 'image',
        ]);

        $data = Culinary::find($id);

        $image = request()->file('image');
        if ($image) {
            Storage::delete($data->photo);
            $data->photo = $this->saveImage($image);
        }

        $data->name = $attr['name'];
        $data->description = $attr['description'];
        $data->type = $attr['type'];
        $data->price = $attr['price'];
        $data->save();

        return redirect('/admin/culinary/');
    }

    public function deleteCulinary($id)
    {
        $data = Culinary::find($id);

        Storage::delete($data->photo);
        $data->delete();

        return redirect()->back()->with('success', 'Culinary deleted successfully');
    }

    public function addDestination()
    {
        $attr = request()->validate([
            'name' => 'required|min:7|max:255',
            'description'=>'required|min:10|max:600',
            'rundown' => 'required',
            'address' => 'required|min:3|max:255',
            'image' => 'required|image',
            'price' => 'required'
        ]);

        $savedImage = $this->saveImage(request()->file('image'));

        $data = new Destination();
        $data->name = $attr['name'];
        $data->description = $attr['description'];
        $data->rundown = $attr['rundown'];
        $data->address = $attr['address'];
        $data->price = $attr['price'];
        $data->photo = $savedImage;
        $data->save();

        // $dprice = new DestinationPrice();
        // $dprice->destination_id = $data->id;
        // $dprice->min_person = $attr['minpnew'];
        // $dprice->max_person = $attr['maxpnew'];
        // $dprice->price = $attr['pricenew'];
        // $dprice->save();

        return redirect('/admin/destination/');
    }

    public function editDestination($id)
    {
        $attr = request()->validate([
            'name' => 'required|min:7|max:255',
            'description'=>'required|min:10|max:600',
            'rundown' => 'required',
            'address' => 'required|min:3|max:255',
            'image' => 'image',
            'price' => 'required'
        ]);

        $data = Destination::find($id);

        $image = request()->file('image');
        if ($image) {
            Storage::delete($data->photo);
            $data->photo = $this->saveImage($image);
        }

        $data->name = $attr['name'];
        $data->description = $attr['description'];
        $data->rundown = $attr['rundown'];
        $data->address = $attr['address'];
        $data->price = $attr['price'];
        $data->save();

        return redirect('/admin/destination/');
    }

    public function deleteDestination($id)
    {
        $data = Destination::find($id);
        Storage::delete($data->photo);
        $data->delete();

        return redirect()->back()->with('success', 'Destination deleted successfully');
    }

    public function addSouvenir()
    {
        $attr = request()->validate([
            'name'=>'required',
            'description'=>'required',
            'image'=>'required|image',
            'price'=>'required',
        ]);

        $savedImage = $this->saveImage(request()->file('image'));

        $data = new Souvenir();
        $data->name = $attr['name'];
        $data->description = $attr['description'];
        $data->price = $attr['price'];
        $data->photo = $savedImage;
        $data->save();

        return redirect('/admin/souvenir');
    }

    public function editSouvenir($id)
    {
        $attr = request()->validate([
            'name'=>'required',
            'description'=>'required',
            'price'=>'required',
        ]);

        $data = Souvenir::find($id);

        $image = request()->file('image');
        if ($image) {
            Storage::delete($data->photo);
            $data->photo = $this->saveImage($image);
        }

        $data->name = $attr['name'];
        $data->description = $attr['description'];
        $data->price = $attr['price'];
        $data->save();

        return redirect('/admin/souvenir');
    }

    public function deleteSouvenir($id)
    {
        $data = Souvenir::find($id);
        Storage::delete($data->photo);
        $data->delete();

        return redirect()->back()->with('success', 'Souvenir deleted successfully');
    }

    public function addPromo()
    {
        $attr = request()->validate([
            'name'=>'required',
            'image'=>'required',
        ]);

        $savedImage = $this->saveImage(request()->file('image'));

        $data = new Promo();
        $data->name = $attr['name'];
        $data->photo = $savedImage;
        $data->save();

        return redirect('/admin/promo');
    }

    public function editPromo($id)
    {
        $attr = request()->validate([
            'name'=>'required',
        ]);

        $data = Promo::find($id);

        $image = request()->file('image');
        if ($image) {
            Storage::delete($data->photo);
            $data->photo = $this->saveImage($image);
        }

        $data->name = $attr['name'];
        $data->save();

        return redirect('/admin/promo');
    }

    public function deletePromo($id)
    {
        $data = Promo::find($id);
        Storage::delete($data->photo);
        $data->delete();

        return redirect()->back()->with('success', 'Promo deleted successfully');
    }

}
