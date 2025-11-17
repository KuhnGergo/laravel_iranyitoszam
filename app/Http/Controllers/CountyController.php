<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountyRequest;
use App\Mail\CountiesMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class CountyController extends Controller
{

    public function index(Request $request)
    {
        $needle = $request->get('needle');

        try {
            $url = $needle ? "counties?needle=" . urlencode($needle) : "counties";

            $response = Http::api()->get($url);

            if ($response->failed()) {
                $message = $response->json('message') ?? 'Ismeretlen hiba történt.';
                return redirect()
                    ->route('counties.index')
                    ->with('error', "Hiba történt a lekérdezés során: $message");
            }

            $counties = $this->getCounties($response);

            return view('counties.index', ['entities' => $counties, 'isAuthenticated' => $this->isAuthenticated()]);

        } catch (\Exception $e) {
            return redirect()
                ->route('counties.index')
                ->with('error', "Nem sikerült betölteni a megyéket: " . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $response = Http::api()->get("/counties/$id");

            if ($response->failed()) {
                $message = $response->json('message') ?? 'A megye nem található vagy hiba történt.';
                return redirect()
                    ->route('counties.index')
                    ->with('error', "Hiba: $message");
            }
            $county = $this->getCounty($response);

            if (!$county) {
                return redirect()
                    ->route('counties.index')
                    ->with('error', "A megye adatai nem érhetők el.");
            }

            return view('counties.show', ['entity' => $county]);

        } catch (\Exception $e) {
            return redirect()
                ->route('counties.index')
                ->with('error', "Nem sikerült betölteni a megye adatait: " . $e->getMessage());
        }
    }


    public function create()
    {
        return view('counties.create');
    }

    public function store(CountyRequest $request)
    {
        $name = $request->get('name');

        try {
            $response = Http::api()
                ->withToken($this->token)
                ->post('/counties', ['name' => $name]);

            if ($response->failed()) {
                // Ha az API válaszolt, de hibás státuszkóddal (pl. 422, 403, 500)
                $message = $response->json('message') ?? 'Nem sikerült létrehozni a megyét.';
                return redirect()
                    ->route('counties.index')
                    ->with('error', "Hiba: $message");
            }

            return redirect()
                ->route('counties.index')
                ->with('success', "$name megye sikeresen létrehozva!");

        } catch (\Exception $e) {
            // Hálózati vagy JSON dekódolási hiba
            return redirect()
                ->route('counties.index')
                ->with('error', "Nem sikerült kommunikálni az API-val: " . $e->getMessage());
        }
    }


    public function edit($id)
    {
        try {
            $response = Http::api()->get("/counties/$id");

            if ($response->failed()) {
                $message = $response->json('message') ?? 'A megye nem található vagy hiba történt.';
                return redirect()
                    ->route('counties.index')
                    ->with('error', "Hiba: $message");
            }

            $county = $this->getCounty($response);

            if (!$county) {
                return redirect()
                    ->route('counties.index')
                    ->with('error', "A megye adatai nem érhetők el.");
            }

            return view('counties.edit', ['entity' => $county]);

        } catch (\Exception $e) {
            return redirect()
                ->route('counties.index')
                ->with('error', "Nem sikerült betölteni a megye szerkesztő nézetét: " . $e->getMessage());
        }
    }

    public function update(CountyRequest $request, $id)
    {
        $name = $request->get('name');

        try {
            $response = Http::api()
                ->withToken($this->token)
                ->put("/counties/$id", ['name' => $name]);

            if ($response->successful()) {
                return redirect()
                    ->route('counties.index')
                    ->with('success', "$name megye sikeresen frissítve!");
            }

            // Ha nem sikeres, de nem dobott kivételt (pl. 422)
            $errorMessage = $response->json('message') ?? 'Ismeretlen hiba történt.';
            return redirect()
                ->route('counties.index')
                ->with('error', "Hiba történt: $errorMessage");

        } catch (\Exception $e) {
            // Hálózati vagy egyéb kivétel
            return redirect()
                ->route('counties.index')
                ->with('error', "Nem sikerült frissíteni: " . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $response = Http::api()
                ->withToken($this->token)
                ->delete("/counties/$id", ['id' => $id]);

            if ($response->failed()) {
                $message = $response->json('message') ?? 'Nem sikerült törölni a megyét.';
                return redirect()
                    ->route('counties.index')
                    ->with('error', "Hiba: $message");
            }

            return redirect()
                ->route('counties.index')
                ->with('success', "Megye sikeresen törölve!");

        } catch (\Exception $e) {
            return redirect()
                ->route('counties.index')
                ->with('error', "Nem sikerült kommunikálni az API-val: " . $e->getMessage());
        }
    }

	// Segédfüggvény az adatok kinyeréséhez a response-ból
    private function getCounties($response)
    {
        $responseBody = json_decode($response->body(), false); // objektumként dekódoljuk
        $data = $responseBody->data ?? null;
        $results = [];

        if (!empty($data)) {
            $results = $data->counties ?? [];
        }

        return $results;
    }

    private function getCounty($response)
    {
        $responseBody = json_decode($response->body(), false); // objektumként dekódoljuk
        $data = $responseBody->data ?? null;
        $result = [];

        if (!empty($data)) {
            $result = $data->county ?? [];
        }

        return $result;
    }
}
