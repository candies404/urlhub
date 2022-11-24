<?php

namespace Tests\Feature;

use App\Models\Url;
use Tests\TestCase;

class ShortenUrlTest extends TestCase
{
    protected function hashIdRoute($routeName, $url_id)
    {
        return route(
            $routeName,
            \Hashids::connection(Url::class)->encode($url_id)
        );
    }

    /**
     * Users shorten the URLs, they don't fill in the custom keyword field. The
     * is_custom column (Urls table) must be filled with 0 / false.
     *
     * @test
     */
    public function shortenUrl()
    {
        $longUrl = 'https://laravel.com';
        $response = $this->post(route('createshortlink'), [
            'long_url' => $longUrl,
        ]);

        $url = Url::whereLongUrl($longUrl)->first();

        $response->assertRedirect(route('short_url.stats', $url->keyword));
        $this->assertFalse($url->is_custom);
    }

    /**
     * The user shortens the URL and they fill in the custom keyword field. The
     * keyword column (Urls table) must be filled with the keywords requested
     * by the user and the is_custom column must be filled with 1 / true.
     *
     * @test
     */
    public function shortenUrlWithCustomKeyword()
    {
        $longUrl = 'https://laravel.com';
        $customKey = 'laravel';

        $response = $this->post(route('createshortlink'), [
            'long_url'   => $longUrl,
            'custom_key' => $customKey,
        ]);
        $response->assertRedirect(route('short_url.stats', $customKey));

        $url = Url::whereLongUrl($longUrl)->first();
        $this->assertTrue($url->is_custom);
    }

    /** @test */
    public function userCanDelete()
    {
        $this->loginAsAdmin();

        $url = Url::factory()->create([
            'user_id' => $this->admin()->id,
        ]);

        $this->post(route('createshortlink'), [
            'long_url' => $url->long_url,
        ]);

        $response = $this->from(route('short_url.stats', $url->keyword))
             ->get($this->hashIdRoute('short_url.delete', $url->id));

        $response
            ->assertRedirect(route('home'));

        $this->assertCount(0, Url::all());
    }

    /** @test */
    public function guestCannotDelete()
    {
        $url = Url::factory()->create([
            'user_id' => $this->admin()->id,
        ]);

        $this->post(route('createshortlink'), [
            'long_url' => $url->long_url,
        ]);

        $response = $this->from(route('short_url.stats', $url->keyword))
             ->get($this->hashIdRoute('short_url.delete', $url->id));

        $response
            ->assertForbidden();

        $this->assertCount(2, Url::all());
    }

    /** @test */
    public function duplicate()
    {
        $this->loginAsAdmin();

        $url = Url::factory()->create([
            'user_id' => $this->admin()->id,
        ]);

        $this->post(route('createshortlink'), [
            'long_url' => $url->long_url,
        ]);

        $this->from(route('short_url.stats', $url->keyword))
             ->get(route('duplicate', $url->keyword));

        $this->assertCount(2, Url::all());
    }

    /** @test */
    public function duplicateUrlCreatedByGuest()
    {
        $this->loginAsAdmin();

        $url = Url::factory()->create([
            'user_id' => Url::GUEST_ID,
        ]);

        $this->post(route('createshortlink'), [
            'long_url' => $url->long_url,
        ]);

        $this->from(route('short_url.stats', $url->keyword))
             ->get(route('duplicate', $url->keyword));

        $this->assertCount(3, Url::all());
    }

    /** @test */
    public function customKeyValidation()
    {
        $component = \Livewire\Livewire::test(\App\Http\Livewire\UrlCheck::class);
        $component->assertStatus(200)
            ->set('keyword', '!')
            ->assertHasErrors('keyword')
            ->set('keyword', 'FOO')
            ->assertHasErrors('keyword')
            ->set('keyword', 'admin')
            ->assertHasErrors('keyword')
            ->set('keyword', 'foo_bar')
            ->assertHasNoErrors('keyword');
    }
}