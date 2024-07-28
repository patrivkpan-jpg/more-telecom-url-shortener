<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlShortenerRequest;
use App\Jobs\SendShortenedUrlEmail;
use App\Models\OrginalLink;
use App\Models\ShortenedLink;
use Illuminate\Support\Str;

class UrlShortener extends Controller
{
    /**
     * Shorten user provided URL and return and email a shortened URL
     * @param \App\Http\Requests\UrlShortenerRequest $request
     * @return string
     */
    public function shortenUrl(UrlShortenerRequest $request)
    {
        $path = Str::random(10);
        while (ShortenedLink::where('path', $path)->exists()) {
            $path = Str::random(10);
        }

        // Add the original link to the database or retrieve the db record if original link as already been inserted
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

        $email = $request->get('email');
        $url = env('APP_URL') . $shortenedLink->path;
        // Dispatch job to send email
        SendShortenedUrlEmail::dispatchIf(isset($email), $email, $url);
        return $url;
    }

    /**
     * Redirect to original URL from shortened URL
     * @param mixed $path
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function retrieveUrl($path)
    {
        $link = ShortenedLink::where('path', $path)
            ->with('originalLink')
            ->first();
        return redirect($link->originalLink->link);
    }
}
