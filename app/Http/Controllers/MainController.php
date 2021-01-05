<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Request;
use Softonic\GraphQL\ClientBuilder;

/**
 * Class MainController
 * @package App\Http\Controllers
 *
 * @property string $pageType
 * @property string $entityId
 */
class MainController extends Controller
{
    const TYPE_PAGE_CATEGORY = 'category';
    const TYPE_PAGE_ANNOUNCEMENT = 'announcement';
    const TYPE_PAGE_REDIRECT = 'redirect';
    const TYPE_PAGE_USER = 'user';
    const TYPE_PAGE_PROFILE = 'profile';
    const TYPE_PAGE_STATIC = 'static';

    const SERVICE_CATEGORY = null;
    const SERVICE_ANNOUNCEMENT = null;
    const SERVICE_REDIRECT = null;
    const SERVICE_USER = null;
    const SERVICE_PROFILE = ProfileService::class;
    const SERVICE_STATIC = HomeService::class;

    protected $pageType;
    protected $entityId;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index()
    {
        $url = '';
        foreach (Request::segments() as $segment) {
            $url .= '/' . $segment;
        }

        $page = null;
        $client = ClientBuilder::build(env('API_GOLAND', 'http://localhost:9011/query'));
        $query = '
            query ($url: String!) {
                getPageByUrl(url: $url) {
                    id
                    url
                    redirect{
                        url
                        code
                    }
                    entity{
                        id
                        type
                    }
                }
            }
        ';
        $variables = [
            'url' => $url ? $url : '/',
        ];
        $response = $client->query($query, $variables);
        $data = $response->getData();

        if (isset($data['getPageByUrl'])) {
            $page = $data['getPageByUrl'];
            $pageType = $page['entity'];
            if (is_null($page['redirect'])) {
                $this->pageType = $pageType['type'];
                $this->entityId = $pageType['id'];
            } else {
                if (isset($page['redirect']) && isset($page['redirect']['url'])) {
                    return redirect($page['redirect']['url']);
                } else {
                    abort(404);
                }
            }
        }

        $serviceName = $this->getServices()[$this->pageType];
        $service = new $serviceName;
        $service->index();
    }

    /**
     * @return array
     */
    protected function getServices()
    {
        return [
            self::TYPE_PAGE_CATEGORY => self::SERVICE_CATEGORY,
            self::TYPE_PAGE_ANNOUNCEMENT => self::SERVICE_ANNOUNCEMENT,
            self::TYPE_PAGE_REDIRECT => self::SERVICE_REDIRECT,
            self::TYPE_PAGE_USER => self::SERVICE_USER,
            self::TYPE_PAGE_PROFILE => self::SERVICE_PROFILE,
            self::TYPE_PAGE_STATIC => self::SERVICE_STATIC,
        ];
    }
}
