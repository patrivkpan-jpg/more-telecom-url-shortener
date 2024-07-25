<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlShortenerRequest;
use App\Models\OrginalLink;
use App\Models\ShortenedLink;
use Illuminate\Support\Str;

class UrlShortener extends Controller
{
    public function shortenUrl(UrlShortenerRequest $request)
    {
        $path = Str::random(10);
        while (ShortenedLink::where('path', $path)->exists()) {
            $path = Str::random(10);
        }

        $originalLink = new OrginalLink;
        $originalLink = OrginalLink::firstOrNew(
            [
                'link' => $request->get('link')
            ]
        );
        $originalLink->save();

        $originalLinkId = $originalLink->id;
        $shortenedLink = new ShortenedLink;
        $shortenedLink->path = $path;
        $shortenedLink->original_links_id = $originalLinkId;
        $shortenedLink->save();

        return $shortenedLink->path;
    }

    public function retrieveUrl($path)
    {
        $link = ShortenedLink::where('path', $path)
            ->with('originalLink')
            ->first();
        return redirect($link->originalLink->link);
    }
}
