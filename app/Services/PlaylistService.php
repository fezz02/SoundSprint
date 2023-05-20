<?php

namespace App\Services;

use App\Models\Playlist;
use App\Models\Track;
use App\Models\Artist;
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


        $tracks->each(function($item) use ($fields, $fillables, $playlist) {
            $fillableTrack = array_intersect_key((array) $item->track, $fillables);
            $album = (new AlbumService())->create($item->track->album);
            $fillableTrack = array_merge($fillableTrack, ['album_id' => $album->id]);
            //dd($fillableTrack);
            $newTrack = Track::updateOrCreate($fillableTrack);

            foreach($item->track->artists as $artist){
                $newTrack->artists()->create([
                    'spotify_artist_id' => $artist->id,
                    'name' => $artist->name,
                    'href' => $artist->href,
                    'spotify_href' => $artist->external_urls->spotify
                ]);
            }
            
            //$newTrack->album()->sync($album);
            $playlist->tracks()->attach($newTrack);
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

        //$trackRefs = $tracks->pluck('href')->toArray();

        //dd($trackRefs);
        //dd($createdTracks);

        /*
        $createdTracks = Track::query()
            ->whereIn('href', $trackRefs)
            ->get();


        $playlist->tracks()->sync($createdTracks);
        */

        return $playlist;
    }
}