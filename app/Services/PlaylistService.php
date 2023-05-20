<?php

namespace App\Services;

use App\Models\Playlist;
use App\Models\Track;
use App\Enums\Status;
use App\Enums\Game;

use App\Services\AlbumService;

class PlaylistService {

    public function create(object $fields): Playlist
    {
        $playlist = Playlist::updateOrcreate([
            'user_id' => null,
            'name' => $fields->name,
            'href' => $fields->href,
            'description' => $fields->description,
            'followers' => $fields->followers->total
        ]);

        //dd($fields);
        $fillables = array_flip((new Track())->getFillable());
        $tracks = collect($fields->tracks->items)
            //->map(fn($item) => (array) $item->track)
            ->map(function ($item) use ($fillables) {
                //$fillableTrack = array_intersect_key((array) $item->track, $fillables);
                //dd($fillableTrack);
                return $item;
            });

        //dd($tracks);


        $tracks->each(function($item) use ($fields, $fillables) {
            $fillableTrack = array_intersect_key((array) $item->track, $fillables);
            $t = Track::updateOrCreate($fillableTrack);
            dd($item->track->album);

            $album = (new AlbumService())->create($item->track->album);
            

            $imgs = collect($item->track->album->images)->map(function($img){
                return new \App\Models\Image($img);
            });

            $album->images()->sync($imgs);
            //$t->album()->sync($fields->images);
            dd($t);
        });
        /*
        Track::upsert($tracks->toArray(), ['name','href'],
        [
            'name',
            'href',
            'duration_ms',
            'popularity',
            'preview_url',
            'explicit'
        ]);
        */

        $trackRefs = $tracks->pluck('href')->toArray();

        //dd($trackRefs);
        //dd($createdTracks);

        $createdTracks = Track::query()
            ->whereIn('href', $trackRefs)
            ->get();


        $playlist->tracks()->sync($createdTracks);

        return $playlist;
    }
}