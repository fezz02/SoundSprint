<?php

namespace App\Services;

use App\Models\Playlist;
use App\Models\Track;
use App\Models\Artist;
use App\Enums\Status;
use App\Enums\Game;
use App\Models\Album;
use App\Models\Image;

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

        $itemCollection = collect($fields->tracks->items);

        $data = $itemCollection->map(function ($item) {
            $album = $item->track->album;
            $artists = $item->track->artists;

            $albumData = [
                'id' => hexdec($album->id),
                'name' => $album->name,
                'href' => $album->href,
                'type' => $album->album_type,
                'released_at' => $album->release_date
            ];

            $imagesData = collect($album->images)->map(function ($image) use ($album) {
                return [
                    'imageable_id' => hexdec($album->id),
                    'imageable_type' => 'App\Models\Album',
                    'url' => $image->url,
                    'width' => $image->width,
                    'height' => $image->height
                ];
            })->toArray();

            $artistsData = collect($artists)->map(function ($artist) use ($item) {
                return [
                    'id' => hexdec($artist->id),
                    'artable_id' => hexdec($item->track->id),
                    'artable_type' => 'App\Models\Track',
                    'name' => $artist->name,
                    'href' => $artist->href,
                    'spotify_href' => $artist->external_urls->spotify
                ];
            })->toArray();

            $trackData = [
                'id' => hexdec($item->track->id),
                'album_id' => hexdec($album->id),
                'name' => $item->track->name,
                'href' => $item->track->href,
                'duration_ms' => $item->track->duration_ms,
                'popularity' => $item->track->popularity,
                'preview_url' => $item->track->preview_url,
                'explicit' => $item->track->explicit
            ];

            return [
                'albums' => $albumData,
                'images' => $imagesData,
                'artists' => $artistsData,
                'tracks' => $trackData,
            ];
        });

        $albums = $data->pluck('albums')->toArray();
        $images = $data->pluck('images')->flatten(1)->toArray();
        $artists = $data->pluck('artists')->flatten(1)->toArray();
        $tracks = $data->pluck('tracks')->toArray();

        Album::upsert($albums, ['name', 'href'], ['name', 'href']);
        Image::upsert($images, ['url', 'width', 'height'], ['url', 'width', 'height']);
        Artist::upsert($artists, ['name', 'href'], ['artable_id', 'spotify_artist_id', 'name', 'href']);
        Track::upsert($tracks, ['name', 'href'], ['name', 'album_id', 'href', 'duration_ms', 'popularity', 'preview_url', 'explicit']);

        $trackIds = collect($tracks)->pluck('id')->toArray();

        $playlist->tracks()->sync($trackIds);
        
        return $playlist;
    }
}