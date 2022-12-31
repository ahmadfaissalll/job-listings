<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\ValidationException;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ListingController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth')->except(['index', 'show']);
  }

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
    // $listings = Listing::orderByDesc('created_at')->filter(request(['tag', 'search']))->paginate(6);
    $listings = Listing::orderByDesc('created_at')->filter(request(['tag', 'search']))->paginate(6);

    // $listings = $listing->filter(request(['tag', 'search']))->paginate(6);

    return response()
      ->view('listings.index', [
        'listings' => $listings,
      ])
      ->header('X-Name', 'faisal')
      ->cookie('nama', 'faisal', 0.05);
    // ->withoutCookie('nama');
  }

  // Show single listing
  public function show(Request $request, string $id)
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

    try {
      // $id = Crypt::decryptString($id);
      $id = decrypt($id, unserialize: false);
    } catch (DecryptException) {
      return "<p>Terjadi kesalahan, silahkan <a href='/'>kembali</a></p>";
    }

    $listing = Listing::findOrFail($id);

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

    $formFields = $request->validate([
      'title' => 'required',
      'company' => 'required|unique:listings',
      'location' => 'required',
      'website' => 'required',
      'email' => 'required|email:rfc,dns',
      'tags' => 'required',
      'logo' => 'file',
      'description' => 'required',
    ], [
      'company.unique' => 'Email sudah ada',
      'email.email' => 'Masukkin email nya yang valid!',
    ]);

    if ($request->hasFile('logo')) {
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
        return back()->with('message', $error->getMessage());
      }
    } else {
      return back()->with('message', 'Terjadi error silahkan coba dalam beberapa saat lagi');
    }

    $formFields['user_id'] = Auth::id();
    Listing::create($formFields);

    return redirect('/listings')->with('message', 'Listing created successfully!');
  }

  public function edit(string $id)
  {
    try {
      $id = Crypt::decryptString($id);
    } catch (DecryptException) {
      return back()->with('message', "Terjadi kesalahan, silahkan coba dalam beberapa saat lagi");
    }

    $listing = Listing::findOrFail($id);

    // abort if user is not listing owner
    if ( Gate::denies('is-listing-owner', $listing) ) {
      abort(403);
    }

    return response()
      ->view('listings.edit', [
        'listing' => $listing,
      ]);
  }

  public function update(Request $request, string $id)
  {
    try {
      $id = Crypt::decryptString($id);
    } catch (DecryptException) {
      return back()->with('message', "Terjadi kesalahan, silahkan coba dalam beberapa saat lagi");
    }

    $listing = Listing::findOrFail($id);

    // abort if user is not listing owner
    if ( Gate::denies('is-listing-owner', $listing) ) {
      abort(403);
    }

    $formFields = $request->validate([
      'title' => 'required',
      'company' => ['required', Rule::unique('listings', 'company')->ignore($listing)],
      'location' => 'required',
      'website' => 'required',
      'email' => 'required|email',
      'tags' => 'required',
      'logo' => 'file',
      'description' => 'required',
    ], [
      'email.email' => 'Masukkin email nya yang valid!',
    ]);

    if ($request->hasFile('logo')) {
      try {

        $logo = $request->file('logo');

        $logoName = $logo->hashName();
        $logoExtension = $logo->extension();

        $allowedExtension = ['jpeg', 'jpg', 'png'];

        if (!in_array($logoExtension, $allowedExtension)) {
          throw new ValidationException("Format $logoExtension is not allowed");
        }

        // hapus logo sebelumnya jika ada
        if ($listing->logo !== null) Storage::disk()->delete($listing->logo);

        // simpan gambar ke folder
        $logo->storePubliclyAs(
          'logos',
          $logoName,
          'public'
        );

        $formFields['logo'] = "logos/$logoName";
      } catch (ValidationException $error) {
        return back()->with('message', $error->getMessage());
      }
    }

    $listing->update($formFields);

    $encryptedId = Crypt::encryptString($listing->id);

    return redirect()->route('listings.show', $encryptedId)->with('message', 'Listing updated successfully!');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(string $id)
  {
    try {
      $id = Crypt::decryptString($id);
    } catch (DecryptException) {
      return back()->with('message', "Terjadi masalah, silahkan coba dalam beberapa saat lagi");
    }

    $listing = Listing::findOrFail($id);

    // abort if user is not listing owner
    if ( Gate::denies('is-listing-owner', $listing) ) {
      abort(403);
    }

    Listing::destroy($id);

    return redirect()->route('listings.index')->with('message', 'Listing deleted successfully!');
  }

  // Manage Listings
  public function manage()
  {
    return view('listings.manage', ['listings' => auth()->user()->listings()->paginate(10)]);
  }
}
