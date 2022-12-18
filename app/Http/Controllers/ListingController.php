<?php

namespace App\Http\Controllers;

use App\Data\Contoh;
use App\Exceptions\ValidationException;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;

class ListingController extends Controller
{
  // Show all listings
  public function index(Request $request)
  {
    // request()->session()->token();
    // "<br>";
    // request()->cookie('XSRF-TOKEN');

    // $storage = Storage::disk('public');
    // dd($storage->url('.gitignore'));
    // dd(Storage::lastModified('.gitignore'));
    // dd(Storage::path('.gitignore'));
    // dd(Storage::put('isal.txt', 'Halo'));

    // Storage::disk('public')->setVisibility('logo/woKWagS1Dp43VMjbyySD9wsmrpIYnBmonrs1LXEu.png', 'private');
    // Storage::disk('public')->delete('logo/woKWagS1Dp43VMjbyySD9wsmrpIYnBmonrs1LXEu.png');
    // dd(Storage::disk('public')->getVisibility('logo/nKtzHpRj73sQIzkooM8fkZY4fVpQdDysRkLGa94V.png'));

    // $storage->prepend('isal.txt', 'beginning');
    // Storage::prepend('isal.txt', 'Halloo');
    // Storage::append('isal.txt', 'end');
    // Storage::delete('isal.txt');
    // dd(Storage::exists('isal.txt'));
    // Storage::move('isal.txt', 'app/public/isal.txt');

    // dd(Storage::files());
    // dd(Storage::allFiles());
    // dd(Storage::directories());
    // dd(Storage::allDirectories());

    // Storage::makeDirectory('logo');
    // dd(Storage::deleteDirectory('logo'));

    // return ['nama' => 'faisal'];

    // return response('$content')
    //   ->withHeaders([
    //     'Content-Type' => '$type',
    //     'X-Header-One' => 'Header Value',
    //     'X-Header-Two' => 'Header Value',
    //   ]);

    // return response()
    //   ->view('listings.index', [
    //     'listings' => Listing::latest()->filter(request(['tag', 'search']))->get(),
    //   ])
    //   ->header('X-Name', 'faisal');

    // Cookie::queue('nama', 'faisal', 0.05);


    // dd(Storage::disk('public')->files("logo/"));
    // echo $no;

    // dd( Listing::latest()->filter(request(['tag', 'search']))->paginate(2));

    // dd(Listing::latest()->filter(request(['tag', 'search']))->get()->map(function ($listing) {
    //   if ($listing->logo != '') {
    //     $listing = Listing::find($listing->id);

    //     $logoFileName = explode('/', $listing->logo);
    //     $logoFileName = "logos/" . end($logoFileName);

    //     $listing->update([
    //       'logo' => $logoFileName,
    //     ]);
    //   }
    // }));

    // $listings = Listing::latest()->filter(request(['tag', 'search']))->simplePaginate(6);
    $listings = Listing::latest()->filter(request(['tag', 'search']))->paginate(6);

    return response()
      ->view('listings.index', [
        'listings' => $listings,
      ])
      ->header('X-Name', 'faisal')
      ->cookie('nama', 'faisal', 0.05);
    // ->withoutCookie('nama');
  }

  // Show single listing
  public function show(Request $request, Listing $listing)
  {
    // echo $request->cookie('nama');
    // exit;
    // response
    // Cookie::queue('nama', null, time() - 5);
    // Cookie::expire('nama');
    // response(status: 200)->withoutCookie('nama');
    // echo $request->cookie('nama');
    // return view('listings.show', [
    //   'listing' => $listing,
    // ]);
    // request()->host() . "<br>";
    // request()->httpHost() . "<br>";
    // request()->schemeAndHttpHost() . "<br>";
    // dd(request()->hasHeader('user-AGEN'));
    // dd(request()->ip());
    return response(view('listings.show', [
      'listing' => $listing,
    ]))->withoutCookie('nama');
  }

  // Show Create Form
  public function create()
  {

    // request()->merge(['id' => 1]);
    // dd(request()->has('id', 'name', 'efwfwe'));
    // dd(request()->hasAny('id', 'name', 'efwfwe'));

    // request()->whenHas('id', function () {
    //   dd(request('id'));
    // }, function () {
    //   echo 'Id harus ada';
    // });

    // request()->whenFilled('id', function () {
    //   dd(request('id'));
    // }, function () {
    //   echo 'Id tidak boleh kosong';
    // });

    // Storage::prepend('isal.txt', 'awal yang baru ');

    // dd(request()->missing('tidakAda'));
    // echo request()->old('company') . '<br>';
    // echo request()->old('title') . '<br>';
    // echo request()->old('location') . '<br>';
    // echo request()->old('email') . '<br>';
    // echo request()->old('website') . '<br>';
    // echo request()->old('tags') . '<br>';
    // dd(request()->old('description')) . '<br>';
    // return response()->view('listings.create');
    // return response()->download(storage_path('app/public/isal.txt', ), 'downloaded.txt');

    // return response()->file(storage_path('app/' . Storage::allFiles()[rand(0, 10)]));
    // dd(Storage::allFiles());
    // return response()->view()/

    // return response()->json([
    //   'nama' => 'faisal',
    //   'absen' => 02,
    //   'kelas' => 'xi rpl 1',
    // ]);

    return response()
      ->view('listings.create');
  }

  // Store Listing Data
  public function store(Request $request)
  {
    // echo $request->old('company');
    // dd($request->old('company'));
    // request()->flashExcept('website');
    // $request->merge(['id' => 1]);
    // $request->except(['id']);
    // dd($request->input('id'));

    $formFields = $this->validateRequest($request, 'store');


    if ($request->hasFile('logo')) {
      if ($request->file('logo')->isValid()) {

        try {
          $logo = $request->file('logo');

          $logoName = $logo->hashName();
          $logoExtension = $logo->extension();

          $allowedExtension = ['jpeg', 'jpg', 'png'];

          if (!in_array($logoExtension, $allowedExtension)) {
            throw new ValidationException("Format $logoExtension is not allowed");
          }

          // simpan gambar ke folder
          $logo->storePubliclyAs(
            'logos',
            $logoName,
            'public'
          );

          $formFields['logo'] = "logos/$logoName";
        } catch (ValidationException $error) {
          dd($error->getMessage());
        }
      } else {
        dd('invalid');
      }
    }

    Listing::create($formFields);

    return redirect('/listings')->with('message', 'Listing created successfully!');
  }

  public function edit(Listing $listing)
  {
    return response()
      ->view('listings.edit', [
        'listing' => $listing,
      ]);
  }

  public function update(Request $request, Listing $listing)
  {

    $formFields = $this->validateRequest($request, 'update');

    if ($request->hasFile('logo')) {
      if ($request->file('logo')->isValid()) {

        try {

          $logo = $request->file('logo');

          $logoName = $logo->hashName();
          $logoExtension = $logo->extension();

          $allowedExtension = ['jpeg', 'jpg', 'png'];

          if (!in_array($logoExtension, $allowedExtension)) {
            throw new ValidationException("Format $logoExtension is not allowed");
          }

          // hapus logo sebelumnya jika ada
          if ($listing->logo !== null) Storage::delete($listing->logo);

          // simpan gambar ke folder
          $logo->storePubliclyAs(
            'logos',
            $logoName,
            'public'
          );

          $formFields['logo'] = "logos/$logoName";
        } catch (ValidationException $error) {
          dd($error->getMessage());
        }
      } else {
        dd('invalid');
      }
    }

    $listing->update($formFields);

    return back()->with('message', 'Listing updated successfully!');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    Listing::destroy($id);

    return redirect('listings.index');
  }

  private function validateRequest(Request $request, $action)
  {
    // value paramater action store|update

    $formFields = $request->validate([
      'title' => 'required',
      'company' => 'required',
      'location' => 'required',
      'website' => 'required',
      'email' => 'required|email',
      'tags' => 'required',
      'description' => 'required',
    ], [
      'email.email' => 'Masukkin email nya yang valid!',
    ]);

    if (strtolower($action) == 'store') {
      $request->validate([
        'company' => Rule::unique('listings', 'company'),
      ]);
    }

    return $formFields;
  }
}
