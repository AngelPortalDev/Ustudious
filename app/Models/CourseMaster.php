<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\Utils;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseMaster extends Model
{
    use HasFactory, SoftDeletes;
    public $timestamps = false;
    public $table = 'course_master';
    protected $guarded  = [];
    protected $client;
    public function __construct()
    {
        parent::__construct();
        $this->client = new Client([
            'timeout'  => 3000, // 10 minutes
            'max_connections' => 15,
            'connect_timeout' => 300,
        ]);
    }
    protected $fillable = [
        'id',
        'course_name',
        'subheading',
        'course_types',
        'mode_of_study',
        'course_category',
        'course_fees',
        'administrative_cost',
        'bn_collection_id',
        'total_cost',
        'course_overview',
        'course_curriculum',
        'course_opportunities',
        'application_procedure',
        'thumbnail_img',
        'trailor_thumbnail',
        'course_trailor',
        'course_status',
        'deleted_at',
        'created_by',
        'updated_at',
        'created_at',
    ];


    public function createCollectionIdOnBunnyStream($libraryId, $collectionName)
    {
        $client = new Client();
        $headers = [
            'AccessKey' => env('BUNNY_STREAM_KEY'),
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ];

        $body = json_encode([
            'name' => $collectionName,
        ]);

        $request = new Request('POST', "https://video.bunnycdn.com/library/{$libraryId}/collections", $headers, $body);

        try {
            $res = $client->send($request);

            if ($res->getStatusCode() === 200) {
                $data = $res->getBody();
                $response = json_decode($data, true);

                if (json_last_error() === JSON_ERROR_NONE) {
                    return [
                        'code' => $res->getStatusCode(),
                        'data' => $response,
                    ];
                } else {
                    return [
                        'code' => 500,
                        'message' => 'Invalid JSON response received.'
                    ];
                }
            } else {
                return [
                    'code' => $res->getStatusCode(),
                    'message' => 'Failed to create collection on Bunny Stream.'
                ];
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            return [
                'code' => $response->getStatusCode(),
                'message' => 'An error occurred while creating the collection: ' . $response->getReasonPhrase()
            ];
        } catch (\Exception $e) {
            return [
                'code' => 500,
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ];
        }
    }

    public function createVideoIdOnBunnyStream($libraryId, $title, $collectionId)
    {
        $client = new Client();
        $headers = [
            'AccessKey' => env('BUNNY_STREAM_KEY'),
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ];
        $body = json_encode([
            'title' => $title,
            'collectionId' => $collectionId
        ]);
        $request = new Request('POST', "https://video.bunnycdn.com/library/{$libraryId}/videos", $headers, $body);
        try {
            $res = $client->send($request);

            if ($res->getStatusCode() === 200) {
                $data = $res->getBody();
                $response = json_decode($data, true);

                if (json_last_error() === JSON_ERROR_NONE) {
                    return [
                        'code' => $res->getStatusCode(),
                        'data' => $response,
                    ];
                } else {
                    return [
                        'code' => 500,
                        'message' => 'Invalid JSON response received.'
                    ];
                }
            } else {
                return [
                    'code' => $res->getStatusCode(),
                    'message' => 'Failed to create collection on Bunny Stream.'
                ];
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            return [
                'code' => $response->getStatusCode(),
                'message' => 'An error occurred while creating the collection: ' . $response->getReasonPhrase()
            ];
        } catch (\Exception $e) {
            return [
                'code' => 500,
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ];
        }
    }

    public function uploadVideoIdOnBunnyStream($libraryId, $videoID, $course_trailor)
    {
        $headers['Content-Type'] = 'application/octet-stream';
        $headers['AccessKey'] = env('BUNNY_STREAM_KEY');
        $stream = fopen($course_trailor, 'r');
        $content['body'] = new Stream($stream);
        $content['video_id'] = $videoID;

        $videoUploadData = $this->BunnyStreamApiRequest('PUT', 'DEFAULT', $content, $headers, $libraryId);

        if (isset($videoUploadData) && !empty($videoUploadData['success']) && $videoUploadData['success'] === true) {

            return ['status' => TRUE, 'videoId' => $content['video_id']];
        }
        return ['status' => FALSE];
    }

    public function updateCollectionIdOnBunnyStream($libraryId, $collectionName, $collectionId)
    {

        $client = new Client();
        $headers = [
            'AccessKey' => env('BUNNY_STREAM_KEY'),
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ];
        $body = json_encode([
            'name' => $collectionName,
        ]);
        
        $request = new Request('POST', "https://video.bunnycdn.com/library/{$libraryId}/collections/{$collectionId}", $headers, $body);

        try {
            $res = $client->send($request);
            
            if ($res->getStatusCode() === 200) {
                $data = $res->getBody();

                $response = json_decode($data, true);

                if (json_last_error() === JSON_ERROR_NONE) {
                    return [
                        'code' => $res->getStatusCode(),
                        'data' => $response,
                    ];
                } else {
                    return [
                        'code' => 500,
                        'message' => 'Invalid JSON response received.'
                    ];
                }
            } else {
                return [
                    'code' => $res->getStatusCode(),
                    'message' => 'Failed to retrieve data from the video library.'
                ];
            }
        } catch (ClientException $e) {
            $response = $e->getResponse();
            return [
                'code' => $response->getStatusCode(),
                'message' => 'An error occurred while retrieving the video: ' . $response->getReasonPhrase()
            ];
        } catch (\Exception $e) {
            return [
                'code' => 500,
                'message' => 'An unexpected error occurred: ' . $e->getMessage()
            ];
        }
    }
    protected function BunnyStreamApiRequest($method, $urltype, $content = [], $header, $library)
    {

        if (isset($method) && !empty($method)  && is_array($content) && isset($urltype) && !empty($urltype) && isset($header) && is_array($header) && isset($library) && !empty($library) && Auth::check()) {
            try {
                $url = "https://video.bunnycdn.com/library/$library/";
                $body = isset($content['body']) ? json_encode($content['body']) : null;

                if ($urltype === 'DEFAULT') { // Other Common End point
                    $url .=  isset($content['video_id']) && !empty($content['video_id']) ? "videos/" . $content['video_id'] : '';
                    $body = isset($content['body']) ? $content['body'] : null;
                } elseif ($urltype === 'CREATE') { // Upload Video End point for video upload
                    $url .=  "videos";
                } elseif ($urltype === 'COLLECTION') { // Collection End Point  for Create Collection
                    $url .= "collections/";
                } else if ($urltype === 'THUMBNAIL') {
                    $url .=  isset($content['video_id']) && !empty($content['video_id']) ? "videos/" . $content['video_id'] . '/thumbnail' : '';
                    $body = isset($content['body']) ? $content['body'] : null;
                } else if ($urltype === 'VIDEODETAILS') {
                    $url .=  isset($content['video_id']) && !empty($content['video_id']) ? "videos/" . $content['video_id'] : '';
                } else if ($urltype == 'COLLECTIONDELTE') {
                    $url .=  isset($content['collection_id']) && !empty($content['collection_id']) ? "collections/" . $content['collection_id'] : '';
                }
                //dd($method ,$url, $header, $body);
                $request = new Request($method, $url, $header, $body);

                // if($urltype === 'CREATE'){

                //     $res = $this->client->send($request);
                // }else{
                $res = $this->client->sendAsync($request)->wait();

                // }
                // print_r($res);
                // die;
                $data =  $res->getBody()->getContents();
                $response = json_decode($data, true);
                // fclose($stream);
                return $response;
            } catch (\Throwable $th) {
                return $th;
            }
        }
        return FALSE;
    }
    public function programType()
    {
        return $this->belongsTo(ProgramType::class, 'course_types', 'course_types_id');
    }
    public function coursecategory()
    {
        return $this->belongsTo(CourseCategory::class, 'course_category', 'id');
    }
}
