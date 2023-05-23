<?php

namespace App\Services;

use App\Models\Album;
use App\Models\Image;
use App\Models\Artist;

class AlbumService {

    public function create(object $albumItem): Album
    {
        $album = Album::updateOrCreate([
            'spotify_album_id' => $albumItem->id,
            'name' => $albumItem->name,
            'href' => $albumItem->href,
            'type' => $albumItem->album_type,
            'released_at' => $albumItem->release_date,
        ]);

        foreach($albumItem->images as $img){
            $album->images()->create([
                'url' => $img->url,
                'height' => $img->height,
                'width' => $img->width
            ]);
        }

        //$album->images()->sync($imgs);7
        foreach($albumItem->artists as $art){
            $album->artists()->create([
                'spotify_artist_id' => $art->id,
                'name' => $art->name,
                'href' => $art->href,
                'spotify_href' => $art->external_urls->spotify
            ]);
        }

        return $album;
    }
}