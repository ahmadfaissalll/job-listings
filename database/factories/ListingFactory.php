<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition()
  {
    $filterArray = function (array $array, array $element) {
      return array_filter($array, function ($value) use ($element) {
        return !in_array($value, $element);
      });
    };

    $imagePaths = array_map(fn($value) => "images/$value", $filterArray('scandir'(public_path('images') ), ['.', '..']));
    $imagePaths = array_merge($imagePaths, array_map(fn($value) => "logos/$value", $filterArray(scandir(public_path('logos') ), ['.', '..'])));

    $imagePath = collect($imagePaths)->random();

    return [
      'user_id' => collect([2, 4, 5])->random(),
      'title' => $this->faker->sentence(),
      'logo' => $imagePath,
      'tags' => 'laravel, api, backend',
      'company' => $this->faker->company(),
      'email' => $this->faker->companyEmail(),
      'website' => $this->faker->url(),
      'location' => $this->faker->city(),
      'description' => $this->faker->paragraph(5),
    ];
  }
}
