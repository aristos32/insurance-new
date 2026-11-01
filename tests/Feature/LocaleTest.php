<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocaleTest extends TestCase
{
    public function test_login_page_defaults_to_greek(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Σύνδεση', false)
            ->assertSee('ΕΛ', false);
    }

    public function test_locale_cookie_switches_the_interface_to_english(): void
    {
        $response = $this->from('/login')->post('/locale', ['locale' => 'en']);

        $response->assertRedirect('/login');
        $response->assertCookie('locale', 'en');

        $this->withCookie('locale', 'en')
            ->get('/login')
            ->assertOk()
            ->assertSee('Sign in', false)
            ->assertDontSee('Συνδεθείτε με τον λογαριασμό του γραφείου.', false);
    }

    public function test_locale_rejects_unknown_languages(): void
    {
        $this->from('/login')
            ->post('/locale', ['locale' => 'fr'])
            ->assertSessionHasErrors('locale');
    }

    public function test_english_and_greek_files_share_the_same_keys(): void
    {
        $files = glob(lang_path('en/*.php'));
        $this->assertNotEmpty($files);

        foreach ($files as $file) {
            $name = basename($file);
            $english = require $file;
            $greek = require lang_path('el/'.$name);

            $this->assertSame($this->keys($english), $this->keys($greek), $name);
        }
    }

    /**
     * @param  array<mixed>  $lines
     * @return list<string>
     */
    private function keys(array $lines, string $prefix = ''): array
    {
        $keys = [];

        foreach ($lines as $key => $value) {
            $full = $prefix === '' ? (string) $key : $prefix.'.'.$key;

            if (is_array($value)) {
                $keys = array_merge($keys, $this->keys($value, $full));

                continue;
            }

            $keys[] = $full;
        }

        sort($keys);

        return $keys;
    }
}
