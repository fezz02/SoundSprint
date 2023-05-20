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

        $imgs = [];
        foreach($albumItem->images as $img){
            $imgs[] = Image::create([
                'imageable-_ds'
                'url' => $img->url,
                'height' => $img->height,
                'width' => $img->width
            ]);
        }

        $album->images()->sync($imgs);

        $artists = [];
        foreach($albumItem->artists as $art){
            $artists[] = Artist::create([

            ]);
        }

        $album->images()->sync($artists);

        return $album;
    }
}